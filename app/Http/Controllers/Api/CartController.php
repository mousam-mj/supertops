<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId(Request $request)
    {
        if ($request->user()) {
            return null; // User is logged in
        }

        $sessionId = $request->cookie('cart_session_id');
        
        // If no cookie, try to get from existing cart items
        // Use the session_id that has the most total quantity
        if (!$sessionId) {
            $sessionCounts = Cart::whereNull('user_id')
                ->whereNotNull('session_id')
                ->selectRaw('session_id, COUNT(*) as item_count, SUM(quantity) as total_quantity')
                ->groupBy('session_id')
                ->orderBy('total_quantity', 'desc')
                ->orderBy('item_count', 'desc')
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($sessionCounts) {
                $sessionId = $sessionCounts->session_id;
            } else {
                $sessionId = Str::random(40);
            }
        }

        return $sessionId;
    }

    /**
     * Get cart item count
     */
    public function count(Request $request)
    {
        if ($request->user()) {
            $cartItems = Cart::with('product')
                ->where('user_id', $request->user()->id)
                ->get();
        } else {
            // First, find the best session ID (one with most items)
            $bestSession = Cart::whereNull('user_id')
                ->whereNotNull('session_id')
                ->selectRaw('session_id, COUNT(*) as item_count, SUM(quantity) as total_quantity')
                ->groupBy('session_id')
                ->orderBy('total_quantity', 'desc')
                ->orderBy('item_count', 'desc')
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Use cookie session ID if available, otherwise use best session
            $cookieSessionId = $request->cookie('cart_session_id');
            $sessionId = $cookieSessionId ?: ($bestSession ? $bestSession->session_id : Str::random(40));
            
            // If cookie session is different from best session, consolidate to best session
            if ($bestSession && $bestSession->session_id !== $sessionId) {
                $sessionId = $bestSession->session_id;
            }
            
            // Consolidate all guest cart items to this session
            $this->consolidateGuestCart($sessionId);
            
            $cartItems = Cart::with('product')
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();
        }
        
        // Filter out items where product is null or deleted
        $cartItems = $cartItems->filter(function($item) {
            return $item->product !== null;
        });

        $count = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'data' => ['count' => $count],
        ])->cookie('cart_session_id', $sessionId, 60 * 24 * 30); // 30 days
    }

    /**
     * Get cart items
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            $cartItems = Cart::with('product.category')
                ->where('user_id', $request->user()->id)
                ->get();
        } else {
            // First, find the best session ID (one with most items)
            $bestSession = Cart::whereNull('user_id')
                ->whereNotNull('session_id')
                ->selectRaw('session_id, COUNT(*) as item_count, SUM(quantity) as total_quantity')
                ->groupBy('session_id')
                ->orderBy('total_quantity', 'desc')
                ->orderBy('item_count', 'desc')
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Use cookie session ID if available, otherwise use best session
            $cookieSessionId = $request->cookie('cart_session_id');
            $sessionId = $cookieSessionId ?: ($bestSession ? $bestSession->session_id : Str::random(40));
            
            // If cookie session is different from best session, consolidate to best session
            if ($bestSession && $bestSession->session_id !== $sessionId) {
                $sessionId = $bestSession->session_id;
            }
            
            // Consolidate all guest cart items to this session
            $this->consolidateGuestCart($sessionId);
            
            $cartItems = Cart::with('product.category')
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();
        }
        
        // Calculate total and ensure product data is properly loaded
        $total = 0;
        $items = $cartItems->map(function($item) use (&$total) {
            // Ensure product is loaded
            if (!$item->relationLoaded('product')) {
                $item->load('product');
            }
            
            // Calculate subtotal properly
            $product = $item->product;
            $unitPrice = $product ? ($product->sale_price ?? $product->price ?? 0) : 0;
            $subtotal = $item->quantity * $unitPrice;
            $total += $subtotal;
            
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'color' => $item->color,
                'subtotal' => $subtotal,
                'unit_price' => $unitPrice,
                'product' => $product ? [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price ?? 0,
                    'sale_price' => $product->sale_price,
                    'current_price' => $product->current_price ?? ($product->sale_price ?? $product->price ?? 0),
                    'image' => $product->image,
                    'sku' => $product->sku,
                ] : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'total' => $total,
            ],
        ])->cookie('cart_session_id', $this->getSessionId($request), 60 * 24 * 30);
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This product is currently unavailable.',
            ], 400);
        }

        // Check stock availability
        if ($request->size || $request->color) {
            $stock = $product->getStockForColorSize($request->color, $request->size);
            if ($stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $stock > 0 
                        ? "Only {$stock} item(s) available in stock." 
                        : 'This item is out of stock.',
                ], 400);
            }
        } else {
            // Check main stock_quantity and in_stock flag
            $availableStock = $product->stock_quantity ?? 0;
            if (!$product->in_stock || $availableStock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $availableStock > 0 
                        ? "Only {$availableStock} item(s) available in stock." 
                        : 'This item is out of stock.',
                ], 400);
            }
        }

        $cartData = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'color' => $request->color,
        ];

        if ($request->user()) {
            $cartData['user_id'] = $request->user()->id;
            $cartData['session_id'] = null;

            // Check if item already exists
            $existingCart = Cart::where('user_id', $request->user()->id)
                ->where('product_id', $request->product_id)
                ->where('size', $request->size)
                ->where('color', $request->color)
                ->first();

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $request->quantity;
                
                // Check stock before updating
                if ($request->size || $request->color) {
                    $stock = $product->getStockForColorSize($request->color, $request->size);
                    if ($stock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $stock > 0 
                                ? "Only {$stock} item(s) available in stock. You already have {$existingCart->quantity} in your cart." 
                                : 'This item is out of stock.',
                        ], 400);
                    }
                } else {
                    $availableStock = $product->stock_quantity ?? 0;
                    if (!$product->in_stock || $availableStock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $availableStock > 0 
                                ? "Only {$availableStock} item(s) available in stock. You already have {$existingCart->quantity} in your cart." 
                                : 'This item is out of stock.',
                        ], 400);
                    }
                }
                
                $existingCart->quantity = $newQuantity;
                $existingCart->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Item updated in cart',
                    'data' => $existingCart,
                ]);
            }
        } else {
            $sessionId = $this->getSessionId($request);
            $cartData['session_id'] = $sessionId;

            // Check if item already exists
            $existingCart = Cart::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->where('product_id', $request->product_id)
                ->where('size', $request->size)
                ->where('color', $request->color)
                ->first();

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $request->quantity;
                
                // Check stock before updating
                if ($request->size || $request->color) {
                    $stock = $product->getStockForColorSize($request->color, $request->size);
                    if ($stock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $stock > 0 
                                ? "Only {$stock} item(s) available in stock. You already have {$existingCart->quantity} in your cart." 
                                : 'This item is out of stock.',
                        ], 400);
                    }
                } else {
                    $availableStock = $product->stock_quantity ?? 0;
                    if (!$product->in_stock || $availableStock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $availableStock > 0 
                                ? "Only {$availableStock} item(s) available in stock. You already have {$existingCart->quantity} in your cart." 
                                : 'This item is out of stock.',
                        ], 400);
                    }
                }
                
                $existingCart->quantity = $newQuantity;
                $existingCart->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Item updated in cart',
                    'data' => $existingCart,
                ])->cookie('cart_session_id', $sessionId, 60 * 24 * 30);
            }
        }

        $cart = Cart::create($cartData);
        
        // Use the same session ID that was used to create the cart
        $finalSessionId = $request->user() ? null : ($cartData['session_id'] ?? $this->getSessionId($request));

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => $cart->load('product'),
        ], 201)->cookie('cart_session_id', $finalSessionId, 60 * 24 * 30);
    }

    /**
     * Update cart item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);

        // Check authorization
        if ($request->user()) {
            if ($cart->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
        } else {
            $sessionId = $this->getSessionId($request);
            if ($cart->session_id !== $sessionId || $cart->user_id !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
        }

        // Check stock
        $product = $cart->product;
        if ($cart->size || $cart->color) {
            $stock = $product->getStockForColorSize($cart->color, $cart->size);
            if ($stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $stock > 0 
                        ? "Only {$stock} item(s) available in stock." 
                        : 'This item is out of stock.',
                ], 400);
            }
        } else {
            $availableStock = $product->stock_quantity ?? 0;
            if (!$product->in_stock || $availableStock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $availableStock > 0 
                        ? "Only {$availableStock} item(s) available in stock." 
                        : 'This item is out of stock.',
                ], 400);
            }
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Cart item updated',
            'data' => $cart->load('product'),
        ]);
    }

    /**
     * Remove cart item
     */
    public function remove(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        // Check authorization
        if ($request->user()) {
            if ($cart->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
        } else {
            $sessionId = $this->getSessionId($request);
            if ($cart->session_id !== $sessionId || $cart->user_id !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }

    /**
     * Check if product exists in cart
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $query = Cart::where('product_id', $request->product_id);

        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
        } else {
            $sessionId = $this->getSessionId($request);
            $query->where('session_id', $sessionId)->whereNull('user_id');
        }

        if ($request->size) {
            $query->where('size', $request->size);
        }

        if ($request->color) {
            $query->where('color', $request->color);
        }

        $exists = $query->exists();

        return response()->json([
            'success' => true,
            'data' => ['exists' => $exists],
        ]);
    }

    /**
     * Consolidate all guest cart items into one session
     */
    private function consolidateGuestCart($targetSessionId)
    {
        // Get all guest cart items with different session IDs
        $otherCarts = Cart::whereNull('user_id')
            ->whereNotNull('session_id')
            ->where('session_id', '!=', $targetSessionId)
            ->with('product')
            ->get();

        if ($otherCarts->isEmpty()) {
            return;
        }

        // Group by product_id, size, and color to merge duplicates
        $grouped = $otherCarts->groupBy(function($item) {
            return $item->product_id . '|' . ($item->size ?? '') . '|' . ($item->color ?? '');
        });

        foreach ($grouped as $key => $items) {
            $totalQuantity = $items->sum('quantity');
            $firstItem = $items->first();

            // Skip if product is null
            if (!$firstItem->product) {
                continue;
            }

            // Check if item already exists in target session
            $existing = Cart::where('session_id', $targetSessionId)
                ->where('product_id', $firstItem->product_id)
                ->where('size', $firstItem->size)
                ->where('color', $firstItem->color)
                ->whereNull('user_id')
                ->first();

            if ($existing) {
                // Update quantity
                $existing->quantity += $totalQuantity;
                $existing->save();
            } else {
                // Create new item
                Cart::create([
                    'session_id' => $targetSessionId,
                    'product_id' => $firstItem->product_id,
                    'quantity' => $totalQuantity,
                    'size' => $firstItem->size,
                    'color' => $firstItem->color,
                ]);
            }

            // Delete old items
            foreach ($items as $item) {
                $item->delete();
            }
        }
    }
}



