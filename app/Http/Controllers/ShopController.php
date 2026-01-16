<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Show shop page with category filter
     */
    public function index(Request $request)
    {
        $categorySlug = $request->get('category');
        $category = null;
        $products = Product::where('is_active', true)->with('category');

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)
                ->with(['children.children', 'parent'])
                ->where('is_active', true)
                ->first();
                
            if ($category) {
                $categoryIds = $this->getCategoryIds($category);
                $products = $products->whereIn('category_id', $categoryIds);
            }
        }

        $products = $products->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(16);

        $categories = Category::whereNull('parent_id')
            ->with(['children.children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('shop', compact('categories', 'category', 'products'));
    }

    /**
     * Show category page
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['children.children', 'parent'])
            ->where('is_active', true)
            ->firstOrFail();

        $categories = Category::whereNull('parent_id')
            ->with(['children.children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get all products in this category and its subcategories
        $categoryIds = $this->getCategoryIds($category);
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(16);

        return view('shop', compact('categories', 'category', 'products'));
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

            return view('product.show', compact('product', 'relatedProducts'));
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
