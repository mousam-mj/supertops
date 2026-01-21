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

// Logout Route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'You have been logged out successfully.');
})->name('logout');

// Register Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');

// Email verification routes
Route::get('/email/verify/{token}', [App\Http\Controllers\Auth\RegisterController::class, 'verifyEmail'])->name('email.verify');
Route::post('/email/resend-verification', [App\Http\Controllers\Auth\RegisterController::class, 'resendVerification'])->name('email.resend');

// Test email route (remove in production)
Route::get('/test-email', function() {
    try {
        Mail::raw('This is a test email from Laravel', function ($message) {
            $message->to('work@coderpoint.in')
                ->subject('Test Email - ' . config('app.name'));
        });
        return response()->json(['success' => true, 'message' => 'Test email sent! Check work@coderpoint.in']);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'error' => $e->getMessage(),
            'class' => get_class($e),
            'file' => $e->getFile() . ':' . $e->getLine()
        ], 500);
    }
})->name('test.email');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/collection', [ShopController::class, 'index'])->name('shop.collection');
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

// Forgot Password Route
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

// Order Tracking Route
Route::get('/order-tracking', function () {
    $order = null;
    if(request()->has('order_id') && request()->has('email')) {
        $order = \App\Models\Order::where('id', request()->get('order_id'))
            ->where('email', request()->get('email'))
            ->first();
    }
    return view('order-tracking', compact('order'));
})->name('order-tracking');

// Wishlist Route
Route::get('/wishlist', function () {
    $wishlistItems = [];
    if(auth()->check()) {
        // Get user's wishlist items - you'll need to implement wishlist functionality
        $wishlistItems = collect([]);
    }
    $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
    return view('wishlist', compact('wishlistItems', 'categories'));
})->name('wishlist');

// Search Route
Route::get('/search', function () {
    $query = request()->get('q', '');
    $products = collect([]);
    if($query) {
        $products = \App\Models\Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('short_description', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->paginate(20);
    }
    return view('search-result', compact('products', 'query'));
})->name('search');

// About Us Route
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Route
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:5000',
    ]);
    
    // Here you can send an email or save to database
    // For now, just return success message
    return redirect()->route('contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
})->name('contact.submit');

// FAQs Route
Route::get('/faqs', function () {
    return view('faqs');
})->name('faqs');

// Newsletter Subscription Route
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|max:255',
    ]);
    
    // Here you can save to database or send to email service
    // For now, just return success message
    return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
})->name('newsletter.subscribe');

// My Account Route (requires authentication)
Route::get('/my-account', function () {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }
    $user = auth()->user();
    $orders = \App\Models\Order::where('user_id', $user->id)
        ->orWhere('email', $user->email)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    $addresses = \App\Models\Address::where('user_id', $user->id)->get();
    
    // Get order statistics
    $awaitingPickup = \App\Models\Order::where(function($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('email', $user->email);
    })->where('status', 'processing')->count();
    $cancelledOrders = \App\Models\Order::where(function($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('email', $user->email);
    })->where('status', 'cancelled')->count();
    $totalOrders = \App\Models\Order::where(function($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('email', $user->email);
    })->count();
    
    return view('my-account', compact('user', 'orders', 'addresses', 'awaitingPickup', 'cancelledOrders', 'totalOrders'));
})->middleware('auth')->name('my-account');

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
