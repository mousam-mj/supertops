<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'category_id',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'stock',
        'in_stock',
        'is_active',
        'is_featured',
        'is_new_arrival',
        'image',
        'images',
        'color_images',
        'video',
        'sizes',
        'colors',
        'specifications',
        'customize_config',
        'product_type',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'stock' => 'integer',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'images' => 'array',
        'color_images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'specifications' => 'array',
        'customize_config' => 'array',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PROD-'.strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Limit to products under the Bearings main category (edx-bearing HTML catalog).
     */
    public function scopeEdxBearingsCatalog(Builder $query): Builder
    {
        $id = MainCategory::bearingsCatalogId();
        if ($id === null) {
            return $query;
        }

        return $query->whereHas('category', function (Builder $q) use ($id) {
            $q->where('main_category_id', $id);
        });
    }

    /**
     * Get cart items for this product
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get inventories for this product
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get order items for this product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get approved reviews (top-level, no replies in main list)
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->whereNull('parent_id')->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    /**
     * All reviews for rating stats (approved only)
     */
    public function allApprovedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    /**
     * Get current price (sale_price if available, otherwise price)
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get final price (alias for current_price)
     */
    public function getFinalPriceAttribute()
    {
        return $this->current_price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }

        return 0;
    }

    /**
     * Get total stock (sum of all inventory quantities)
     */
    public function getTotalStockAttribute()
    {
        return $this->inventories()->sum('quantity');
    }

    /**
     * Sync product stock_quantity and in_stock from inventory totals (e.g. after order deducts inventory)
     */
    public function syncStockFromInventories(): void
    {
        $total = (int) $this->inventories()->sum('quantity');
        $this->update([
            'stock_quantity' => $total,
            'in_stock' => $total > 0,
        ]);
    }

    /**
     * Get stock for specific color and size
     */
    public function getStockForColorSize($color = null, $size = null)
    {
        $query = $this->inventories();

        if ($color) {
            $query->where('color', $color);
        }

        if ($size) {
            $query->where('size', $size);
        }

        return $query->sum('quantity');
    }

    /**
     * Get image URL for a color variant (from color_images), or fallback to main image
     */
    public function getImageForColor($color)
    {
        if (! $color) {
            return $this->image;
        }
        $colorImages = $this->color_images ?? [];
        $key = trim($color);
        if (isset($colorImages[$key]) && $colorImages[$key]) {
            return $colorImages[$key];
        }

        return $this->image;
    }

    /**
     * Public URL for a stored image path (uploads under storage/app/public, or static files under public/).
     */
    public static function publicUrlForPath(?string $path): string
    {
        $fallback = asset('assets/images/PhotoshopExtension_Image-1.webp');

        if ($path === null || $path === '') {
            return $fallback;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'assets/')) {
            return is_file(public_path($path)) ? asset($path) : $fallback;
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/'.$path);
        }

        if (is_file(public_path($path))) {
            return asset($path);
        }

        return $fallback;
    }

    /**
     * Resolved main image URL for Blade / JSON (never points at wrong /storage/... for public assets).
     */
    public function getImageUrlAttribute(): string
    {
        return self::publicUrlForPath($this->attributes['image'] ?? null);
    }
}
