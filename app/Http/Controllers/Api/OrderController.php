<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * List user orders
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'coupon'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Create order from cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
            'billing_address_id' => 'nullable|exists:addresses,id',
            'payment_method' => 'required|in:razorpay,cod',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string|required_if:payment_method,razorpay',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
        ]);

        $user = $request->user();

        // Get cart items
        $cartItems = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
            ], 400);
        }

        // Get addresses
        $shippingAddress = \App\Models\Address::where('user_id', $user->id)
            ->findOrFail($request->shipping_address_id);

        $billingAddress = $request->billing_address_id 
            ? \App\Models\Address::where('user_id', $user->id)->findOrFail($request->billing_address_id)
            : $shippingAddress;

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        // Apply coupon if provided
        $coupon = null;
        $couponDiscount = 0;
        
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            
            if ($coupon && $coupon->isValid($subtotal, [], $user->id)) {
                $couponDiscount = $coupon->calculateDiscount($subtotal);
            }
        }

        // Calculate shipping (placeholder - use shipping controller)
        $shippingCharge = 50; // Default shipping charge

        $totalAmount = $subtotal - $couponDiscount + $shippingCharge;

        DB::beginTransaction();
        try {
            // Create order
            $orderData = [
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id' => $user->id,
                'status' => 'pending',
                'status_locked' => false,
                'total_amount' => $totalAmount,
                'shipping_charge' => $shippingCharge,
                'coupon_id' => $coupon?->id,
                'coupon_discount' => $couponDiscount,
                'shipping_address' => $shippingAddress->toArray(),
                'billing_address' => $billingAddress->toArray(),
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : ($request->razorpay_payment_id ? 'paid' : 'pending'),
                'notes' => $request->notes,
            ];

            // Add Razorpay payment details if provided
            if ($request->payment_method === 'razorpay' && $request->razorpay_payment_id) {
                $orderData['razorpay_order_id'] = $request->razorpay_order_id;
                $orderData['razorpay_payment_id'] = $request->razorpay_payment_id;
                $orderData['razorpay_signature'] = $request->razorpay_signature;
            }

            $order = Order::create($orderData);

            // Create order items and update inventory
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                
                // Check stock again before creating order
                if ($cartItem->size || $cartItem->color) {
                    $stock = $product->getStockForColorSize($cartItem->color, $cartItem->size);
                    if ($stock < $cartItem->quantity) {
                        throw new \Exception("Insufficient stock for {$product->name}");
                    }
                    
                    // Update inventory
                    $inventory = Inventory::where('product_id', $product->id)
                        ->where('color', $cartItem->color)
                        ->where('size', $cartItem->size)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity -= $cartItem->quantity;
                        $inventory->sold_quantity += $cartItem->quantity;
                        $inventory->save();
                    }
                } else {
                    if ($product->stock < $cartItem->quantity) {
                        throw new \Exception("Insufficient stock for {$product->name}");
                    }
                    
                    $product->stock -= $cartItem->quantity;
                    $product->save();
                }

                // Create order item
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->current_price,
                    'size' => $cartItem->size,
                    'color' => $cartItem->color,
                    // Legacy fields
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'total' => $cartItem->subtotal,
                ]);
            }

            // Apply coupon usage
            if ($coupon) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_amount' => $couponDiscount,
                    'order_amount' => $subtotal,
                ]);

                $coupon->used_count++;
                $coupon->save();
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            // Send order confirmation email
            try {
                Mail::send('emails.order-confirmation', ['order' => $order->load('items.product')], function ($message) use ($user, $order) {
                    $message->to($user->email, $user->name)
                        ->subject("Order Confirmation - {$order->order_number}");
                });
            } catch (\Exception $e) {
                \Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order->load(['items.product', 'coupon']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order details
     */
    public function show(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'coupon'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Get order invoice (PDF)
     */
    public function invoice(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'coupon'])
            ->findOrFail($id);

        // TODO: Generate PDF invoice
        // For now, return JSON data
        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'PDF invoice generation will be implemented',
        ]);
    }
}

