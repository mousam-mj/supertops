<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CustomizeConfigService;

class CustomizeController extends Controller
{
    /**
     * Show customize page for a product.
     * /customize or /customize/{slug}
     */
    public function show(?string $slug = null)
    {
        if ($slug) {
            $product = Product::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        } else {
            $product = Product::where('is_active', true)
                ->orderBy('sort_order')
                ->first();

            if (!$product) {
                abort(404, 'No product available for customization.');
            }

            return redirect()->route('customize.product', ['slug' => $product->slug]);
        }

        $config = CustomizeConfigService::getConfig($product);

        return view('customize', [
            'product' => $product,
            'config' => $config,
        ]);
    }
}
