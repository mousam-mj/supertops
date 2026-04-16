<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorSizeMasterController;
use App\Http\Controllers\Admin\CustomizeSettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\InstagramReelController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PolicyPageController as AdminPolicyPageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\ProductPdfController;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\MainCategory;
use App\Models\MasterColor;
use App\Models\MasterSize;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// =====================================================
// FRONTEND ROUTES - EDX Bearing Website
// =====================================================

// Home Page (edx-bearing HTML catalog only — Bearings main category)
Route::get('/', function () {
    $productTotal = Product::edxBearingsCatalog()->where('is_active', true)->count();
    $products = Product::edxBearingsCatalog()->where('is_active', true)
        ->with('category')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->limit(12)
        ->get();

    return view('frontend.home', compact('products', 'productTotal'));
})->name('home');

// Product Detail Page
Route::get('/product/{slug}', function ($slug) {
    $product = Product::edxBearingsCatalog()
        ->where('slug', $slug)
        ->where('is_active', true)
        ->with('category')
        ->firstOrFail();

    $relatedProducts = Product::edxBearingsCatalog()
        ->where('is_active', true)
        ->where('id', '!=', $product->id)
        ->when($product->category_id, function ($query) use ($product) {
            return $query->where('category_id', $product->category_id);
        })
        ->limit(4)
        ->get();

    return view('frontend.product', compact('product', 'relatedProducts'));
})->name('frontend.product');

// Product PDF hub (site layout + embedded preview + links)
Route::get('/product/{slug}/pdf', function ($slug) {
    $product = Product::edxBearingsCatalog()
        ->where('slug', $slug)
        ->where('is_active', true)
        ->with('category')
        ->firstOrFail();

    return view('frontend.product-pdf', compact('product'));
})->name('frontend.product.pdf');

Route::get('/product/{slug}/pdf/preview', [ProductPdfController::class, 'preview'])
    ->name('frontend.product.pdf.preview');
Route::get('/product/{slug}/pdf/download', [ProductPdfController::class, 'download'])
    ->name('frontend.product.pdf.download');

// Product Range / Shop Page
Route::get('/range', function (Request $request) {
    $bearingsMainId = MainCategory::bearingsCatalogId();

    $categories = Category::where('is_active', true)
        ->whereNull('parent_id')
        ->when($bearingsMainId, function ($q) use ($bearingsMainId) {
            $q->where('main_category_id', $bearingsMainId);
        })
        ->orderBy('name')
        ->get();

    $query = Product::edxBearingsCatalog()->where('is_active', true)->with('category');

    if ($request->filled('category')) {
        $category = Category::where('slug', $request->category)->first();
        if ($category) {
            $query->where('category_id', $category->id);
        }
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('sku', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
        });
    }

    $sort = $request->get('sort', 'latest');
    switch ($sort) {
        case 'name':
            $query->orderBy('name');
            break;
        case 'price_low':
            $query->orderByRaw('COALESCE(sale_price, price) ASC');
            break;
        case 'price_high':
            $query->orderByRaw('COALESCE(sale_price, price) DESC');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }

    $products = $query->paginate(12)->withQueryString();

    return view('frontend.range', compact('products', 'categories'));
})->name('frontend.range');

// Static Pages
Route::get('/edx-world', function () {
    return view('frontend.page', ['title' => 'EDX World', 'page' => 'edx-world']);
})->name('frontend.edx-world');

Route::get('/quality-path', function () {
    return view('frontend.page', ['title' => 'Quality Path', 'page' => 'quality-path']);
})->name('frontend.quality-path');

Route::get('/industries', function () {
    return view('frontend.page', ['title' => 'Industries', 'page' => 'industries']);
})->name('frontend.industries');

Route::get('/applications', function () {
    return view('frontend.page', ['title' => 'Applications', 'page' => 'applications']);
})->name('frontend.applications');

// Contact Page
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('frontend.contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    return redirect()->route('frontend.contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
})->name('frontend.contact.submit');

// Serve storage files via PHP when symlink returns 403
$serveStorage = function (string $path) {
    $path = preg_replace('#\.\./#', '', $path);
    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = Storage::disk('public')->path($path);
    $realPath = realpath($fullPath);
    $storageRoot = realpath(storage_path('app/public'));
    if (! $realPath || ! $storageRoot || strpos($realPath, $storageRoot) !== 0) {
        abort(404);
    }

    return response()->file($realPath);
};
Route::get('/storage/{path}', $serveStorage)->where('path', '.*')->name('storage.serve');
Route::get('/media/{path}', $serveStorage)->where('path', '.*')->name('media.serve');

// =====================================================
// ADMIN ROUTES
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Routes (public)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Protected Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

        // Report Downloads
        Route::get('/dashboard/reports/inventory', [DashboardController::class, 'downloadInventoryReport'])->name('dashboard.reports.inventory');
        Route::get('/dashboard/reports/orders', [DashboardController::class, 'downloadOrdersReport'])->name('dashboard.reports.orders');
        Route::get('/dashboard/reports/revenue', [DashboardController::class, 'downloadRevenueReport'])->name('dashboard.reports.revenue');
        Route::get('/dashboard/reports/customers', [DashboardController::class, 'downloadCustomersReport'])->name('dashboard.reports.customers');
        Route::get('/dashboard/reports/skus', [DashboardController::class, 'downloadSkusReport'])->name('dashboard.reports.skus');

        // Reports hub
        Route::get('/reports', [DashboardController::class, 'reportsIndex'])->name('reports.index');

        // Resource Routes
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class)->except(['create', 'store']);
        Route::resource('hero-banners', HeroBannerController::class)->except(['show']);

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/instagram-reels', [InstagramReelController::class, 'index'])->name('instagram-reels.index');
        Route::post('/instagram-reels', [InstagramReelController::class, 'store'])->name('instagram-reels.store');
        Route::put('/instagram-reels/sort', [InstagramReelController::class, 'updateSort'])->name('instagram-reels.sort');
        Route::delete('/instagram-reels/{instagram_reel}', [InstagramReelController::class, 'destroy'])->name('instagram-reels.destroy');

        // Policy Pages
        Route::get('/policy-pages', [AdminPolicyPageController::class, 'index'])->name('policy-pages.index');
        Route::get('/policy-pages/{policy_page}/edit', [AdminPolicyPageController::class, 'edit'])->name('policy-pages.edit');
        Route::put('/policy-pages/{policy_page}', [AdminPolicyPageController::class, 'update'])->name('policy-pages.update');

        // FAQs
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/category/create', [FaqController::class, 'createCategory'])->name('faqs.create-category');
        Route::post('/faqs/category', [FaqController::class, 'storeCategory'])->name('faqs.store-category');
        Route::get('/faqs/category/{faq}/edit', [FaqController::class, 'editCategory'])->name('faqs.edit-category');
        Route::put('/faqs/category/{faq}', [FaqController::class, 'updateCategory'])->name('faqs.update-category');
        Route::delete('/faqs/category/{faq}', [FaqController::class, 'destroyCategory'])->name('faqs.destroy-category');
        Route::get('/faqs/category/{faq}/items', [FaqController::class, 'items'])->name('faqs.items');
        Route::get('/faqs/category/{faq}/items/create', [FaqController::class, 'createItem'])->name('faqs.create-item');
        Route::post('/faqs/category/{faq}/items', [FaqController::class, 'storeItem'])->name('faqs.store-item');
        Route::get('/faqs/category/{faq}/items/{item}/edit', [FaqController::class, 'editItem'])->name('faqs.edit-item');
        Route::put('/faqs/category/{faq}/items/{item}', [FaqController::class, 'updateItem'])->name('faqs.update-item');
        Route::delete('/faqs/category/{faq}/items/{item}', [FaqController::class, 'destroyItem'])->name('faqs.destroy-item');

        // Product reviews
        Route::get('/reviews', [ProductReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [ProductReviewController::class, 'destroy'])->name('reviews.destroy');

        // Alerts
        Route::get('/alerts', function () {
            $lowStockCount = Product::where('stock_quantity', '<', 10)->where('is_active', true)->count();
            $pendingOrdersCount = Order::where('status', 'pending')->count();

            return view('admin.alerts.index', compact('lowStockCount', 'pendingOrdersCount'));
        })->name('alerts.index');

        // Main Categories Routes
        Route::get('/main-categories', function () {
            $mainCategories = MainCategory::with('categories')->orderBy('sort_order')->get();

            return view('admin.main-categories.index', compact('mainCategories'));
        })->name('main-categories.index');

        Route::get('/main-categories/create', function () {
            return view('admin.main-categories.create');
        })->name('main-categories.create');

        Route::post('/main-categories', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:main_categories,slug',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'hero_image' => 'nullable|image|max:5120',
                'hero_text' => 'nullable|string|max:255',
                'hero_button_text' => 'nullable|string|max:100',
                'banner_images' => 'nullable|array|max:3',
                'banner_images.*' => 'nullable|image|max:2048',
                'banner_texts' => 'nullable|array|max:3',
                'banner_texts.*' => 'nullable|string|max:255',
                'bottom_banner_image' => 'nullable|image|max:5120',
                'bottom_banner_text' => 'nullable|string|max:255',
                'testimonial_text' => 'nullable|string|max:1000',
                'additional_banner_image' => 'nullable|image|max:5120',
                'additional_banner_text' => 'nullable|string|max:255',
            ]);

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }

            if ($request->hasFile('hero_image')) {
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }

            $bannerImages = [];
            if ($request->has('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid()) {
                        $bannerImages[$index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }
            $validated['banner_images'] = ! empty($bannerImages) ? array_values($bannerImages) : null;

            if ($request->has('banner_texts')) {
                $validated['banner_texts'] = array_filter($request->banner_texts ?? []);
                $validated['banner_texts'] = ! empty($validated['banner_texts']) ? array_values($validated['banner_texts']) : null;
            }

            if ($request->hasFile('bottom_banner_image')) {
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }

            if ($request->hasFile('additional_banner_image')) {
                $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('main-categories/additional-banner', 'public');
            }

            MainCategory::create($validated);

            return redirect()->route('admin.main-categories.index')->with('success', 'Main category created successfully!');
        })->name('main-categories.store');

        Route::get('/main-categories/{id}', function ($id) {
            $category = MainCategory::with('categories')->findOrFail($id);

            return view('admin.main-categories.show', compact('category'));
        })->name('main-categories.show');

        Route::get('/main-categories/{id}/edit', function ($id) {
            $category = MainCategory::findOrFail($id);

            return view('admin.main-categories.edit', compact('category'));
        })->name('main-categories.edit');

        Route::put('/main-categories/{id}', function (Request $request, $id) {
            $category = MainCategory::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:main_categories,slug,'.$id,
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'remove_image' => 'nullable|boolean',
                'hero_image' => 'nullable|image|max:5120',
                'remove_hero_image' => 'nullable|boolean',
                'hero_text' => 'nullable|string|max:255',
                'hero_button_text' => 'nullable|string|max:100',
                'banner_images' => 'nullable|array|max:3',
                'banner_images.*' => 'nullable|image|max:2048',
                'remove_banner_image' => 'nullable|array',
                'banner_texts' => 'nullable|array|max:3',
                'banner_texts.*' => 'nullable|string|max:255',
                'bottom_banner_image' => 'nullable|image|max:5120',
                'remove_bottom_banner_image' => 'nullable|boolean',
                'bottom_banner_text' => 'nullable|string|max:255',
                'testimonial_text' => 'nullable|string|max:1000',
                'additional_banner_image' => 'nullable|image|max:5120',
                'remove_additional_banner_image' => 'nullable|boolean',
                'additional_banner_text' => 'nullable|string|max:255',
            ]);

            if ($request->filled('remove_image') && $request->remove_image == '1') {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = null;
            } elseif ($request->hasFile('image')) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }

            if ($request->filled('remove_hero_image') && $request->remove_hero_image == '1') {
                if ($category->hero_image) {
                    Storage::disk('public')->delete($category->hero_image);
                }
                $validated['hero_image'] = null;
            } elseif ($request->hasFile('hero_image')) {
                if ($category->hero_image) {
                    Storage::disk('public')->delete($category->hero_image);
                }
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }

            $bannerImages = is_array($category->banner_images) ? $category->banner_images : [];
            $removeBannerImages = $request->input('remove_banner_image', []);

            if ($request->has('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid()) {
                        if (isset($bannerImages[$index])) {
                            Storage::disk('public')->delete($bannerImages[$index]);
                        }
                        $bannerImages[$index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }

            foreach ($removeBannerImages as $index => $remove) {
                if ($remove == '1' && isset($bannerImages[$index])) {
                    Storage::disk('public')->delete($bannerImages[$index]);
                    unset($bannerImages[$index]);
                }
            }

            $validated['banner_images'] = ! empty($bannerImages) ? array_values($bannerImages) : null;

            if ($request->has('banner_texts')) {
                $validated['banner_texts'] = array_filter($request->banner_texts ?? []);
                $validated['banner_texts'] = ! empty($validated['banner_texts']) ? array_values($validated['banner_texts']) : null;
            }

            if ($request->filled('remove_bottom_banner_image') && $request->remove_bottom_banner_image == '1') {
                if ($category->bottom_banner_image) {
                    Storage::disk('public')->delete($category->bottom_banner_image);
                }
                $validated['bottom_banner_image'] = null;
            } elseif ($request->hasFile('bottom_banner_image')) {
                if ($category->bottom_banner_image) {
                    Storage::disk('public')->delete($category->bottom_banner_image);
                }
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }

            if ($request->filled('remove_additional_banner_image') && $request->remove_additional_banner_image == '1') {
                if ($category->additional_banner_image) {
                    Storage::disk('public')->delete($category->additional_banner_image);
                }
                $validated['additional_banner_image'] = null;
            } elseif ($request->hasFile('additional_banner_image')) {
                if ($category->additional_banner_image) {
                    Storage::disk('public')->delete($category->additional_banner_image);
                }
                $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('main-categories/additional-banner', 'public');
            }

            unset($validated['remove_image'], $validated['remove_hero_image'], $validated['remove_bottom_banner_image'], $validated['remove_additional_banner_image'], $validated['remove_banner_image']);

            $category->update($validated);

            return redirect()->route('admin.main-categories.index')->with('success', 'Main category updated successfully!');
        })->name('main-categories.update');

        Route::delete('/main-categories/{id}', function ($id) {
            $category = MainCategory::findOrFail($id);
            $category->delete();

            return redirect()->route('admin.main-categories.index')->with('success', 'Main category deleted successfully!');
        })->name('main-categories.destroy');

        // Inventory Routes
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/product/{id}', function ($id) {
            $product = Product::with(['category', 'inventories'])->findOrFail($id);
            $masterColors = MasterColor::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();
            $masterSizes = MasterSize::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();

            return view('admin.inventory.product', compact('product', 'masterColors', 'masterSizes'));
        })->name('inventory.product');
        Route::post('/inventory/product/{id}', [InventoryController::class, 'store'])->name('inventory.store');
        Route::post('/inventory/product/{id}/bulk', [InventoryController::class, 'bulkStore'])->name('inventory.bulk.store');
        Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

        // Product customizer (admin)
        Route::get('/customizer', [CustomizeSettingsController::class, 'index'])->name('customize.index');
        Route::put('/customizer', [CustomizeSettingsController::class, 'update'])->name('customize.update');

        // Color & Size Master
        Route::get('/color-size-master', [ColorSizeMasterController::class, 'index'])->name('color-size-master.index');
        Route::post('/color-size-master/colors', [ColorSizeMasterController::class, 'storeColor'])->name('color-size-master.store-color');
        Route::put('/color-size-master/colors/{color}', [ColorSizeMasterController::class, 'updateColor'])->name('color-size-master.update-color');
        Route::delete('/color-size-master/colors/{color}', [ColorSizeMasterController::class, 'destroyColor'])->name('color-size-master.destroy-color');
        Route::post('/color-size-master/sizes', [ColorSizeMasterController::class, 'storeSize'])->name('color-size-master.store-size');
        Route::put('/color-size-master/sizes/{size}', [ColorSizeMasterController::class, 'updateSize'])->name('color-size-master.update-size');
        Route::delete('/color-size-master/sizes/{size}', [ColorSizeMasterController::class, 'destroySize'])->name('color-size-master.destroy-size');

        // Payments Route
        Route::get('/payments', function () {
            $payments = Order::where('payment_status', 'paid')->orderBy('created_at', 'desc')->paginate(20);

            return view('admin.payments.index', compact('payments'));
        })->name('payments.index');

        // Coupons Routes
        Route::get('/coupons', function () {
            $coupons = Coupon::with('usages')->orderBy('created_at', 'desc')->get();

            return view('admin.coupons.index', compact('coupons'));
        })->name('coupons.index');

        Route::get('/coupons/create', function () {
            $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get();

            return view('admin.coupons.create', compact('mainCategories'));
        })->name('coupons.create');

        Route::post('/coupons', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:coupons,code',
                'description' => 'nullable|string',
                'main_category_ids' => 'nullable|array',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after:valid_from',
                'is_active' => 'nullable|boolean',
                'usage_limit' => 'nullable|integer|min:1',
                'minimum_order_amount' => 'nullable|numeric|min:0',
            ]);

            Coupon::create($validated);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
        })->name('coupons.store');

        Route::get('/coupons/{id}', function ($id) {
            $coupon = Coupon::with(['usages.user', 'usages.order'])->findOrFail($id);

            return view('admin.coupons.show', compact('coupon'));
        })->name('coupons.show');

        Route::get('/coupons/{id}/edit', function ($id) {
            $coupon = Coupon::findOrFail($id);
            $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get();

            return view('admin.coupons.edit', compact('coupon', 'mainCategories'));
        })->name('coupons.edit');

        Route::put('/coupons/{id}', function (Request $request, $id) {
            $coupon = Coupon::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:coupons,code,'.$id,
                'description' => 'nullable|string',
                'main_category_ids' => 'nullable|array',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after:valid_from',
                'is_active' => 'nullable|boolean',
                'usage_limit' => 'nullable|integer|min:1',
                'minimum_order_amount' => 'nullable|numeric|min:0',
            ]);

            $coupon->update($validated);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
        })->name('coupons.update');

        Route::delete('/coupons/{id}', function ($id) {
            $coupon = Coupon::findOrFail($id);
            if ($coupon->usages()->count() > 0) {
                return redirect()->route('admin.coupons.index')->with('error', 'Cannot delete coupon with usage history!');
            }
            $coupon->delete();

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
        })->name('coupons.destroy');
    });
});
