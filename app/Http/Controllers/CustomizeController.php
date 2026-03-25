<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CustomizeConfigService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomizeController extends Controller
{
    /**
     * Serve the large Three.js customizer bundle from the app origin.
     * Avoids 404s when ASSET_URL/CDN omits public/assets/js or deploy skips big files.
     */
    public function appJs(): BinaryFileResponse
    {
        $path = public_path('assets/js/customize-app.js');
        abort_unless(is_readable($path), 404, 'Customizer script missing. Ensure public/assets/js/customize-app.js is deployed.');

        return response()->file($path, [
            'Content-Type' => 'application/javascript; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400, immutable',
        ]);
    }

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
