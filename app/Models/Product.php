<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'video',
        'sizes',
        'colors',
        'specifications',
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
        'sizes' => 'array',
        'colors' => 'array',
        'specifications' => 'array',
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
                $product->sku = 'PROD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
     * Default placeholder image URL – use when product has no image or image fails to load.
     * Neutral "no image" graphic only; not a product image.
     */
    public static function placeholderImageUrl(): string
    {
        return asset('assets/images/product/placeholder.svg');
    }

    /**
     * Resolve full image URL from path (http/https, assets/, or storage/).
     * Returns placeholder URL if path is null or empty.
     */
    public static function imageUrlForPath(?string $path): string
    {
        if (!$path || trim($path) === '') {
            return self::placeholderImageUrl();
        }
        $path = trim($path);
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
            return asset(ltrim($path, '/'));
        }
        return asset('storage/' . $path);
    }

    /**
     * Main product image URL (or placeholder).
     * Uses main image; if missing, uses first gallery image so uploads in gallery still show.
     */
    public function getDisplayImageUrlAttribute(): string
    {
        if ($this->image && trim((string) $this->image) !== '') {
            return self::imageUrlForPath($this->image);
        }
        $images = $this->images;
        if (is_array($images) && count($images) > 0 && !empty($images[0]) && is_string($images[0])) {
            return self::imageUrlForPath($images[0]);
        }
        return self::placeholderImageUrl();
    }

    /**
     * First image from images array (for hover/second thumb), or main image.
     */
    public function getHoverImageUrlAttribute(): string
    {
        $images = $this->images;
        if (is_array($images) && count($images) > 0 && !empty($images[0])) {
            return self::imageUrlForPath(is_string($images[0]) ? $images[0] : null);
        }
        return $this->display_image_url;
    }
}




