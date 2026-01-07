<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $products = collect([]); // Empty for now, can be populated later

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)
                ->with(['children.children', 'parent'])
                ->where('is_active', true)
                ->first();
        }

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
        $products = collect([]); // Empty for now, can be populated later

        return view('shop', compact('categories', 'category', 'products'));
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
