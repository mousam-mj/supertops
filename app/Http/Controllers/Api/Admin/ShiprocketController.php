<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShiprocketOrderSyncService;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketController extends Controller
{
    /**
     * Create Shiprocket order/shipment for an order
     */
    public function createShipment(Request $request, $id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        $result = app(ShiprocketOrderSyncService::class)->sync($order);
        $order->refresh();

        $report = $this->shipmentReport($order, $result);

        if (! ($result['success'] ?? false)) {
            Log::warning('Shiprocket create order failed', ['order_id' => $order->id, 'result' => $result]);

            return response()->json($report, 400);
        }

        return response()->json($report);
    }

    /**
     * @param  array<string, mixed>  $result
     * @return array<string, mixed>
     */
    private function shipmentReport(Order $order, array $result): array
    {
        $reason = $this->readableReason($result['message'] ?? null);
        $alreadySent = ($result['success'] ?? false) && ($result['skipped'] ?? false);
        $success = (bool) ($result['success'] ?? false);

        if ($alreadySent) {
            $status = 'already_sent';
            $message = 'This order was already sent to Shiprocket.';
        } elseif ($success) {
            $status = 'success';
            $message = 'Shipment created in Shiprocket.';
        } else {
            $status = 'failed';
            $message = 'Shipment was not created.';
        }

        return [
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'reason' => $reason,
            'steps' => $this->stepsFor($status, $reason),
            'order_number' => $order->order_number,
            'data' => [
                'shiprocket_order_id' => $order->shiprocket_order_id,
                'shiprocket_shipment_id' => $order->shiprocket_shipment_id,
                'shiprocket_awb' => $order->shiprocket_awb,
            ],
        ];
    }

    private function readableReason(mixed $message): string
    {
        if (is_string($message) && trim($message) !== '') {
            return trim($message);
        }

        if (is_array($message)) {
            $parts = [];
            foreach ($message as $key => $value) {
                $text = is_array($value) ? implode(', ', array_map('strval', $value)) : (string) $value;
                $parts[] = is_string($key) ? $key.': '.$text : $text;
            }

            $joined = implode(' | ', array_filter($parts));
            if ($joined !== '') {
                return $joined;
            }
        }

        return 'Shiprocket did not return a reason.';
    }

    /**
     * @return list<string>
     */
    private function stepsFor(string $status, string $reason): array
    {
        if ($status === 'success') {
            return [
                'Open Shiprocket and go to Orders → New.',
                'Search this order number. It should be in that list.',
                'Assign a courier there to get an AWB. Admin keeps showing Not shipped until an AWB exists.',
            ];
        }

        if ($status === 'already_sent') {
            return [
                'Do not create this order again.',
                'In Shiprocket open Orders → New and search this order number.',
                'If it is missing there, the earlier create did not really land. Clear shiprocket_order_id on this order only after you confirm it is not in Shiprocket, then try again.',
                'Assign a courier in Shiprocket to generate the AWB.',
            ];
        }

        $reason = strtolower($reason);

        if (str_contains($reason, 'access forbidden') || str_contains($reason, 'api user') || str_contains($reason, 'blocked this login')) {
            return [
                'In Shiprocket open Settings → API → Create API User.',
                'Use an email that is different from the panel login (perchbypexpo@gmail.com cannot call the API).',
                'Allow the Orders module for that API user.',
                'Put that API email and password in the server .env as SHIPROCKET_EMAIL and SHIPROCKET_PASSWORD. The live site does not use the .env on your laptop.',
                'On the server run: php artisan config:clear',
                'Click the truck icon on this order again.',
            ];
        }

        if (str_contains($reason, 'not configured')) {
            return [
                'Add SHIPROCKET_EMAIL and SHIPROCKET_PASSWORD to the server .env.',
                'Use an API user from Shiprocket Settings → API, not the panel login.',
                'Run php artisan config:clear on the server, then click the truck icon again.',
            ];
        }

        if (str_contains($reason, 'pickup')) {
            return [
                'In Shiprocket open Settings → Pickup Addresses and confirm a warehouse is saved.',
                'Set SHIPROCKET_PICKUP_LOCATION to that warehouse nickname, exactly as Shiprocket shows it.',
                'Set SHIPROCKET_PICKUP_POSTCODE to that warehouse pincode.',
                'Run php artisan config:clear, then create the shipment again.',
            ];
        }

        if (str_contains($reason, 'phone')) {
            return [
                'Open this order and check the customer phone.',
                'Shiprocket needs a 10-digit Indian mobile number, without +91.',
                'Save the order, then click the truck icon again.',
            ];
        }

        if (str_contains($reason, 'pincode') || str_contains($reason, 'address') || str_contains($reason, 'city') || str_contains($reason, 'state')) {
            return [
                'Open this order and fill address line, city, state, and a 6-digit pincode.',
                'Save the order, then click the truck icon again.',
            ];
        }

        if (str_contains($reason, 'payment')) {
            return [
                'Razorpay orders are sent to Shiprocket only after payment is paid.',
                'Confirm this payment in Razorpay, or mark the order paid in admin.',
                'Click the truck icon again.',
            ];
        }

        if (str_contains($reason, 'login failed') || str_contains($reason, 'invalid email') || str_contains($reason, 'unauth')) {
            return [
                'Check SHIPROCKET_EMAIL and SHIPROCKET_PASSWORD on the server.',
                'They must be the API user from Shiprocket Settings → API.',
                'Run php artisan config:clear so a cached token or old password is dropped.',
                'Click the truck icon again.',
            ];
        }

        return [
            'Read the reason above. That text is what Shiprocket returned.',
            'Fix the field it names on this order, or in Shiprocket settings.',
            'Click the truck icon again.',
        ];
    }

    /**
     * Track Shiprocket shipment
     */
    public function track(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (! $order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket order not created for this order',
            ], 400);
        }

        $service = app(ShiprocketService::class);
        $result = $service->track((int) $order->shiprocket_order_id);

        if (! $result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Tracking failed',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $result['data'] ?? [],
        ]);
    }
}
