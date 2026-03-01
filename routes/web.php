<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PolicyPageController as AdminPolicyPageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ColorSizeMasterController;
use App\Http\Controllers\PolicyPageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductReviewController;

Route::get('/', function () {
    $categories = \App\Models\Category::whereNull('parent_id')
        ->with(['children.children'])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    
    // Get top 3 categories for home page banners
    $homeCategories = \App\Models\Category::whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->limit(3)
        ->get();
    
    // Get hero banners
    $heroBanners = \App\Models\HeroBanner::where('is_active', true)
        ->orderBy('priority', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Get featured products for "What's New" section (with main category for filtering)
    $featuredProducts = \App\Models\Product::where('is_active', true)
        ->where('is_featured', true)
        ->with('category.mainCategory')
        ->orderBy('sort_order')
        ->limit(12)
        ->get();

    // Main categories for What's New tabs and header
    $mainCategories = \App\Models\MainCategory::where('is_active', true)
        ->orderBy('sort_order')
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
    
    return view('home', compact('categories', 'homeCategories', 'heroBanners', 'featuredProducts', 'newArrivals', 'bestSellers', 'onSaleProducts', 'mainCategories'));
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
Route::post('/logout', function (\Illuminate\Http\Request $request) {
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

// Serve storage files via PHP when symlink returns 403 (e.g. shared hosting that blocks symlinks)
Route::get('/storage/{path}', function (string $path) {
    $path = preg_replace('#\.\./#', '', $path); // block directory traversal
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
    $realPath = realpath($fullPath);
    $storageRoot = realpath(storage_path('app/public'));
    if (!$realPath || !$storageRoot || strpos($realPath, $storageRoot) !== 0) {
        abort(404);
    }
    return response()->file($realPath);
})->where('path', '.*')->name('storage.serve');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/collection', [ShopController::class, 'index'])->name('shop.collection');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
Route::post('/product/{product}/review', [ProductReviewController::class, 'store'])->name('product.review.store');

// Cart & Checkout Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/place-order', [App\Http\Controllers\Api\OrderController::class, 'store'])->name('place-order');

// Test Route
Route::get('/test/hello', function() {
    return view('test.hello');
})->name('test.hello');

// Order Success Route
Route::get('/order-success/{id}', function($id) {
    $order = \App\Models\Order::with('items')->findOrFail($id);
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
            ->where('customer_email', request()->get('email'))
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
    if ($query) {
        $products = \App\Models\Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('short_description', 'like', '%' . $query . '%')
                    ->orWhere('sku', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->paginate(20)
            ->withQueryString();
    }
    return view('search-result', compact('products', 'query'));
})->name('search');

// AJAX search for modal (returns HTML)
Route::get('/search/ajax', function () {
    $query = request()->get('q', '');
    $products = collect([]);
    if ($query && strlen(trim($query)) >= 2) {
        $products = \App\Models\Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('short_description', 'like', '%' . $query . '%')
                    ->orWhere('sku', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->limit(8)
            ->get();
    }
    return response()->view('partials.search-results', ['products' => $products, 'query' => $query]);
})->name('search.ajax');

// Contact Route
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contact_number' => 'nullable|string|max:20',
        'subject' => 'required|string|max:255',
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

// Policy & content pages (About Us, Terms, Privacy, Return & Refund, Cancellation) - dynamic from admin
Route::get('/about', [PolicyPageController::class, 'show'])->defaults('slug', 'about-us')->name('about');
Route::get('/about-us', [PolicyPageController::class, 'show'])->defaults('slug', 'about-us')->name('about-us');
Route::get('/terms-and-conditions', [PolicyPageController::class, 'show'])->defaults('slug', 'terms-and-conditions')->name('terms-and-conditions');
Route::get('/privacy-policy', [PolicyPageController::class, 'show'])->defaults('slug', 'privacy-policy')->name('privacy-policy');
Route::get('/return-and-refund', [PolicyPageController::class, 'show'])->defaults('slug', 'return-and-refund')->name('return-and-refund');
Route::get('/cancellation-policy', [PolicyPageController::class, 'show'])->defaults('slug', 'cancellation-policy')->name('cancellation-policy');

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
        ->orWhere('customer_email', $user->email)
        ->with(['items.product.category'])
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    $addresses = \App\Models\Address::where('user_id', $user->id)->get();
    
    // Get order statistics
    $awaitingPickup = \App\Models\Order::where(function($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
    })->where('status', 'processing')->count();
    $cancelledOrders = \App\Models\Order::where(function($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
    })->where('status', 'cancelled')->count();
    $totalOrders = \App\Models\Order::where(function($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
    })->count();
    
    return view('my-account', compact('user', 'orders', 'addresses', 'awaitingPickup', 'cancelledOrders', 'totalOrders'));
})->middleware('auth')->name('my-account');

// Account: view single order details (must be own order)
Route::get('/account/orders/{id}', function ($id) {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to view your orders.');
    }
    $user = auth()->user();
    $order = \App\Models\Order::with(['items.product'])
        ->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
        })
        ->find($id);
    if (!$order) {
        abort(404);
    }
    return view('order.show', compact('order'));
})->middleware('auth')->name('account.orders.show');

// POST /my-account – save address (same URL as page, so cookies always match)
Route::post('/my-account', function (\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'label' => 'nullable|string|max:255',
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address_line_1' => 'required|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'pincode' => 'required|string|min:5|max:6',
        'is_default' => 'nullable',
    ]);
    if ($validator->fails()) {
        return redirect()->to('/my-account?tab=address' . ($request->input('address_id') ? '&edit=' . $request->input('address_id') : ''))
            ->withErrors($validator)
            ->withInput();
    }
    $validated = $validator->validated();
    $isDefault = $request->has('is_default') && in_array($request->input('is_default'), ['1', 1, true], true);
    $uid = auth()->id();
    $id = $request->input('address_id');
    
    try {
        if ($id) {
            $addr = \App\Models\Address::where('user_id', $uid)->find((int) $id);
            if (!$addr) {
                return redirect()->to('/my-account?tab=address')->withErrors(['error' => 'Address not found.'])->withInput();
            }
            if ($isDefault) {
                \App\Models\Address::where('user_id', $uid)->where('id', '!=', $id)->update(['is_default' => false]);
            }
            $addr->update([
                'label' => $validated['label'] ?? 'Home',
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'is_default' => $isDefault,
            ]);
            $msg = 'Address updated successfully!';
        } else {
            if ($isDefault) {
                \App\Models\Address::where('user_id', $uid)->update(['is_default' => false]);
            }
            \App\Models\Address::create([
                'user_id' => $uid,
                'label' => $validated['label'] ?? 'Home',
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'is_default' => $isDefault,
            ]);
            $msg = 'Address added successfully!';
        }
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Address save error: ' . $e->getMessage());
        return redirect()->to('/my-account?tab=address' . ($id ? '&edit=' . $id : ''))
            ->withErrors(['error' => 'Failed to save address. Please try again.'])
            ->withInput();
    }
    return redirect()->to('/my-account?tab=address')->with('success', $msg);
})->middleware('auth')->name('my-account.address.save');

// Update My Account Settings
Route::put('/my-account/settings', function (\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }
    
    $user = auth()->user();
    
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'gender' => 'required|in:Male,Female,Other',
        'date_of_birth' => 'required|date',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    if ($validator->fails()) {
        return redirect()->to('/my-account?tab=setting')
            ->withErrors($validator)
            ->withInput();
    }
    
    $validated = $validator->validated();
    
    try {
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && !str_starts_with($user->avatar, 'assets/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }
        
        // Update user
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'avatar' => $validated['avatar'] ?? $user->avatar,
        ]);
        
        return redirect()->to('/my-account?tab=setting')->with('settings_success', 'Settings updated successfully!');
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Settings update error: ' . $e->getMessage());
        return redirect()->to('/my-account?tab=setting')
            ->withErrors(['error' => 'Failed to update settings. Please try again.'])
            ->withInput();
    }
})->middleware('auth')->name('my-account.settings.update');

// Change Password
Route::put('/my-account/password', function (\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }
    
    $user = auth()->user();
    
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
            if (!\Illuminate\Support\Facades\Hash::check($value, $user->password)) {
                $fail('The current password is incorrect.');
            }
        }],
        'new_password' => 'required|string|min:8|confirmed',
    ]);
    
    if ($validator->fails()) {
        return redirect()->to('/my-account?tab=change-password')
            ->withErrors($validator)
            ->withInput();
    }
    
    try {
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);
        
        return redirect()->to('/my-account?tab=change-password')->with('password_success', 'Password changed successfully!');
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Password change error: ' . $e->getMessage());
        return redirect()->to('/my-account?tab=change-password')
            ->withErrors(['error' => 'Failed to change password. Please try again.'])
            ->withInput();
    }
})->middleware('auth')->name('my-account.password.update');

// Address Management Routes - Using Controller
// Test route to check if middleware is working
Route::get('/test-auth', function() {
    \Log::info('Test auth route hit', [
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'session_id' => session()->getId(),
    ]);
    return response()->json([
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'user' => auth()->user() ? auth()->user()->email : null,
    ]);
})->middleware(['log.auth', 'auth'])->name('test.auth');

Route::middleware('auth')->group(function () {
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
});

// Admin Routes
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

        // Reports hub (all downloads in one place)
        Route::get('/reports', [DashboardController::class, 'reportsIndex'])->name('reports.index');
        
        // Resource Routes
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class)->except(['create', 'store']);

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        // Policy Pages (Terms, Privacy, Return & Refund, Cancellation)
        Route::get('/policy-pages', [AdminPolicyPageController::class, 'index'])->name('policy-pages.index');
        Route::get('/policy-pages/{policy_page}/edit', [AdminPolicyPageController::class, 'edit'])->name('policy-pages.edit');
        Route::put('/policy-pages/{policy_page}', [AdminPolicyPageController::class, 'update'])->name('policy-pages.update');

        // Product reviews (list & delete)
        Route::get('/reviews', [App\Http\Controllers\Admin\ProductReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ProductReviewController::class, 'destroy'])->name('reviews.destroy');
        
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
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            }
            
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }
            
            // Handle hero image
            if ($request->hasFile('hero_image')) {
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }
            
            // Handle banner images
            $bannerImages = [];
            if ($request->has('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid()) {
                        $bannerImages[$index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }
            $validated['banner_images'] = !empty($bannerImages) ? array_values($bannerImages) : null;
            
            // Handle banner texts
            if ($request->has('banner_texts')) {
                $validated['banner_texts'] = array_filter($request->banner_texts ?? []);
                $validated['banner_texts'] = !empty($validated['banner_texts']) ? array_values($validated['banner_texts']) : null;
            }
            
            // Handle bottom banner image
            if ($request->hasFile('bottom_banner_image')) {
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }
            
            // Handle additional banner image
            if ($request->hasFile('additional_banner_image')) {
                $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('main-categories/additional-banner', 'public');
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
            
            // Handle image removal
            if ($request->filled('remove_image') && $request->remove_image == '1') {
                if ($category->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = null;
            } elseif ($request->hasFile('image')) {
                if ($category->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }
            
            // Handle hero image
            if ($request->filled('remove_hero_image') && $request->remove_hero_image == '1') {
                if ($category->hero_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->hero_image);
                }
                $validated['hero_image'] = null;
            } elseif ($request->hasFile('hero_image')) {
                if ($category->hero_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->hero_image);
                }
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }
            
            // Handle banner images
            $bannerImages = is_array($category->banner_images) ? $category->banner_images : [];
            $removeBannerImages = $request->input('remove_banner_image', []);
            
            if ($request->has('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid()) {
                        // Remove old image if exists
                        if (isset($bannerImages[$index])) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($bannerImages[$index]);
                        }
                        $bannerImages[$index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }
            
            // Remove banners marked for deletion
            foreach ($removeBannerImages as $index => $remove) {
                if ($remove == '1' && isset($bannerImages[$index])) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($bannerImages[$index]);
                    unset($bannerImages[$index]);
                }
            }
            
            $validated['banner_images'] = !empty($bannerImages) ? array_values($bannerImages) : null;
            
            // Handle banner texts
            if ($request->has('banner_texts')) {
                $validated['banner_texts'] = array_filter($request->banner_texts ?? []);
                $validated['banner_texts'] = !empty($validated['banner_texts']) ? array_values($validated['banner_texts']) : null;
            }
            
            // Handle bottom banner image
            if ($request->filled('remove_bottom_banner_image') && $request->remove_bottom_banner_image == '1') {
                if ($category->bottom_banner_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->bottom_banner_image);
                }
                $validated['bottom_banner_image'] = null;
            } elseif ($request->hasFile('bottom_banner_image')) {
                if ($category->bottom_banner_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->bottom_banner_image);
                }
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }
            
            // Handle additional banner image
            if ($request->filled('remove_additional_banner_image') && $request->remove_additional_banner_image == '1') {
                if ($category->additional_banner_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->additional_banner_image);
                }
                $validated['additional_banner_image'] = null;
            } elseif ($request->hasFile('additional_banner_image')) {
                if ($category->additional_banner_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->additional_banner_image);
                }
                $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('main-categories/additional-banner', 'public');
            }
            
            // Remove remove flags from validated
            unset($validated['remove_image'], $validated['remove_hero_image'], $validated['remove_bottom_banner_image'], $validated['remove_additional_banner_image'], $validated['remove_banner_image']);
            
            $category->update($validated);
            return redirect()->route('admin.main-categories.index')->with('success', 'Main category updated successfully!');
        })->name('main-categories.update');
        
        Route::delete('/main-categories/{id}', function($id) {
            $category = \App\Models\MainCategory::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.main-categories.index')->with('success', 'Main category deleted successfully!');
        })->name('main-categories.destroy');
        
        // Inventory Routes
        Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/product/{id}', function($id) {
            $product = \App\Models\Product::with(['category', 'inventories'])->findOrFail($id);
            $masterColors = \App\Models\MasterColor::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();
            $masterSizes = \App\Models\MasterSize::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();
            return view('admin.inventory.product', compact('product', 'masterColors', 'masterSizes'));
        })->name('inventory.product');
        Route::post('/inventory/product/{id}', [\App\Http\Controllers\Admin\InventoryController::class, 'store'])->name('inventory.store');
        Route::post('/inventory/product/{id}/bulk', [\App\Http\Controllers\Admin\InventoryController::class, 'bulkStore'])->name('inventory.bulk.store');
        Route::put('/inventory/{id}', [\App\Http\Controllers\Admin\InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{id}', [\App\Http\Controllers\Admin\InventoryController::class, 'destroy'])->name('inventory.destroy');
        
        // Color & Size Master
        Route::get('/color-size-master', [ColorSizeMasterController::class, 'index'])->name('color-size-master.index');
        Route::post('/color-size-master/colors', [ColorSizeMasterController::class, 'storeColor'])->name('color-size-master.store-color');
        Route::put('/color-size-master/colors/{color}', [ColorSizeMasterController::class, 'updateColor'])->name('color-size-master.update-color');
        Route::delete('/color-size-master/colors/{color}', [ColorSizeMasterController::class, 'destroyColor'])->name('color-size-master.destroy-color');
        Route::post('/color-size-master/sizes', [ColorSizeMasterController::class, 'storeSize'])->name('color-size-master.store-size');
        Route::put('/color-size-master/sizes/{size}', [ColorSizeMasterController::class, 'updateSize'])->name('color-size-master.update-size');
        Route::delete('/color-size-master/sizes/{size}', [ColorSizeMasterController::class, 'destroySize'])->name('color-size-master.destroy-size');
        
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
