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

        if (! ($result['success'] ?? false)) {
            Log::warning('Shiprocket create order failed', ['order_id' => $order->id, 'result' => $result]);

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to create Shiprocket order',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Shiprocket order created successfully',
            'data' => [
                'shiprocket_order_id' => $order->shiprocket_order_id,
                'shiprocket_shipment_id' => $order->shiprocket_shipment_id,
                'shiprocket_awb' => $order->shiprocket_awb,
            ],
        ]);
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
