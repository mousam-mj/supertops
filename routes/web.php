<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorSizeMasterController;
use App\Http\Controllers\Admin\CustomizeSettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\InstagramReelController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\PolicyPageController as AdminPolicyPageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\PolicyPageController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ShopController;
use App\Support\BannerMedia;
use App\Models\Address;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\FaqCategory;
use App\Models\HeroBanner;
use App\Models\MainCategory;
use App\Models\MasterColor;
use App\Models\MasterSize;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

Route::get('/', function () {
    $categories = Category::whereNull('parent_id')
        ->with(['children.children'])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    // Homepage category cards (Main Categories — image editable in Admin → Main Categories)
    $homeCategories = MainCategory::visible()
        ->with(['activeCategories' => fn ($q) => $q->whereNull('parent_id')->orderBy('sort_order')])
        ->orderBy('sort_order')
        ->limit(3)
        ->get();

    // Get hero banners
    $heroBanners = HeroBanner::where('is_active', true)
        ->orderBy('priority', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

    // Get featured products for "What's New" section (with main category for filtering)
    $featuredProducts = Product::where('is_active', true)
        ->where('is_featured', true)
        ->with('category.mainCategory')
        ->orderBy('sort_order')
        ->limit(12)
        ->get();

    // Main categories for What's New tabs and header
    $mainCategories = MainCategory::visible()
        ->orderBy('sort_order')
        ->get();

    // Get new arrivals
    $newArrivals = Product::where('is_active', true)
        ->where('is_new_arrival', true)
        ->with('category')
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    // Get best sellers (top selling products - using featured for now, can be updated with actual sales data later)
    $bestSellers = Product::where('is_active', true)
        ->where('is_featured', true)
        ->with('category')
        ->orderBy('sort_order')
        ->limit(8)
        ->get();

    // Get products on sale (products with sale_price)
    $onSaleProducts = Product::where('is_active', true)
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

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

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

Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Email verification routes
Route::get('/email/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('email.verify');
Route::post('/email/resend-verification', [RegisterController::class, 'resendVerification'])->name('email.resend');

// Test email route (remove in production)
Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email from Laravel', function ($message) {
            $message->to('work@coderpoint.in')
                ->subject('Test Email - '.config('app.name'));
        });

        return response()->json(['success' => true, 'message' => 'Test email sent! Check work@coderpoint.in']);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'class' => get_class($e),
            'file' => $e->getFile().':'.$e->getLine(),
        ], 500);
    }
})->name('test.email');

// Serve storage files via PHP when symlink returns 403 (shared hosting often blocks /storage or symlinks)
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

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/collection', [ShopController::class, 'index'])->name('shop.collection');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
Route::post('/product/{product}/review', [ProductReviewController::class, 'store'])->name('product.review.store');

// Cart & Checkout Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/place-order', [App\Http\Controllers\Api\OrderController::class, 'store'])->name('place-order');

// Test Route
Route::get('/test/hello', function () {
    return view('test.hello');
})->name('test.hello');

// Order Success Route
Route::get('/order-success/{id}', function ($id) {
    $order = Order::with('items')->findOrFail($id);

    // Calculate order breakdown
    $subtotal = $order->items->sum(function ($item) {
        return $item->price * $item->quantity;
    });
    $shippingCharge = $order->shipping_charge ?? 0;
    $codCharge = $order->cod_charge ?? 0;
    $couponDiscount = $order->coupon_discount ?? 0;
    $totalAmount = $order->total_amount;

    return view('order.success', compact('order', 'subtotal', 'shippingCharge', 'codCharge', 'couponDiscount', 'totalAmount'));
})->name('order.success');

// Forgot Password Route
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

// Reset Password Route (OTP + new password)
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

// Order Tracking Route
Route::get('/order-tracking', function () {
    $order = null;
    if (request()->has('order_id') && request()->has('email')) {
        $order = Order::where('id', request()->get('order_id'))
            ->where('customer_email', request()->get('email'))
            ->first();
    }

    return view('order-tracking', compact('order'));
})->name('order-tracking');

// Wishlist Route
Route::get('/wishlist', function () {
    $wishlistItems = [];
    if (auth()->check()) {
        // Get user's wishlist items - you'll need to implement wishlist functionality
        $wishlistItems = collect([]);
    }
    $mainCategories = \App\Models\MainCategory::visible()->orderBy('sort_order')->get();
    $subCategories = Category::where('is_active', true)
        ->whereNotNull('parent_id')
        ->orderBy('sort_order')
        ->get();

    return view('wishlist', compact('wishlistItems', 'mainCategories', 'subCategories'));
})->name('wishlist');

// Search Route
Route::get('/search', function () {
    $query = request()->get('q', '');
    $products = collect([]);
    if ($query) {
        $products = Product::where('is_active', true)
            ->searchTerm($query)
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
        $products = Product::where('is_active', true)
            ->searchTerm($query)
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

Route::post('/contact', function (Request $request) {
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

// FAQs Route (dynamic from admin)
Route::get('/faqs', function () {
    $faqCategories = FaqCategory::where('is_active', true)
        ->with(['activeItems'])
        ->orderBy('sort_order')
        ->get();

    return view('faqs', compact('faqCategories'));
})->name('faqs');

// About Us — content editable in Admin → Policy Pages
Route::get('/about', [AboutController::class, 'show'])->name('about');
Route::get('/about-us', [AboutController::class, 'show'])->name('about-us');

// Customize Tumbler (product-specific)
Route::get('/customize-assets/app.js', [CustomizeController::class, 'appJs'])->name('customize.app.js');
Route::get('/customize-assets/stl/{part}', [CustomizeController::class, 'partStl'])
    ->where('part', 'body|logo|cap|ring|straw|handle|boot')
    ->name('customize.part.stl');
Route::get('/customize', [CustomizeController::class, 'show'])->name('customize');
Route::get('/customize/{slug}', [CustomizeController::class, 'show'])->name('customize.product');

// Policy & content pages (Terms, Privacy, Return & Refund, Cancellation) - dynamic from admin
Route::get('/terms-and-conditions', [PolicyPageController::class, 'show'])->defaults('slug', 'terms-and-conditions')->name('terms-and-conditions');
Route::get('/privacy-policy', [PolicyPageController::class, 'show'])->defaults('slug', 'privacy-policy')->name('privacy-policy');
Route::get('/return-and-refund', [PolicyPageController::class, 'show'])->defaults('slug', 'return-and-refund')->name('return-and-refund');
Route::get('/cancellation-policy', [PolicyPageController::class, 'show'])->defaults('slug', 'cancellation-policy')->name('cancellation-policy');

// Newsletter Subscription Route
Route::post('/newsletter/subscribe', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|max:255',
    ]);

    // Here you can save to database or send to email service
    // For now, just return success message
    return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
})->name('newsletter.subscribe');

// My Account Route (requires authentication)
Route::get('/my-account', function () {
    if (! auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }
    $user = auth()->user();
    $orders = Order::where('user_id', $user->id)
        ->orWhere('customer_email', $user->email)
        ->with(['items.product.category'])
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    $addresses = Address::where('user_id', $user->id)->get();

    // Get order statistics
    $awaitingPickup = Order::where(function ($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
    })->where('status', 'processing')->count();
    $cancelledOrders = Order::where(function ($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
    })->where('status', 'cancelled')->count();
    $totalOrders = Order::where(function ($q) use ($user) {
        $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
    })->count();

    return view('my-account', compact('user', 'orders', 'addresses', 'awaitingPickup', 'cancelledOrders', 'totalOrders'));
})->middleware('auth')->name('my-account');

// Account: view single order details (must be own order)
Route::get('/account/orders/{id}', function ($id) {
    if (! auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to view your orders.');
    }
    $user = auth()->user();
    $order = Order::with(['items.product'])
        ->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
        })
        ->find($id);
    if (! $order) {
        abort(404);
    }

    return view('order.show', compact('order'));
})->middleware('auth')->name('account.orders.show');

// POST /my-account – save address (same URL as page, so cookies always match)
Route::post('/my-account', function (Request $request) {
    if (! auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }
    $validator = Validator::make($request->all(), [
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
        return redirect()->to('/my-account?tab=address'.($request->input('address_id') ? '&edit='.$request->input('address_id') : ''))
            ->withErrors($validator)
            ->withInput();
    }
    $validated = $validator->validated();
    $isDefault = $request->has('is_default') && in_array($request->input('is_default'), ['1', 1, true], true);
    $uid = auth()->id();
    $id = $request->input('address_id');

    try {
        if ($id) {
            $addr = Address::where('user_id', $uid)->find((int) $id);
            if (! $addr) {
                return redirect()->to('/my-account?tab=address')->withErrors(['error' => 'Address not found.'])->withInput();
            }
            if ($isDefault) {
                Address::where('user_id', $uid)->where('id', '!=', $id)->update(['is_default' => false]);
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
                Address::where('user_id', $uid)->update(['is_default' => false]);
            }
            Address::create([
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
    } catch (Throwable $e) {
        Illuminate\Support\Facades\Log::error('Address save error: '.$e->getMessage());

        return redirect()->to('/my-account?tab=address'.($id ? '&edit='.$id : ''))
            ->withErrors(['error' => 'Failed to save address. Please try again.'])
            ->withInput();
    }

    return redirect()->to('/my-account?tab=address')->with('success', $msg);
})->middleware('auth')->name('my-account.address.save');

// Update My Account Settings
Route::put('/my-account/settings', function (Request $request) {
    if (! auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }

    $user = auth()->user();

    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        'gender' => 'nullable|in:Male,Female,Other',
        'date_of_birth' => 'nullable|date',
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
            if ($user->avatar && ! str_starts_with($user->avatar, 'assets/')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        // Update user (date_of_birth is optional)
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'].' '.$validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'gender' => ! empty($validated['gender']) ? $validated['gender'] : null,
            'date_of_birth' => ! empty($validated['date_of_birth']) ? $validated['date_of_birth'] : null,
            'avatar' => $validated['avatar'] ?? $user->avatar,
        ]);

        return redirect()->to('/my-account?tab=setting')->with('settings_success', 'Settings updated successfully!');
    } catch (Throwable $e) {
        Illuminate\Support\Facades\Log::error('Settings update error: '.$e->getMessage());

        return redirect()->to('/my-account?tab=setting')
            ->withErrors(['error' => 'Failed to update settings. Please try again.'])
            ->withInput();
    }
})->middleware('auth')->name('my-account.settings.update');

// Change Password
Route::put('/my-account/password', function (Request $request) {
    if (! auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to access your account.');
    }

    $user = auth()->user();

    $validator = Validator::make($request->all(), [
        'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
            if (! Hash::check($value, $user->password)) {
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
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->to('/my-account?tab=change-password')->with('password_success', 'Password changed successfully!');
    } catch (Throwable $e) {
        Illuminate\Support\Facades\Log::error('Password change error: '.$e->getMessage());

        return redirect()->to('/my-account?tab=change-password')
            ->withErrors(['error' => 'Failed to change password. Please try again.'])
            ->withInput();
    }
})->middleware('auth')->name('my-account.password.update');

// Address Management Routes - Using Controller
// Test route to check if middleware is working
Route::get('/test-auth', function () {
    Log::info('Test auth route hit', [
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
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    });

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

        // Backups (database + images)
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/backup/database', [BackupController::class, 'downloadDatabase'])->name('backup.database');
        Route::get('/backup/images', [BackupController::class, 'downloadImages'])->name('backup.images');
        Route::get('/backup/download/{file}', [BackupController::class, 'downloadStored'])->name('backup.download');

        // Resource Routes
        Route::resource('users', UserController::class);
        Route::get('products/import/template', [ProductController::class, 'importTemplate'])->name('products.import.template');
        Route::post('products/import', [ProductController::class, 'importCsv'])->name('products.import');
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class)->except(['create', 'store']);
        Route::resource('hero-banners', HeroBannerController::class)->except(['show']);

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/instagram-reels', [InstagramReelController::class, 'index'])->name('instagram-reels.index');
        Route::post('/instagram-reels', [InstagramReelController::class, 'store'])->name('instagram-reels.store');
        Route::post('/instagram-reels/sync', [InstagramReelController::class, 'sync'])->name('instagram-reels.sync');
        Route::put('/instagram-reels/sort', [InstagramReelController::class, 'updateSort'])->name('instagram-reels.sort');
        Route::delete('/instagram-reels/{instagram_reel}', [InstagramReelController::class, 'destroy'])->name('instagram-reels.destroy');

        // Policy Pages (Terms, Privacy, Return & Refund, Cancellation)
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

        // Product reviews (list & delete)
        Route::get('/reviews', [App\Http\Controllers\Admin\ProductReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ProductReviewController::class, 'destroy'])->name('reviews.destroy');

        // Additional Admin Routes
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
                'image_mobile' => 'nullable|image|max:2048',
                'hero_image' => 'nullable|image|max:5120',
                'hero_image_mobile' => 'nullable|image|max:5120',
                'hero_text' => 'nullable|string|max:255',
                'hero_button_text' => 'nullable|string|max:100',
                'hero_button_url' => 'nullable|string|max:500',
                'hero_show_text' => 'nullable|boolean',
                'hero_text_color' => 'nullable|string|in:black,white',
                'promo_show_text' => 'nullable|boolean',
                'promo_button_text' => 'nullable|string|max:100',
                'promo_text_color' => 'nullable|string|in:black,white',
                'subcategory_cards_show_text' => 'nullable|boolean',
                'banner_images' => 'nullable|array|max:6',
                'banner_images.*' => 'nullable|image|max:2048',
                'banner_images_mobile' => 'nullable|array|max:6',
                'banner_images_mobile.*' => 'nullable|image|max:2048',
                'banner_texts' => 'nullable|array|max:6',
                'banner_texts.*' => 'nullable|string|max:255',
                'banner_urls' => 'nullable|array|max:6',
                'banner_urls.*' => 'nullable|string|max:500',
                'promo_banner_count' => 'nullable|integer|min:1|max:6',
                'bottom_banner_image' => 'nullable|image|max:5120',
                'bottom_banner_image_mobile' => 'nullable|image|max:5120',
                'bottom_banner_text' => 'nullable|string|max:255',
                'bottom_banner_subtext' => 'nullable|string|max:255',
                'bottom_banner_button_text' => 'nullable|string|max:100',
                'bottom_banner_button_url' => 'nullable|string|max:500',
                'bottom_banner_bg_image' => 'nullable|image|max:5120',
                'bottom_banner_bg_image_mobile' => 'nullable|image|max:5120',
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
            if ($request->hasFile('image_mobile')) {
                $validated['image_mobile'] = $request->file('image_mobile')->store('main-categories', 'public');
            }

            // Handle hero image
            if ($request->hasFile('hero_image')) {
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }
            if ($request->hasFile('hero_image_mobile')) {
                $validated['hero_image_mobile'] = $request->file('hero_image_mobile')->store('main-categories/hero', 'public');
            }

            // Handle banner images (indexed slots 0–5)
            $bannerImages = array_fill(0, 6, null);
            if ($request->hasFile('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid() && $index >= 0 && $index < 6) {
                        $bannerImages[(int) $index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }
            $validated['banner_images'] = BannerMedia::filteredJsonSlots($bannerImages);

            $bannerImagesMobile = array_fill(0, 6, null);
            if ($request->hasFile('banner_images_mobile')) {
                foreach ($request->file('banner_images_mobile') as $index => $file) {
                    if ($file && $file->isValid() && $index >= 0 && $index < 6) {
                        $bannerImagesMobile[(int) $index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }
            $validated['banner_images_mobile'] = BannerMedia::filteredJsonSlots($bannerImagesMobile);

            // Handle banner texts
            if ($request->has('banner_texts')) {
                $bannerTexts = [];
                foreach ($request->input('banner_texts', []) as $index => $text) {
                    if ($index >= 6) {
                        break;
                    }
                    $text = trim((string) $text);
                    $bannerTexts[(int) $index] = $text !== '' ? $text : null;
                }
                $validated['banner_texts'] = count(array_filter($bannerTexts)) > 0 ? $bannerTexts : null;
            }

            if ($request->has('banner_urls')) {
                $bannerUrls = [];
                foreach ($request->input('banner_urls', []) as $index => $url) {
                    if ($index >= 6) {
                        break;
                    }
                    $url = trim((string) $url);
                    $bannerUrls[(int) $index] = $url !== '' ? $url : null;
                }
                $validated['banner_urls'] = count(array_filter($bannerUrls)) > 0 ? $bannerUrls : null;
            }

            $validated['promo_banner_count'] = max(1, min(6, (int) $request->input('promo_banner_count', 3)));

            // Handle bottom banner image
            if ($request->hasFile('bottom_banner_image')) {
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }
            if ($request->hasFile('bottom_banner_image_mobile')) {
                $validated['bottom_banner_image_mobile'] = $request->file('bottom_banner_image_mobile')->store('main-categories/bottom-banner', 'public');
            }
            if ($request->hasFile('bottom_banner_bg_image')) {
                $validated['bottom_banner_bg_image'] = $request->file('bottom_banner_bg_image')->store('main-categories/bottom-banner', 'public');
            }
            if ($request->hasFile('bottom_banner_bg_image_mobile')) {
                $validated['bottom_banner_bg_image_mobile'] = $request->file('bottom_banner_bg_image_mobile')->store('main-categories/bottom-banner', 'public');
            }
            $validated['bottom_banner_section_enabled'] = $request->boolean('bottom_banner_section_enabled');
            $validated['bottom_banner_show_text'] = $request->boolean('bottom_banner_show_text');
            $validated['bottom_banner_blocks_enabled'] = $request->boolean('bottom_banner_blocks_enabled');
            $validated['hero_show_text'] = $request->boolean('hero_show_text', true);
            $validated['hero_text_color'] = normalize_banner_text_color($request->input('hero_text_color'));
            $validated['promo_show_text'] = $request->boolean('promo_show_text', true);
            $validated['promo_text_color'] = normalize_banner_text_color($request->input('promo_text_color'));
            $validated['subcategory_cards_show_text'] = $request->boolean('subcategory_cards_show_text', true);
            $validated['hero_section_enabled'] = $request->boolean('hero_section_enabled', true);
            $validated['whats_new_section_enabled'] = $request->boolean('whats_new_section_enabled', true);
            $validated['subcategory_cards_section_enabled'] = $request->boolean('subcategory_cards_section_enabled', true);
            $validated['testimonial_section_enabled'] = $request->boolean('testimonial_section_enabled', true);
            $validated['promo_section_enabled'] = $request->boolean('promo_section_enabled', true);
            $validated['benefits_section_enabled'] = $request->boolean('benefits_section_enabled', true);
            $validated['instagram_section_enabled'] = $request->boolean('instagram_section_enabled', true);

            // Handle additional banner image
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
                'image_mobile' => 'nullable|image|max:2048',
                'remove_image' => 'nullable|boolean',
                'remove_image_mobile' => 'nullable|boolean',
                'hero_image' => 'nullable|image|max:5120',
                'hero_image_mobile' => 'nullable|image|max:5120',
                'remove_hero_image' => 'nullable|boolean',
                'remove_hero_image_mobile' => 'nullable|boolean',
                'hero_text' => 'nullable|string|max:255',
                'hero_button_text' => 'nullable|string|max:100',
                'hero_button_url' => 'nullable|string|max:500',
                'hero_show_text' => 'nullable|boolean',
                'hero_text_color' => 'nullable|string|in:black,white',
                'promo_show_text' => 'nullable|boolean',
                'promo_button_text' => 'nullable|string|max:100',
                'promo_text_color' => 'nullable|string|in:black,white',
                'subcategory_cards_show_text' => 'nullable|boolean',
                'banner_images' => 'nullable|array|max:6',
                'banner_images.*' => 'nullable|image|max:2048',
                'banner_images_mobile' => 'nullable|array|max:6',
                'banner_images_mobile.*' => 'nullable|image|max:2048',
                'remove_banner_image' => 'nullable|array',
                'remove_banner_image_mobile' => 'nullable|array',
                'banner_texts' => 'nullable|array|max:6',
                'banner_texts.*' => 'nullable|string|max:255',
                'banner_urls' => 'nullable|array|max:6',
                'banner_urls.*' => 'nullable|string|max:500',
                'bottom_banner_image' => 'nullable|image|max:5120',
                'bottom_banner_image_mobile' => 'nullable|image|max:5120',
                'remove_bottom_banner_image' => 'nullable|boolean',
                'remove_bottom_banner_image_mobile' => 'nullable|boolean',
                'bottom_banner_text' => 'nullable|string|max:255',
                'bottom_banner_subtext' => 'nullable|string|max:255',
                'bottom_banner_button_text' => 'nullable|string|max:100',
                'bottom_banner_button_url' => 'nullable|string|max:500',
                'bottom_banner_bg_image' => 'nullable|image|max:5120',
                'bottom_banner_bg_image_mobile' => 'nullable|image|max:5120',
                'remove_bottom_banner_bg_image' => 'nullable|boolean',
                'remove_bottom_banner_bg_image_mobile' => 'nullable|boolean',
                'testimonial_text' => 'nullable|string|max:1000',
                'additional_banner_image' => 'nullable|image|max:5120',
                'remove_additional_banner_image' => 'nullable|boolean',
                'additional_banner_text' => 'nullable|string|max:255',
                'promo_banner_count' => 'nullable|integer|min:1|max:6',
                'bottom_banner_images' => 'nullable|array|max:4',
                'bottom_banner_images.*' => 'nullable|image|max:5120',
                'bottom_banner_images_mobile' => 'nullable|array|max:4',
                'bottom_banner_images_mobile.*' => 'nullable|image|max:5120',
                'remove_bottom_banner_images' => 'nullable|array',
                'remove_bottom_banner_images_mobile' => 'nullable|array',
                'bottom_banner_block_urls' => 'nullable|array|max:4',
                'bottom_banner_block_urls.*' => 'nullable|string|max:500',
            ]);

            // Handle image removal
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

            $imageMobile = BannerMedia::removeIfRequested($request, 'remove_image_mobile', $category->image_mobile);
            $replacedImageMobile = BannerMedia::replaceUploaded($request, 'image_mobile', $category->image_mobile, 'main-categories');
            if ($replacedImageMobile !== null) {
                $imageMobile = $replacedImageMobile;
            }
            $validated['image_mobile'] = $imageMobile;

            // Handle hero image
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

            $heroImageMobile = BannerMedia::removeIfRequested($request, 'remove_hero_image_mobile', $category->hero_image_mobile);
            $replacedHeroImageMobile = BannerMedia::replaceUploaded($request, 'hero_image_mobile', $category->hero_image_mobile, 'main-categories/hero');
            if ($replacedHeroImageMobile !== null) {
                $heroImageMobile = $replacedHeroImageMobile;
            }
            $validated['hero_image_mobile'] = $heroImageMobile;

            // Handle banner images (indexed slots 0–5)
            $bannerImages = is_array($category->banner_images) ? $category->banner_images : [];
            while (count($bannerImages) < 6) {
                $bannerImages[] = null;
            }
            $bannerImages = array_slice($bannerImages, 0, 6);
            $removeBannerImages = $request->input('remove_banner_image', []);

            if ($request->hasFile('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid() && $index >= 0 && $index < 6) {
                        if (! empty($bannerImages[$index])) {
                            Storage::disk('public')->delete($bannerImages[$index]);
                        }
                        $bannerImages[(int) $index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }

            foreach ($removeBannerImages as $index => $remove) {
                if ($remove == '1' && ! empty($bannerImages[$index])) {
                    Storage::disk('public')->delete($bannerImages[$index]);
                    $bannerImages[(int) $index] = null;
                }
            }

            $validated['banner_images'] = BannerMedia::filteredJsonSlots($bannerImages);

            $bannerImagesMobile = BannerMedia::syncJsonImageSlots(
                $request,
                'banner_images_mobile',
                'remove_banner_image_mobile',
                is_array($category->banner_images_mobile) ? $category->banner_images_mobile : [],
                6,
                'main-categories/banners'
            );
            $validated['banner_images_mobile'] = BannerMedia::filteredJsonSlots($bannerImagesMobile);

            // Handle banner texts
            if ($request->has('banner_texts')) {
                $bannerTexts = [];
                foreach ($request->input('banner_texts', []) as $index => $text) {
                    if ($index >= 6) {
                        break;
                    }
                    $text = trim((string) $text);
                    $bannerTexts[(int) $index] = $text !== '' ? $text : null;
                }
                $validated['banner_texts'] = count(array_filter($bannerTexts)) > 0 ? $bannerTexts : null;
            }

            if ($request->has('banner_urls')) {
                $bannerUrls = [];
                foreach ($request->input('banner_urls', []) as $index => $url) {
                    if ($index >= 6) {
                        break;
                    }
                    $url = trim((string) $url);
                    $bannerUrls[(int) $index] = $url !== '' ? $url : null;
                }
                $validated['banner_urls'] = count(array_filter($bannerUrls)) > 0 ? $bannerUrls : null;
            }

            // Handle bottom banner image
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

            $bottomBannerImageMobile = BannerMedia::removeIfRequested($request, 'remove_bottom_banner_image_mobile', $category->bottom_banner_image_mobile);
            $replacedBottomBannerImageMobile = BannerMedia::replaceUploaded($request, 'bottom_banner_image_mobile', $category->bottom_banner_image_mobile, 'main-categories/bottom-banner');
            if ($replacedBottomBannerImageMobile !== null) {
                $bottomBannerImageMobile = $replacedBottomBannerImageMobile;
            }
            $validated['bottom_banner_image_mobile'] = $bottomBannerImageMobile;

            if ($request->filled('remove_bottom_banner_bg_image') && $request->remove_bottom_banner_bg_image == '1') {
                if ($category->bottom_banner_bg_image) {
                    Storage::disk('public')->delete($category->bottom_banner_bg_image);
                }
                $validated['bottom_banner_bg_image'] = null;
            } elseif ($request->hasFile('bottom_banner_bg_image')) {
                if ($category->bottom_banner_bg_image) {
                    Storage::disk('public')->delete($category->bottom_banner_bg_image);
                }
                $validated['bottom_banner_bg_image'] = $request->file('bottom_banner_bg_image')->store('main-categories/bottom-banner', 'public');
            }

            $bottomBannerBgMobile = BannerMedia::removeIfRequested($request, 'remove_bottom_banner_bg_image_mobile', $category->bottom_banner_bg_image_mobile);
            $replacedBottomBannerBgMobile = BannerMedia::replaceUploaded($request, 'bottom_banner_bg_image_mobile', $category->bottom_banner_bg_image_mobile, 'main-categories/bottom-banner');
            if ($replacedBottomBannerBgMobile !== null) {
                $bottomBannerBgMobile = $replacedBottomBannerBgMobile;
            }
            $validated['bottom_banner_bg_image_mobile'] = $bottomBannerBgMobile;

            $validated['bottom_banner_section_enabled'] = $request->boolean('bottom_banner_section_enabled');
            $validated['bottom_banner_show_text'] = $request->boolean('bottom_banner_show_text');
            $validated['bottom_banner_blocks_enabled'] = $request->boolean('bottom_banner_blocks_enabled');
            $validated['hero_show_text'] = $request->boolean('hero_show_text', true);
            $validated['hero_text_color'] = normalize_banner_text_color($request->input('hero_text_color'));
            $validated['promo_show_text'] = $request->boolean('promo_show_text', true);
            $validated['promo_text_color'] = normalize_banner_text_color($request->input('promo_text_color'));
            $validated['subcategory_cards_show_text'] = $request->boolean('subcategory_cards_show_text', true);
            $validated['hero_section_enabled'] = $request->boolean('hero_section_enabled', true);
            $validated['whats_new_section_enabled'] = $request->boolean('whats_new_section_enabled', true);
            $validated['subcategory_cards_section_enabled'] = $request->boolean('subcategory_cards_section_enabled', true);
            $validated['testimonial_section_enabled'] = $request->boolean('testimonial_section_enabled', true);
            $validated['promo_section_enabled'] = $request->boolean('promo_section_enabled', true);
            $validated['benefits_section_enabled'] = $request->boolean('benefits_section_enabled', true);
            $validated['instagram_section_enabled'] = $request->boolean('instagram_section_enabled', true);

            $bottomBannerImages = is_array($category->bottom_banner_images) ? $category->bottom_banner_images : [];
            while (count($bottomBannerImages) < 4) {
                $bottomBannerImages[] = null;
            }
            if ($request->has('bottom_banner_images')) {
                foreach ($request->file('bottom_banner_images', []) as $index => $file) {
                    if ($file && $file->isValid()) {
                        if (! empty($bottomBannerImages[$index])) {
                            Storage::disk('public')->delete($bottomBannerImages[$index]);
                        }
                        $bottomBannerImages[$index] = $file->store('main-categories/bottom-blocks', 'public');
                    }
                }
            }
            foreach ($request->input('remove_bottom_banner_images', []) as $index => $remove) {
                if ($remove == '1' && ! empty($bottomBannerImages[$index])) {
                    Storage::disk('public')->delete($bottomBannerImages[$index]);
                    $bottomBannerImages[$index] = null;
                }
            }
            $validated['bottom_banner_images'] = BannerMedia::filteredJsonSlots(array_slice($bottomBannerImages, 0, 4));

            $bottomBannerImagesMobile = BannerMedia::syncJsonImageSlots(
                $request,
                'bottom_banner_images_mobile',
                'remove_bottom_banner_images_mobile',
                is_array($category->bottom_banner_images_mobile) ? $category->bottom_banner_images_mobile : [],
                4,
                'main-categories/bottom-blocks'
            );
            $validated['bottom_banner_images_mobile'] = BannerMedia::filteredJsonSlots(array_slice($bottomBannerImagesMobile, 0, 4));

            $blockUrls = [];
            foreach ($request->input('bottom_banner_block_urls', []) as $index => $url) {
                if ($index >= 4) {
                    break;
                }
                $url = trim((string) $url);
                $blockUrls[$index] = $url !== '' ? $url : null;
            }
            while (count($blockUrls) < 4) {
                $blockUrls[] = null;
            }
            $validated['bottom_banner_block_urls'] = count(array_filter($blockUrls)) > 0 ? $blockUrls : null;
            $validated['promo_banner_count'] = max(1, min(6, (int) $request->input('promo_banner_count', $category->promo_banner_count ?? 3)));

            // Handle additional banner image
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

            // Remove remove flags from validated
            unset(
                $validated['remove_image'],
                $validated['remove_image_mobile'],
                $validated['remove_hero_image'],
                $validated['remove_hero_image_mobile'],
                $validated['remove_bottom_banner_image'],
                $validated['remove_bottom_banner_image_mobile'],
                $validated['remove_bottom_banner_bg_image'],
                $validated['remove_bottom_banner_bg_image_mobile'],
                $validated['remove_additional_banner_image'],
                $validated['remove_banner_image'],
                $validated['remove_banner_image_mobile'],
                $validated['remove_bottom_banner_images'],
                $validated['remove_bottom_banner_images_mobile']
            );

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
            $masterColorCodes = MasterColor::pluck('color_code', 'name')->toArray();

            return view('admin.inventory.product', compact('product', 'masterColors', 'masterSizes', 'masterColorCodes'));
        })->name('inventory.product');
        Route::post('/inventory/product/{id}/color-swatches', [InventoryController::class, 'updateColorSwatches'])->name('inventory.color-swatches');
        Route::post('/inventory/product/{id}', [InventoryController::class, 'store'])->name('inventory.store');
        Route::post('/inventory/product/{id}/bulk', [InventoryController::class, 'bulkStore'])->name('inventory.bulk.store');
        Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

        // Product customizer (admin)
        Route::get('/customizer', [CustomizeSettingsController::class, 'index'])->name('customize.index');
        Route::put('/customizer', [CustomizeSettingsController::class, 'update'])->name('customize.update');

        // Color & Size Master (inventory product options)
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
