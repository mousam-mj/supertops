<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId(Request $request)
    {
        if ($request->user()) {
            return null;
        }

        $sessionId = $request->cookie('cart_session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
        }

        return $sessionId;
    }

    /**
     * Show checkout page
     */
    public function index(Request $request)
    {
        $query = Cart::with('product.category');

        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
            $addresses = Address::where('user_id', $request->user()->id)
                ->orderBy('is_default', 'desc')
                ->get();
        } else {
            $sessionId = $this->getSessionId($request);
            $query->where('session_id', $sessionId);
            $addresses = collect([]);
        }

        $cartItems = $query->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        $shipping = 0; // Can be calculated dynamically
        $total = $subtotal + $shipping;

        $sessionId = $this->getSessionId($request);
        
        return response()
            ->view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses'))
            ->cookie('cart_session_id', $sessionId, 60 * 24 * 30);
    }
}

