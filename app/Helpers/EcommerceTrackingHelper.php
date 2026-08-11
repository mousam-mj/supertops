<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;

if (! function_exists('ecommerce_tracking_sku')) {
    function ecommerce_tracking_sku(?Product $product): string
    {
        if (! $product) {
            return '';
        }

        $sku = trim((string) ($product->sku ?? ''));

        return $sku !== '' ? $sku : ('PROD-'.$product->id);
    }
}

if (! function_exists('ecommerce_tracking_category')) {
    function ecommerce_tracking_category(?Product $product): string
    {
        if (! $product) {
            return '';
        }

        $product->loadMissing('category');

        return trim((string) ($product->category->name ?? ''));
    }
}

if (! function_exists('ecommerce_tracking_item_name')) {
    function ecommerce_tracking_item_name(Product $product, ?string $displayName = null): string
    {
        $name = trim((string) ($displayName ?? $product->name ?? ''));

        return $name !== '' ? $name : 'Product';
    }
}

if (! function_exists('ecommerce_tracking_unit_price')) {
    function ecommerce_tracking_unit_price(Product $product, ?float $override = null): float
    {
        if ($override !== null) {
            return round((float) $override, 2);
        }

        $sale = $product->sale_price;
        $price = (float) ($product->price ?? 0);

        if ($sale !== null && (float) $sale > 0 && (float) $sale < $price) {
            return round((float) $sale, 2);
        }

        return round($price, 2);
    }
}

if (! function_exists('ecommerce_tracking_line_item')) {
    function ecommerce_tracking_line_item(Product $product, float $price, int $quantity, ?string $displayName = null): array
    {
        return [
            'item_id' => ecommerce_tracking_sku($product),
            'item_name' => ecommerce_tracking_item_name($product, $displayName),
            'item_category' => ecommerce_tracking_category($product),
            'item_brand' => 'Perch',
            'price' => round($price, 2),
            'quantity' => max(1, $quantity),
        ];
    }
}

if (! function_exists('ecommerce_view_item_payload')) {
    function ecommerce_view_item_payload(Product $product, float $price, ?string $displayName = null): array
    {
        $unitPrice = round($price, 2);

        return [
            'currency' => 'INR',
            'value' => $unitPrice,
            'items' => [
                ecommerce_tracking_line_item($product, $unitPrice, 1, $displayName),
            ],
        ];
    }
}

if (! function_exists('ecommerce_add_to_cart_payload')) {
    function ecommerce_add_to_cart_payload(Cart $cart, int $quantityAdded): array
    {
        $cart->loadMissing('product.category');
        $product = $cart->product;
        $qty = max(1, $quantityAdded);
        $unitPrice = (float) $cart->unit_price;
        $displayName = ecommerce_cart_display_name($cart);

        return [
            'currency' => 'INR',
            'value' => round($unitPrice * $qty, 2),
            'items' => [
                ecommerce_tracking_line_item($product, $unitPrice, $qty, $displayName),
            ],
        ];
    }
}

if (! function_exists('ecommerce_begin_checkout_payload')) {
    /**
     * @param  Collection<int, Cart>  $cartItems
     */
    function ecommerce_begin_checkout_payload(Collection $cartItems): array
    {
        $items = [];
        $total = 0.0;

        foreach ($cartItems as $cart) {
            if (! $cart->product) {
                continue;
            }

            $cart->loadMissing('product.category');
            $unitPrice = (float) $cart->unit_price;
            $qty = (int) $cart->quantity;
            $displayName = ecommerce_cart_display_name($cart);
            $line = ecommerce_tracking_line_item($cart->product, $unitPrice, $qty, $displayName);

            $items[] = [
                'item_id' => $line['item_id'],
                'item_name' => $line['item_name'],
                'price' => $line['price'],
                'quantity' => $line['quantity'],
            ];
            $total += $line['price'] * $line['quantity'];
        }

        return [
            'currency' => 'INR',
            'value' => round($total, 2),
            'items' => $items,
        ];
    }
}

if (! function_exists('ecommerce_purchase_payload')) {
    function ecommerce_purchase_payload(Order $order): array
    {
        $order->loadMissing('items.product.category');

        $items = [];
        foreach ($order->items as $orderItem) {
            $product = $orderItem->product;
            $name = trim((string) ($orderItem->product_name ?: ($product->name ?? 'Product')));
            $sku = trim((string) ($orderItem->product_sku ?: ecommerce_tracking_sku($product)));

            $items[] = [
                'item_id' => $sku !== '' ? $sku : ('PROD-'.($orderItem->product_id ?? '0')),
                'item_name' => $name !== '' ? $name : 'Product',
                'price' => round((float) $orderItem->price, 2),
                'quantity' => max(1, (int) $orderItem->quantity),
            ];
        }

        return [
            'transaction_id' => (string) $order->order_number,
            'currency' => 'INR',
            'value' => round((float) ($order->total_amount ?? $order->total ?? 0), 2),
            'tax' => round((float) ($order->tax ?? 0), 2),
            'shipping' => round((float) ($order->shipping_charge ?? $order->shipping ?? 0), 2),
            'items' => $items,
        ];
    }
}

if (! function_exists('ecommerce_cart_display_name')) {
    function ecommerce_cart_display_name(Cart $cart): ?string
    {
        if (! $cart->customization_json) {
            return null;
        }

        $decoded = json_decode($cart->customization_json, true);
        if (! is_array($decoded) || empty($decoded['product_title'])) {
            return null;
        }

        return (string) $decoded['product_title'];
    }
}
