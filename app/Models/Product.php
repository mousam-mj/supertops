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
        'parent_product_id',
        'variant_color_label',
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
        'color_swatch_images',
        'color_variant_names',
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
        'color_swatch_images' => 'array',
        'color_variant_names' => 'array',
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
                $product->sku = 'PROD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

    public function childVariants()
    {
        return $this->hasMany(Product::class, 'parent_product_id')->orderBy('sort_order')->orderBy('name');
    }

    public function variantGroupRoot(): self
    {
        if ($this->parent_product_id && $this->relationLoaded('parentProduct') && $this->parentProduct) {
            return $this->parentProduct->variantGroupRoot();
        }

        if ($this->parent_product_id && ! $this->relationLoaded('parentProduct')) {
            $parent = static::find($this->parent_product_id);

            return $parent ? $parent->variantGroupRoot() : $this;
        }

        return $this;
    }

    /**
     * Main product plus all linked variant products in this color group.
     */
    public function variantGroupMembers()
    {
        $root = $this->variantGroupRoot();
        $root->loadMissing(['childVariants.inventories']);

        return collect([$root])->merge($root->childVariants)->unique('id')->values();
    }

    public function getDisplayColorLabel(): string
    {
        $label = trim((string) ($this->variant_color_label ?? ''));
        if ($label !== '') {
            return $label;
        }

        $inventoryColor = $this->inventories->pluck('color')->filter()->map(fn ($c) => trim((string) $c))->first();
        if ($inventoryColor) {
            return $inventoryColor;
        }

        if (str_contains($this->name, ',')) {
            return trim(substr($this->name, strrpos($this->name, ',') + 1));
        }

        return $this->name;
    }

    public function getSwatchUrlForDisplayColor(): ?string
    {
        $label = $this->getDisplayColorLabel();
        $swatch = $this->getSwatchImageForColor($label);
        if ($swatch) {
            return $swatch;
        }

        $inventory = $this->inventories->first(fn ($inv) => trim((string) ($inv->color ?? '')) === $label);

        return $inventory?->image;
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
     * Get stock for specific color and size.
     * Falls back to product-level stock when no inventory row exists for that combo
     * (common for linked color variants that track stock only on the product).
     */
    public function getStockForColorSize($color = null, $size = null)
    {
        $color = is_string($color) ? trim($color) : $color;
        $size = is_string($size) ? trim($size) : $size;
        if ($color === '') {
            $color = null;
        }
        if ($size === '') {
            $size = null;
        }

        $query = $this->inventories();

        if ($color) {
            $query->where('color', $color);
        }

        if ($size) {
            $query->where('size', $size);
        }

        $hasMatchingRows = (clone $query)->exists();
        $qty = (int) $query->sum('quantity');

        if ($hasMatchingRows) {
            return $qty;
        }

        // No inventory rows for this color/size — use product stock
        return (int) ($this->stock_quantity ?? 0);
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

    /**
     * Small swatch image for the color picker (supports dual-tone uploads).
     */
    public function getSwatchImageForColor($color): ?string
    {
        if (! $color) {
            return null;
        }

        $swatches = $this->color_swatch_images ?? [];
        $key = trim((string) $color);

        return ! empty($swatches[$key]) ? $swatches[$key] : null;
    }
}




