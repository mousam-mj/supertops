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
     * Serve part STLs from the app origin so static/CDN deploy gaps do not 404
     * (same idea as {@see appJs}).
     */
    public function partStl(string $part): BinaryFileResponse
    {
        $map = [
            'body' => 'assets/models/tumbler-1200ml-parts/body.stl',
            'cap' => 'assets/models/tumbler-1200ml-parts/cover.stl',
            'straw' => 'assets/models/tumbler-1200ml-parts/straw.stl',
            'handle' => 'assets/models/tumbler-1200ml-parts/handle.stl',
            'boot' => 'assets/models/tumbler-1200ml-parts/base.stl',
        ];
        abort_unless(isset($map[$part]), 404);

        $path = public_path($map[$part]);
        abort_unless(is_readable($path), 404, 'STL missing on server. Deploy public/'.$map[$part]);

        return response()->file($path, [
            'Content-Type' => 'model/stl',
            'Cache-Control' => 'public, max-age=86400',
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
