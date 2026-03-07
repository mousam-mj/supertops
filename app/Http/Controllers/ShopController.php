<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Show shop page – mobile accessories only (category filter, search, sort)
     */
    public function index(Request $request)
    {
        $mobileMain = MainCategory::where('slug', 'mobile-accessories')->where('is_active', true)->first();
        $mobileCategoryIds = $mobileMain
            ? Category::where('main_category_id', $mobileMain->id)->pluck('id')->toArray()
            : [];

        $categorySlug = $request->get('category');
        $search = $request->get('search');
        $sort = $request->get('sort', 'default');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $category = null;
        $products = Product::where('is_active', true)->with('category');

        // Restrict to mobile accessories only
        if (!empty($mobileCategoryIds)) {
            $products = $products->whereIn('category_id', $mobileCategoryIds);
        }

        // Category filter
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)
                ->whereIn('id', $mobileCategoryIds ?: [0])
                ->with(['children.children', 'parent'])
                ->where('is_active', true)
                ->first();
            if ($category) {
                $categoryIds = $this->getCategoryIds($category);
                $products = $products->whereIn('category_id', $categoryIds);
            }
        }

        // Search filter
        if ($search) {
            $products = $products->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price filter
        if ($minPrice) {
            $products = $products->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
        }
        if ($maxPrice) {
            $products = $products->whereRaw('COALESCE(sale_price, price) <= ?', [$maxPrice]);
        }

        // Sort
        switch ($sort) {
            case 'price_low':
                $products = $products->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $products = $products->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products = $products->orderBy('name', 'desc');
                break;
            case 'newest':
                $products = $products->orderBy('created_at', 'desc');
                break;
            default:
                $products = $products->orderBy('sort_order')->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(16)->withQueryString();

        // Only mobile accessory categories for sidebar and tabs
        $categories = $mobileMain
            ? Category::where('main_category_id', $mobileMain->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->withCount(['products' => function ($q) {
                    $q->where('is_active', true);
                }])
                ->get()
            : collect();

        $totalMobileProducts = !empty($mobileCategoryIds)
            ? Product::where('is_active', true)->whereIn('category_id', $mobileCategoryIds)->count()
            : 0;

        return view('shop', compact('categories', 'category', 'products', 'totalMobileProducts'));
    }

    /**
     * Show category page
     */
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['children.children', 'parent', 'mainCategory'])
            ->where('is_active', true)
            ->firstOrFail();

        // Get MainCategory for fallback content
        $mainCategory = $category->mainCategory;

        $categories = Category::whereNull('parent_id')
            ->with(['children.children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get all products in this category and its subcategories
        $categoryIds = $this->getCategoryIds($category);
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with('category');

        // Search filter
        $search = $request->get('search');
        if ($search) {
            $products = $products->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price filter
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        if ($minPrice) {
            $products = $products->where(function($query) use ($minPrice) {
                $query->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
            });
        }
        if ($maxPrice) {
            $products = $products->where(function($query) use ($maxPrice) {
                $query->whereRaw('COALESCE(sale_price, price) <= ?', [$maxPrice]);
            });
        }

        // Sort
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price_low':
                $products = $products->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $products = $products->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products = $products->orderBy('name', 'desc');
                break;
            case 'newest':
                $products = $products->orderBy('created_at', 'desc');
                break;
            default:
                $products = $products->orderBy('sort_order')->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(16)->withQueryString();

        // Get subcategories for category page
        $subCategories = $category->children()->where('is_active', true)->get();
        
        // Get featured products for "What's new" section
        $featuredProducts = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->limit(8)
            ->get();

        return view('shop.category', compact('categories', 'category', 'mainCategory', 'products', 'subCategories', 'featuredProducts'));
    }

    /**
     * Show product detail page
     */
    public function show($slug)
    {
        try {
            $product = Product::where('slug', $slug)
                ->with(['category', 'category.parent'])
                ->first();
            
            if (!$product) {
                abort(404, 'Product not found');
            }
            
            // Check if product is active (optional - you might want to show inactive products to admins)
            // if (!$product->is_active) {
            //     abort(404, 'Product not available');
            // }

            // Get related products from the same category
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->with('category')
                ->limit(4)
                ->get();

            // If no related products, get from featured products
            if ($relatedProducts->isEmpty()) {
                $relatedProducts = Product::where('is_active', true)
                    ->where('is_featured', true)
                    ->where('id', '!=', $product->id)
                    ->with('category')
                    ->limit(4)
                    ->get();
            }

            // Get active coupons for discount codes
            $coupons = \App\Models\Coupon::where('is_active', true)
                ->where('valid_from', '<=', now())
                ->where('valid_until', '>=', now())
                ->limit(3)
                ->get();

            // Get previous and next products
            $prevProduct = Product::where('id', '<', $product->id)
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->first();
            
            $nextProduct = Product::where('id', '>', $product->id)
                ->where('is_active', true)
                ->orderBy('id', 'asc')
                ->first();

            return view('product.show', compact('product', 'relatedProducts', 'coupons', 'prevProduct', 'nextProduct'));
        } catch (\Exception $e) {
            \Log::error('Product show error: ' . $e->getMessage());
            abort(404, 'Product not found');
        }
    }

    /**
     * Get all category IDs including children
     */
    private function getCategoryIds($category)
    {
        $ids = [$category->id];
        
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            foreach ($child->children as $grandchild) {
                $ids[] = $grandchild->id;
            }
        }
        
        return $ids;
    }
}
