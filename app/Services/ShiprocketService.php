<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShiprocketService
{
    protected string $baseUrl;
    protected ?string $email;
    protected ?string $password;
    protected string $pickupPostcode;

    protected string $pickupLocation;

    public function __construct()
    {
        $config = config('services.shiprocket', []);
        $this->baseUrl = rtrim($config['api_url'] ?? 'https://apiv2.shiprocket.in', '/');
        $this->email = $config['email'] ?? null;
        $this->password = $config['password'] ?? null;
        $this->pickupPostcode = $config['pickup_postcode'] ?? '110001';
        $this->pickupLocation = $config['pickup_location'] ?? 'Primary';
    }

    public function isConfigured(): bool
    {
        return ! empty($this->email) && ! empty($this->password);
    }

    /**
     * Get auth token (cached for 24 hours; Shiprocket tokens valid ~10 days)
     */
    public function getToken(): ?string
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $cacheKey = 'shiprocket_token';
        $token = Cache::get($cacheKey);
        if ($token) {
            return $token;
        }

        try {
            $response = Http::post("{$this->baseUrl}/v1/external/auth/login", [
                'email' => $this->email,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['token'] ?? null;
                if ($token) {
                    Cache::put($cacheKey, $token, now()->addHours(24));
                    return $token;
                }
            }
            Log::warning('Shiprocket login failed', ['response' => $response->body()]);
        } catch (\Throwable $e) {
            Log::error('Shiprocket auth error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Check serviceability and get shipping rate for a pincode
     *
     * @return array{serviceable: bool, shipping_charge: float, estimated_days: string, couriers?: array}
     */
    public function checkServiceability(string $deliveryPostcode, float $weightKg = 1, float $codAmount = 0): array
    {
        $token = $this->getToken();
        if (! $token) {
            return [
                'serviceable' => false,
                'shipping_charge' => 0,
                'estimated_days' => '',
            ];
        }

        try {
            $response = Http::withToken($token)
                ->get("{$this->baseUrl}/v1/external/courier/serviceability/", [
                    'pickup_postcode' => $this->pickupPostcode,
                    'delivery_postcode' => $deliveryPostcode,
                    'weight' => max(0.1, $weightKg),
                    'cod' => $codAmount > 0 ? 1 : 0,
                ]);

            if (! $response->successful()) {
                Log::warning('Shiprocket serviceability failed', ['body' => $response->body()]);
                return [
                    'serviceable' => false,
                    'shipping_charge' => 0,
                    'estimated_days' => '5-7 business days',
                ];
            }

            $data = $response->json();
            $data = $data['data'] ?? $data;
            $available = $data['available_courier_companies'] ?? $data['available_courier_companies_list'] ?? [];

            if (empty($available)) {
                return [
                    'serviceable' => false,
                    'shipping_charge' => 0,
                    'estimated_days' => '5-7 business days',
                ];
            }

            // Use first available courier's rate (or lowest)
            $first = is_array($available) ? (reset($available) ?: []) : [];
            if (isset($first['etd']) && is_string($first['etd'])) {
                $eta = $first['etd'];
            } else {
                $eta = $first['estimated_delivery_days'] ?? '3-5 business days';
            }
            $rate = (float) ($first['rate'] ?? $first['freight_charge'] ?? 0);

            return [
                'serviceable' => true,
                'shipping_charge' => $rate,
                'estimated_days' => is_string($eta) ? $eta : '3-5 business days',
                'couriers' => $available,
            ];
        } catch (\Throwable $e) {
            Log::error('Shiprocket serviceability error: ' . $e->getMessage());
            return [
                'serviceable' => false,
                'shipping_charge' => 0,
                'estimated_days' => '5-7 business days',
            ];
        }
    }

    /**
     * Create order/shipment in Shiprocket (adhoc)
     *
     * @param  array{order_number: string, total_amount: float, payment_method: string, shipping_address: array}  $order
     * @param  array<int, array{name: string, sku?: string, quantity: int, price: float}>  $items
     */
    public function createOrder(array $order, array $items, float $weightKg = 1): array
    {
        $token = $this->getToken();
        if (! $token) {
            return ['success' => false, 'message' => 'Shiprocket not configured or auth failed'];
        }

        $addr = $order['shipping_address'] ?? [];
        $firstName = trim((string) ($addr['first_name'] ?? ''));
        $lastName = trim((string) ($addr['last_name'] ?? ''));
        $name = trim(($addr['full_name'] ?? '') ?: trim($firstName.' '.$lastName));
        if ($name === '' && ! empty($order['customer_name'])) {
            $name = trim((string) $order['customer_name']);
            $parts = preg_split('/\s+/', $name, 2);
            $firstName = $firstName !== '' ? $firstName : ($parts[0] ?? 'Customer');
            $lastName = $lastName !== '' ? $lastName : ($parts[1] ?? '');
        }
        if ($firstName === '') {
            $firstName = 'Customer';
        }

        $address1 = trim((string) ($addr['address_line_1'] ?? $addr['address'] ?? ''));
        $address2 = trim((string) ($addr['address_line_2'] ?? ''));
        $city = trim((string) ($addr['city'] ?? ''));
        $state = trim((string) ($addr['state'] ?? ''));
        $pincode = trim((string) ($addr['pincode'] ?? ''));
        $phone = $this->normalizePhone((string) ($addr['phone'] ?? $order['customer_phone'] ?? ''));
        $email = trim((string) ($addr['email'] ?? $order['customer_email'] ?? ''));

        $orderItems = [];
        foreach ($items as $item) {
            $sku = trim((string) ($item['sku'] ?? ''));
            if ($sku === '') {
                $sku = 'ITEM-'.substr(md5(($item['name'] ?? 'product').($item['price'] ?? 0)), 0, 8);
            }

            $orderItems[] = [
                'name' => $item['name'] ?? 'Product',
                'sku' => $sku,
                'units' => (int) ($item['quantity'] ?? 1),
                'selling_price' => (float) ($item['price'] ?? 0),
            ];
        }

        $payload = [
            'order_id' => $order['order_number'],
            'order_date' => now()->format('Y-m-d H:i:s'),
            'pickup_location' => $this->pickupLocation,
            'channel_id' => '',
            'billing_customer_name' => $firstName,
            'billing_last_name' => $lastName,
            'billing_address' => $address1,
            'billing_address_2' => $address2,
            'billing_city' => $city,
            'billing_pincode' => $pincode,
            'billing_state' => $state,
            'billing_country' => 'India',
            'billing_email' => $email ?: 'noreply@perchlife.in',
            'billing_phone' => $phone,
            'shipping_is_billing' => true,
            'shipping_customer_name' => $firstName,
            'shipping_last_name' => $lastName,
            'shipping_address' => $address1,
            'shipping_address_2' => $address2,
            'shipping_city' => $city,
            'shipping_pincode' => $pincode,
            'shipping_state' => $state,
            'shipping_country' => 'India',
            'shipping_phone' => $phone,
            'order_items' => $orderItems,
            'payment_method' => (strtolower($order['payment_method'] ?? '') === 'cod') ? 'COD' : 'Prepaid',
            'sub_total' => (float) ($order['subtotal'] ?? $order['total_amount'] ?? 0),
            'length' => 10,
            'width' => 10,
            'height' => 10,
            'weight' => max(0.1, $weightKg),
            'courier_id' => '',
        ];

        try {
            $response = Http::withToken($token)
                ->asJson()
                ->post("{$this->baseUrl}/v1/external/orders/create/adhoc", $payload);

            $body = $response->json();

            if ($response->successful() && isset($body['order_id'])) {
                return [
                    'success' => true,
                    'order_id' => $body['order_id'] ?? null,
                    'shipment_id' => $body['shipment_id'] ?? null,
                    'status' => $body['status'] ?? null,
                    'data' => $body,
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $response->body(),
                'data' => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('Shiprocket create order error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Track shipment by order ID (Shiprocket order_id)
     */
    public function track(int $shiprocketOrderId): array
    {
        $token = $this->getToken();
        if (! $token) {
            return ['success' => false, 'message' => 'Shiprocket not configured'];
        }

        try {
            $response = Http::withToken($token)
                ->get("{$this->baseUrl}/v1/external/courier/track/awb/{$shiprocketOrderId}");

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }
            return ['success' => false, 'message' => $response->body()];
        } catch (\Throwable $e) {
            Log::error('Shiprocket track error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getPickupPostcode(): string
    {
        return $this->pickupPostcode;
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if (str_starts_with($digits, '91') && strlen($digits) === 12) {
            $digits = substr($digits, 2);
        }
        if (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }

        return $digits;
    }

    /**
     * Cancel a shipment
     */
    public function cancelShipment($shipmentId): array
    {
        $token = $this->getToken();
        if (! $token) {
            return ['success' => false, 'message' => 'Authentication failed'];
        }

        try {
            $response = Http::withToken($token)
                ->post("{$this->baseUrl}/v1/external/orders/cancel/shipment/awbs", [
                    'awbs' => [$shipmentId]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Shipment cancelled successfully'
                ];
            }
            
            Log::warning('Shiprocket cancel shipment failed', ['response' => $response->body()]);
            return ['success' => false, 'message' => $response->body()];
        } catch (\Throwable $e) {
            Log::error('Shiprocket cancel shipment error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
