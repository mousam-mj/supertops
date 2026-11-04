<?php

namespace App\Http\Controllers;

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
            return null;
        }

        return $request->cookie('cart_session_id') ?: Str::random(40);
    }

    /**
     * Show cart page
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            $cartItems = Cart::with('product.category')
                ->where('user_id', $request->user()->id)
                ->get();
        } else {
            $sessionId = $request->cookie('cart_session_id') ?: Str::random(40);
            $cartItems = Cart::with('product.category')
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();
        }

        // Filter out items where product is null or deleted
        $cartItems = $cartItems->filter(function($item) {
            return $item->product !== null;
        })->values(); // Re-index the collection
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        // Calculate shipping (can be dynamic later)
        $shipping = 0; // Free shipping for now
        $total = $subtotal + $shipping;

        // Set cookie for guest users
        if (!$request->user() && $sessionId) {
            return response()
                ->view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'))
                ->cookie('cart_session_id', $sessionId, 60 * 24 * 30);
        }
        
        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Consolidate all guest cart items into one session
     */
    private function consolidateGuestCart($targetSessionId)
    {
        return;
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
                // Delete items with null products
                foreach ($items as $item) {
                    $item->delete();
                }
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

