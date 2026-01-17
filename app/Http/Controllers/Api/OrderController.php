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
     * Create order from cart (supports both authenticated and guest users)
     */
    public function store(Request $request)
    {
        $isGuest = !$request->user();
        
        $validationRules = [
            'payment_method' => 'required|in:razorpay,cod',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string|required_if:payment_method,razorpay',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
        ];

        if ($isGuest) {
            $validationRules['guest_info'] = 'required|array';
            $validationRules['guest_info.first_name'] = 'required|string|max:255';
            $validationRules['guest_info.last_name'] = 'required|string|max:255';
            $validationRules['guest_info.email'] = 'required|email|max:255';
            $validationRules['guest_info.phone'] = 'required|string|max:20';
            $validationRules['guest_info.address'] = 'required|string';
            $validationRules['guest_info.city'] = 'required|string|max:255';
            $validationRules['guest_info.state'] = 'required|string|max:255';
            $validationRules['guest_info.pincode'] = 'required|string|max:10';
        } else {
            $validationRules['shipping_address_id'] = 'required_without:shipping_address|exists:addresses,id';
            $validationRules['billing_address_id'] = 'nullable|exists:addresses,id';
            $validationRules['shipping_address'] = 'required_without:shipping_address_id|array';
        }

        $request->validate($validationRules);

        $user = $request->user();
        $sessionId = $request->cookie('cart_session_id');

        // Get cart items
        if ($user) {
            $cartItems = Cart::where('user_id', $user->id)
                ->whereNull('session_id')
                ->with('product')
                ->get();
        } else {
            // Guest cart
            if (!$sessionId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty',
                ], 400);
            }
            $cartItems = Cart::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->with('product')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
            ], 400);
        }

        // Get addresses
        if ($isGuest) {
            $guestInfo = $request->guest_info;
            $shippingAddress = [
                'first_name' => $guestInfo['first_name'],
                'last_name' => $guestInfo['last_name'],
                'email' => $guestInfo['email'],
                'phone' => $guestInfo['phone'],
                'address' => $guestInfo['address'],
                'city' => $guestInfo['city'],
                'state' => $guestInfo['state'],
                'pincode' => $guestInfo['pincode'],
            ];
            $billingAddress = $shippingAddress;
        } else {
            if ($request->shipping_address_id) {
                $shippingAddressModel = \App\Models\Address::where('user_id', $user->id)
                    ->findOrFail($request->shipping_address_id);
                $shippingAddress = $shippingAddressModel->toArray();
            } else {
                $shippingAddress = $request->shipping_address;
            }

            $billingAddress = $request->billing_address_id 
                ? \App\Models\Address::where('user_id', $user->id)->findOrFail($request->billing_address_id)->toArray()
                : ($request->billing_address ?? $shippingAddress);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        // Apply coupon if provided
        $coupon = null;
        $couponDiscount = 0;
        
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            $userId = $user ? $user->id : null;
            
            if ($coupon && $coupon->isValid($subtotal, [], $userId)) {
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
                'user_id' => $user ? $user->id : null,
                'status' => 'pending',
                'status_locked' => false,
                'total_amount' => $totalAmount,
                'shipping_charge' => $shippingCharge,
                'coupon_id' => $coupon?->id,
                'coupon_discount' => $couponDiscount,
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : ($request->razorpay_payment_id ? 'paid' : 'pending'),
                'notes' => $request->notes,
            ];

            // Add guest info if guest checkout
            if ($isGuest) {
                $orderData['customer_name'] = $guestInfo['first_name'] . ' ' . $guestInfo['last_name'];
                $orderData['customer_email'] = $guestInfo['email'];
                $orderData['customer_phone'] = $guestInfo['phone'];
            }

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
            if ($coupon && $user) {
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
            if ($user) {
                Cart::where('user_id', $user->id)->delete();
            } else {
                Cart::where('session_id', $sessionId)->whereNull('user_id')->delete();
            }

            // Send order confirmation email
            try {
                $email = $user ? $user->email : $order->customer_email;
                $name = $user ? $user->name : $order->customer_name;
                
                if ($email) {
                    Mail::send('emails.order-confirmation', ['order' => $order->load('items.product')], function ($message) use ($email, $name, $order) {
                        $message->to($email, $name)
                            ->subject("Order Confirmation - {$order->order_number}");
                    });
                }
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

