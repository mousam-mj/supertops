<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class ShiprocketOrderSyncService
{
    public function sync(Order $order): array
    {
        $order->loadMissing('items.product');

        if ($order->shiprocket_order_id) {
            return [
                'success' => true,
                'message' => 'Shiprocket order already exists',
                'skipped' => true,
            ];
        }

        if (! in_array($order->payment_status, ['paid', 'completed'], true) && $order->payment_method === 'razorpay') {
            return [
                'success' => false,
                'message' => 'Order payment not completed',
                'skipped' => true,
            ];
        }

        $service = app(ShiprocketService::class);
        if (! $service->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Shiprocket not configured',
                'skipped' => true,
            ];
        }

        $shippingAddress = $this->normalizeShippingAddress($order);
        if (empty($shippingAddress['pincode']) || empty($shippingAddress['address_line_1'])) {
            Log::warning('Shiprocket sync skipped: incomplete shipping address', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);

            return [
                'success' => false,
                'message' => 'Shipping address incomplete',
            ];
        }

        $items = [];
        $totalQty = 0;
        foreach ($order->items as $item) {
            $sku = trim((string) ($item->product_sku ?? $item->product?->sku ?? ''));
            if ($sku === '') {
                $sku = 'PROD-'.($item->product_id ?? $item->id);
            }

            $items[] = [
                'name' => $item->product_name ?? $item->product?->name ?? 'Product',
                'sku' => $sku,
                'quantity' => (int) $item->quantity,
                'price' => (float) $item->price,
            ];
            $totalQty += (int) $item->quantity;
        }

        if ($items === []) {
            return [
                'success' => false,
                'message' => 'Order has no items',
            ];
        }

        $orderData = [
            'order_number' => $order->order_number,
            'subtotal' => (float) ($order->subtotal ?? $order->total_amount),
            'total_amount' => (float) $order->total_amount,
            'payment_method' => $order->payment_method ?? 'razorpay',
            'shipping_address' => $shippingAddress,
            'customer_phone' => $order->customer_phone ?? $shippingAddress['phone'] ?? '',
            'customer_email' => $order->customer_email ?? $shippingAddress['email'] ?? '',
        ];

        $weightKg = max(0.5, $totalQty * 0.5);
        $result = $service->createOrder($orderData, $items, $weightKg);

        if (! ($result['success'] ?? false)) {
            Log::warning('Shiprocket auto-sync failed', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'result' => $result,
            ]);

            return $result;
        }

        $order->shiprocket_order_id = $result['order_id'] ?? null;
        $order->shiprocket_shipment_id = $result['shipment_id'] ?? null;
        $order->shiprocket_awb = $result['data']['awb_code'] ?? $result['data']['awb'] ?? null;
        $order->shiprocket_data = $result['data'] ?? [];
        if ($order->status === 'pending') {
            $order->status = 'processing';
        }
        $order->save();

        Log::info('Shiprocket auto-sync succeeded', [
            'order_id' => $order->id,
            'shiprocket_order_id' => $order->shiprocket_order_id,
        ]);

        return $result;
    }

    private function normalizeShippingAddress(Order $order): array
    {
        $addr = is_array($order->shipping_address) ? $order->shipping_address : [];

        $firstName = trim((string) ($addr['first_name'] ?? ''));
        $lastName = trim((string) ($addr['last_name'] ?? ''));
        $addressLine = trim((string) ($addr['address_line_1'] ?? $addr['address'] ?? ''));
        $phone = trim((string) ($addr['phone'] ?? $order->customer_phone ?? ''));
        $email = trim((string) ($addr['email'] ?? $order->customer_email ?? ''));

        if ($firstName === '' && $lastName === '' && ! empty($order->customer_name)) {
            $parts = preg_split('/\s+/', trim((string) $order->customer_name), 2);
            $firstName = $parts[0] ?? 'Customer';
            $lastName = $parts[1] ?? '';
        }

        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if (str_starts_with($digits, '91') && strlen($digits) === 12) {
            $digits = substr($digits, 2);
        }
        if (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }

        return [
            'first_name' => $firstName !== '' ? $firstName : 'Customer',
            'last_name' => $lastName,
            'full_name' => trim($firstName.' '.$lastName) ?: (string) $order->customer_name,
            'address_line_1' => $addressLine,
            'address_line_2' => trim((string) ($addr['address_line_2'] ?? '')),
            'city' => trim((string) ($addr['city'] ?? '')),
            'state' => trim((string) ($addr['state'] ?? '')),
            'pincode' => trim((string) ($addr['pincode'] ?? '')),
            'phone' => $digits,
            'email' => $email,
        ];
    }
}
