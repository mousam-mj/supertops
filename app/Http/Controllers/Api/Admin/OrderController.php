<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * List all orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product', 'coupon']);

        // Filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', '%' . $search . '%')
                               ->orWhere('email', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        // Date range filter
        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Get order details
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'coupon'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Update order
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Check if order is locked
        if ($order->status_locked) {
            return response()->json([
                'success' => false,
                'message' => 'Order status is locked and cannot be updated',
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'sometimes|required|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|required|string|in:pending,paid,failed',
            'notes' => 'nullable|string',
            'shipping_charge' => 'sometimes|numeric|min:0',
        ]);

        $order->update($validated);

        // Send email notification if status changed
        if ($request->has('status') && $request->status != $order->getOriginal('status')) {
            try {
                \Illuminate\Support\Facades\Mail::send('emails.order-status-update', [
                    'order' => $order,
                    'oldStatus' => $order->getOriginal('status'),
                    'newStatus' => $order->status,
                ], function ($message) use ($order) {
                    $message->to($order->user->email, $order->user->name)
                        ->subject("Order Status Updated - {$order->order_number}");
                });
            } catch (\Exception $e) {
                \Log::error('Order status email failed: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order->fresh()->load(['user', 'items.product', 'coupon']),
        ]);
    }

    /**
     * Get order invoice (PDF)
     */
    public function invoice($id)
    {
        $order = Order::with(['user', 'items.product', 'coupon'])->findOrFail($id);

        // TODO: Generate PDF invoice
        // For now, return JSON data
        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'PDF invoice generation will be implemented',
        ]);
    }
}




