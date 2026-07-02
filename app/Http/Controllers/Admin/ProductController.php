<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        // Filter by stock
        if ($request->filled('stock')) {
            if ($request->stock === 'in_stock') {
                $query->where('in_stock', true)->where('stock_quantity', '>', 0);
            } elseif ($request->stock === 'out_of_stock') {
                $query->where(function($q) {
                    $q->where('in_stock', false)->orWhere('stock_quantity', '<=', 0);
                });
            } elseif ($request->stock === 'low_stock') {
                $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10);
            }
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Download a sample CSV template for bulk product import.
     */
    public function importTemplate()
    {
        $headers = [
            'name',
            'price',
            'sale_price',
            'sku',
            'category_slug',
            'stock_quantity',
            'short_description',
            'description',
            'is_active',
            'is_featured',
            'is_new_arrival',
            'in_stock',
            'sort_order',
        ];
        $sample = [
            'Example Bottle 500ml',
            '499.00',
            '449.00',
            'CSV-EXAMPLE-1',
            '',
            '50',
            'Short summary for listings',
            'Optional longer description (use quotes in CSV if it contains commas).',
            '1',
            '0',
            '0',
            '1',
            '0',
        ];

        return response()->streamDownload(function () use ($headers, $sample) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, $headers);
            fputcsv($out, $sample);
            fclose($out);
        }, 'product-import-template.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Import products from a UTF-8 CSV file (first row = column headers).
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $request->file('file')->getRealPath();
        if ($path === false || ! is_readable($path)) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Could not read the uploaded file.');
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Could not open the uploaded file.');
        }

        $first = fgets($handle);
        if ($first === false) {
            fclose($handle);

            return redirect()->route('admin.products.index')
                ->with('error', 'The CSV file is empty.');
        }
        rewind($handle);
        if (str_starts_with($first, "\xEF\xBB\xBF")) {
            fread($handle, 3);
        }

        $headerRow = fgetcsv($handle);
        if ($headerRow === false || count(array_filter($headerRow, fn ($c) => $c !== null && trim((string) $c) !== '')) === 0) {
            fclose($handle);

            return redirect()->route('admin.products.index')
                ->with('error', 'Missing or invalid header row in CSV.');
        }

        $headers = [];
        foreach ($headerRow as $i => $col) {
            $headers[$i] = strtolower(trim((string) $col));
        }

        $imported = 0;
        $errors = [];
        $lineNo = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $lineNo++;
            if ($row === null || count(array_filter($row, fn ($c) => $c !== null && trim((string) $c) !== '')) === 0) {
                continue;
            }

            $data = [];
            foreach ($headers as $i => $key) {
                if ($key === '') {
                    continue;
                }
                $data[$key] = isset($row[$i]) ? trim((string) $row[$i]) : '';
            }

            $name = $data['name'] ?? '';
            if ($name === '') {
                $errors[] = "Line {$lineNo}: name is required.";

                continue;
            }

            $priceRaw = $data['price'] ?? '';
            if ($priceRaw === '' || ! is_numeric(str_replace(',', '', $priceRaw))) {
                $errors[] = "Line {$lineNo}: valid price is required.";

                continue;
            }
            $price = (float) str_replace(',', '', $priceRaw);

            $saleRaw = $data['sale_price'] ?? '';
            $salePrice = ($saleRaw !== '' && is_numeric(str_replace(',', '', $saleRaw)))
                ? (float) str_replace(',', '', $saleRaw)
                : null;

            $categoryId = null;
            $slugCat = $data['category_slug'] ?? '';
            if ($slugCat !== '') {
                $cat = Category::where('slug', $slugCat)->where('is_active', true)->first();
                if ($cat) {
                    $categoryId = $cat->id;
                }
            }

            $stockQty = isset($data['stock_quantity']) && $data['stock_quantity'] !== '' && is_numeric($data['stock_quantity'])
                ? (int) $data['stock_quantity']
                : 0;

            $sku = $data['sku'] ?? null;
            if ($sku === '') {
                $sku = null;
            }
            if ($sku !== null && Product::where('sku', $sku)->exists()) {
                do {
                    $sku = 'IMP-'.strtoupper(Str::random(8));
                } while (Product::where('sku', $sku)->exists());
            }

            $slug = $this->uniqueImportSlug(Str::slug($name));

            try {
                DB::beginTransaction();
                Product::create([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => ($data['description'] ?? '') !== '' ? $data['description'] : null,
                    'short_description' => ($data['short_description'] ?? '') !== '' ? $data['short_description'] : null,
                    'category_id' => $categoryId,
                    'price' => $price,
                    'sale_price' => $salePrice,
                    'sku' => $sku,
                    'stock_quantity' => max(0, $stockQty),
                    'stock' => max(0, $stockQty),
                    'in_stock' => $this->csvBool($data['in_stock'] ?? '1', true),
                    'is_active' => $this->csvBool($data['is_active'] ?? '1', true),
                    'is_featured' => $this->csvBool($data['is_featured'] ?? '0', false),
                    'is_new_arrival' => $this->csvBool($data['is_new_arrival'] ?? '0', false),
                    'sort_order' => isset($data['sort_order']) && $data['sort_order'] !== '' && is_numeric($data['sort_order'])
                        ? (int) $data['sort_order']
                        : 0,
                    'sizes' => [],
                    'colors' => [],
                    'images' => null,
                    'specifications' => null,
                ]);
                DB::commit();
                $imported++;
            } catch (\Throwable $e) {
                DB::rollBack();
                $errors[] = "Line {$lineNo}: ".$e->getMessage();
            }
        }

        fclose($handle);

        $msg = $imported > 0
            ? "Successfully imported {$imported} product(s)."
            : 'No products were imported.';

        return redirect()->route('admin.products.index')
            ->with($imported > 0 ? 'success' : 'warning', $msg)
            ->with('import_errors', array_slice($errors, 0, 30));
    }

    private function csvBool(string $value, bool $default): bool
    {
        $v = strtolower(trim($value));
        if ($v === '') {
            return $default;
        }
        if (in_array($v, ['1', 'true', 'yes', 'y', 'on'], true)) {
            return true;
        }
        if (in_array($v, ['0', 'false', 'no', 'n', 'off'], true)) {
            return false;
        }

        return $default;
    }

    private function uniqueImportSlug(string $baseSlug): string
    {
        $slug = $baseSlug !== '' ? $baseSlug : 'product';
        $original = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:50000',
            'short_description' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|unique:products,sku',
            'in_stock' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:51200',
            'sort_order' => 'nullable|integer|min:0',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sizes'] = [];
        $validated['colors'] = [];
        $validated['stock_quantity'] = 0;
        $validated['price'] = 0;
        $validated['sale_price'] = null;
        $validated['in_stock'] = $request->boolean('in_stock');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival');
        
        // Process specifications
        $specifications = [];
        if ($request->has('specifications') && is_array($request->specifications)) {
            foreach ($request->specifications as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specifications[trim($spec['key'])] = trim($spec['value']);
                }
            }
        }
        $validated['specifications'] = !empty($specifications) ? $specifications : null;
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle gallery images (multiple)
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = $file->store('products/gallery', 'public');
            }
        }
        if (!empty($galleryPaths)) {
            $validated['images'] = $galleryPaths;
        }

        // Handle product video
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('products/videos', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $product->load(['parentProduct', 'childVariants']);

        $parentProduct = $product->parentProduct;
        $linkedVariants = $product->parent_product_id
            ? collect()
            : $product->childVariants;

        $rootProduct = $product->variantGroupRoot();
        $excludeIds = $rootProduct->variantGroupMembers()->pluck('id')->all();

        $linkableProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->whereNull('parent_product_id')
                    ->orWhere('parent_product_id', $product->id);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        $mainProductOptions = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->whereNull('parent_product_id')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'parentProduct',
            'linkedVariants',
            'linkableProducts',
            'mainProductOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:50000',
            'short_description' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => ['nullable', 'string', \Illuminate\Validation\Rule::unique('products', 'sku')->ignore($product->id)],
            'in_stock' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:51200',
            'sort_order' => 'nullable|integer|min:0',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:500',
            'parent_product_id' => 'nullable|integer|exists:products,id',
            'variant_color_label' => 'nullable|string|max:100',
            'variant_links' => 'nullable|array',
            'variant_links.*.product_id' => 'nullable|integer|exists:products,id',
            'variant_links.*.color_label' => 'nullable|string|max:100',
            'variant_mode' => 'nullable|in:main,linked',
        ]);
        
        // Process specifications
        $specifications = [];
        if ($request->has('specifications') && is_array($request->specifications)) {
            foreach ($request->specifications as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specifications[trim($spec['key'])] = trim($spec['value']);
                }
            }
        }
        $validated['specifications'] = !empty($specifications) ? $specifications : null;

        // Update slug if name changed
        if ($validated['name'] != $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle remove_image
        if ($request->filled('remove_image') && $request->remove_image == '1') {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                $validated['image'] = null;
            }
        } elseif ($request->hasFile('image')) {
            // Delete old image when uploading new one
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle remove_gallery_images
        $removeGalleryPaths = $request->input('remove_gallery_images', []);
        if (!is_array($removeGalleryPaths)) {
            $removeGalleryPaths = array_filter([$removeGalleryPaths]);
        }
        $existingImages = is_array($product->images) ? $product->images : [];
        if (!empty($removeGalleryPaths)) {
            foreach ($removeGalleryPaths as $path) {
                if (in_array($path, $existingImages)) {
                    Storage::disk('public')->delete($path);
                    $existingImages = array_values(array_filter($existingImages, fn($img) => $img !== $path));
                }
            }
        }

        // Handle gallery images (append to existing list)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $existingImages[] = $file->store('products/gallery', 'public');
            }
        }
        if (isset($existingImages)) {
            $validated['images'] = array_values(array_unique($existingImages));
        }

        // Handle remove_video
        if ($request->filled('remove_video') && $request->remove_video == '1') {
            if ($product->video) {
                Storage::disk('public')->delete($product->video);
                $validated['video'] = null;
            }
        } elseif ($request->hasFile('video')) {
            if ($product->video) {
                Storage::disk('public')->delete($product->video);
            }
            $validated['video'] = $request->file('video')->store('products/videos', 'public');
        }

        $validated['in_stock'] = $request->boolean('in_stock');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival');

        $product->update($validated);

        $this->syncProductVariantLinks($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    protected function syncProductVariantLinks(Product $product, Request $request): void
    {
        $product->refresh();
        $variantMode = $request->input('variant_mode', $product->parent_product_id ? 'linked' : 'main');

        if ($variantMode === 'linked') {
            $parentId = (int) $request->input('parent_product_id');
            if ($parentId <= 0 || $parentId === $product->id) {
                return;
            }

            if (Product::where('parent_product_id', $product->id)->exists()) {
                Product::where('parent_product_id', $product->id)->update([
                    'parent_product_id' => null,
                    'variant_color_label' => null,
                ]);
            }

            $product->update([
                'parent_product_id' => $parentId,
                'variant_color_label' => trim((string) $request->input('variant_color_label', '')) ?: null,
            ]);

            return;
        }

        $product->update([
            'parent_product_id' => null,
            'variant_color_label' => trim((string) $request->input('main_variant_color_label', '')) ?: null,
        ]);

        $links = $request->input('variant_links', []);
        $linkedIds = [];

        foreach ($links as $link) {
            $linkedId = (int) ($link['product_id'] ?? 0);
            if ($linkedId <= 0 || $linkedId === $product->id) {
                continue;
            }

            if (Product::where('id', $linkedId)->whereNotNull('parent_product_id')->where('parent_product_id', '!=', $product->id)->exists()) {
                continue;
            }

            $linked = Product::find($linkedId);
            if (! $linked) {
                continue;
            }

            $linked->update([
                'parent_product_id' => $product->id,
                'variant_color_label' => trim((string) ($link['color_label'] ?? '')) ?: null,
            ]);
            $linkedIds[] = $linkedId;
        }

        Product::where('parent_product_id', $product->id)
            ->whereNotIn('id', $linkedIds)
            ->update([
                'parent_product_id' => null,
                'variant_color_label' => null,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete gallery images if exist
        if (is_array($product->images)) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        if (is_array($product->color_swatch_images)) {
            foreach ($product->color_swatch_images as $img) {
                if ($img) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        // Delete video if exists
        if ($product->video) {
            Storage::disk('public')->delete($product->video);
        }

        // Remove from cart and wishlist (cart is DB; wishlist is localStorage - cleaned on next visit)
        Cart::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
