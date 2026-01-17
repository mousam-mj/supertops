<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ShopController;

Route::get('/', function () {
    $categories = \App\Models\Category::whereNull('parent_id')
        ->with(['children.children'])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    
    // Get hero banners
    $heroBanners = \App\Models\HeroBanner::where('is_active', true)
        ->orderBy('priority', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Get featured products for "What's New" section
    $featuredProducts = \App\Models\Product::where('is_active', true)
        ->where('is_featured', true)
        ->with('category')
        ->orderBy('sort_order')
        ->limit(8)
        ->get();
    
    // Get new arrivals
    $newArrivals = \App\Models\Product::where('is_active', true)
        ->where('is_new_arrival', true)
        ->with('category')
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
    
    // Get best sellers (top selling products - using featured for now, can be updated with actual sales data later)
    $bestSellers = \App\Models\Product::where('is_active', true)
        ->where('is_featured', true)
        ->with('category')
        ->orderBy('sort_order')
        ->limit(8)
        ->get();
    
    // Get products on sale (products with sale_price)
    $onSaleProducts = \App\Models\Product::where('is_active', true)
        ->whereNotNull('sale_price')
        ->whereColumn('sale_price', '<', 'price')
        ->with('category')
        ->orderBy('sort_order')
        ->limit(8)
        ->get();
    
    return view('home', compact('categories', 'heroBanners', 'featuredProducts', 'newArrivals', 'bestSellers', 'onSaleProducts'));
})->name('home');

// Regular Login Routes (for /login.html compatibility)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/login.html', function () {
    return view('auth.login');
});

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');

// Register Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');

// Cart & Checkout Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');

// Order Success Route
Route::get('/order-success/{id}', function($id) {
    $order = \App\Models\Order::findOrFail($id);
    return view('order.success', compact('order'));
})->name('order.success');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Routes (public)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Protected Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Resource Routes
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class)->except(['create', 'store']);
        
        // Additional Admin Routes
        Route::get('/alerts', function() {
            $lowStockCount = \App\Models\Product::where('stock_quantity', '<', 10)->where('is_active', true)->count();
            $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
            return view('admin.alerts.index', compact('lowStockCount', 'pendingOrdersCount'));
        })->name('alerts.index');
        
        // Main Categories Routes
        Route::get('/main-categories', function() {
            $mainCategories = \App\Models\MainCategory::with('categories')->orderBy('sort_order')->get();
            return view('admin.main-categories.index', compact('mainCategories'));
        })->name('main-categories.index');
        
        Route::get('/main-categories/create', function() {
            return view('admin.main-categories.create');
        })->name('main-categories.create');
        
        Route::post('/main-categories', function(\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:main_categories,slug',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            if (empty($validated['slug'])) {
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            }
            
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }
            
            \App\Models\MainCategory::create($validated);
            return redirect()->route('admin.main-categories.index')->with('success', 'Main category created successfully!');
        })->name('main-categories.store');
        
        Route::get('/main-categories/{id}', function($id) {
            $category = \App\Models\MainCategory::with('categories')->findOrFail($id);
            return view('admin.main-categories.show', compact('category'));
        })->name('main-categories.show');
        
        Route::get('/main-categories/{id}/edit', function($id) {
            $category = \App\Models\MainCategory::findOrFail($id);
            return view('admin.main-categories.edit', compact('category'));
        })->name('main-categories.edit');
        
        Route::put('/main-categories/{id}', function(\Illuminate\Http\Request $request, $id) {
            $category = \App\Models\MainCategory::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:main_categories,slug,' . $id,
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }
            
            $category->update($validated);
            return redirect()->route('admin.main-categories.index')->with('success', 'Main category updated successfully!');
        })->name('main-categories.update');
        
        Route::delete('/main-categories/{id}', function($id) {
            $category = \App\Models\MainCategory::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.main-categories.index')->with('success', 'Main category deleted successfully!');
        })->name('main-categories.destroy');
        
        // Inventory Route
        Route::get('/inventory', function() {
            $products = \App\Models\Product::with('category')->orderBy('name')->get();
            return view('admin.inventory.index', compact('products'));
        })->name('inventory.index');
        
        // Payments Route
        Route::get('/payments', function() {
            $payments = \App\Models\Order::where('payment_status', 'paid')->orderBy('created_at', 'desc')->paginate(20);
            return view('admin.payments.index', compact('payments'));
        })->name('payments.index');
        
        // Coupons Routes
        Route::get('/coupons', function() {
            $coupons = \App\Models\Coupon::with('usages')->orderBy('created_at', 'desc')->get();
            return view('admin.coupons.index', compact('coupons'));
        })->name('coupons.index');
        
        Route::get('/coupons/create', function() {
            $mainCategories = \App\Models\MainCategory::where('is_active', true)->orderBy('name')->get();
            return view('admin.coupons.create', compact('mainCategories'));
        })->name('coupons.create');
        
        Route::post('/coupons', function(\Illuminate\Http\Request $request) {
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
            
            \App\Models\Coupon::create($validated);
            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
        })->name('coupons.store');
        
        Route::get('/coupons/{id}', function($id) {
            $coupon = \App\Models\Coupon::with(['usages.user', 'usages.order'])->findOrFail($id);
            return view('admin.coupons.show', compact('coupon'));
        })->name('coupons.show');
        
        Route::get('/coupons/{id}/edit', function($id) {
            $coupon = \App\Models\Coupon::findOrFail($id);
            $mainCategories = \App\Models\MainCategory::where('is_active', true)->orderBy('name')->get();
            return view('admin.coupons.edit', compact('coupon', 'mainCategories'));
        })->name('coupons.edit');
        
        Route::put('/coupons/{id}', function(\Illuminate\Http\Request $request, $id) {
            $coupon = \App\Models\Coupon::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:coupons,code,' . $id,
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
        
        Route::delete('/coupons/{id}', function($id) {
            $coupon = \App\Models\Coupon::findOrFail($id);
            if ($coupon->usages()->count() > 0) {
                return redirect()->route('admin.coupons.index')->with('error', 'Cannot delete coupon with usage history!');
            }
            $coupon->delete();
            return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
        })->name('coupons.destroy');
    });
});
