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
        'color_images',
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
        'color_images' => 'array',
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
        if (!$color) {
            return $this->image;
        }
        $colorImages = $this->color_images ?? [];
        $key = trim($color);
        if (isset($colorImages[$key]) && $colorImages[$key]) {
            return $colorImages[$key];
        }
        return $this->image;
    }
}




