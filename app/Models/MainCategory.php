<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'image_mobile',
        'hero_image',
        'hero_image_mobile',
        'hero_text',
        'hero_button_text',
        'hero_show_text',
        'hero_text_color',
        'hero_section_enabled',
        'whats_new_section_enabled',
        'subcategory_cards_section_enabled',
        'testimonial_section_enabled',
        'promo_section_enabled',
        'benefits_section_enabled',
        'instagram_section_enabled',
        'banner_images',
        'banner_images_mobile',
        'banner_texts',
        'bottom_banner_image',
        'bottom_banner_image_mobile',
        'bottom_banner_text',
        'bottom_banner_section_enabled',
        'bottom_banner_show_text',
        'bottom_banner_subtext',
        'bottom_banner_button_text',
        'bottom_banner_button_url',
        'bottom_banner_bg_image',
        'bottom_banner_bg_image_mobile',
        'bottom_banner_images',
        'bottom_banner_images_mobile',
        'bottom_banner_blocks_enabled',
        'bottom_banner_block_urls',
        'testimonial_text',
        'promo_banner_count',
        'promo_show_text',
        'promo_text_color',
        'subcategory_cards_show_text',
        'additional_banner_image',
        'additional_banner_text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'banner_images' => 'array',
        'banner_images_mobile' => 'array',
        'banner_texts' => 'array',
        'bottom_banner_images' => 'array',
        'bottom_banner_images_mobile' => 'array',
        'bottom_banner_block_urls' => 'array',
        'bottom_banner_section_enabled' => 'boolean',
        'bottom_banner_show_text' => 'boolean',
        'bottom_banner_blocks_enabled' => 'boolean',
        'promo_banner_count' => 'integer',
        'hero_show_text' => 'boolean',
        'hero_section_enabled' => 'boolean',
        'whats_new_section_enabled' => 'boolean',
        'subcategory_cards_section_enabled' => 'boolean',
        'testimonial_section_enabled' => 'boolean',
        'promo_section_enabled' => 'boolean',
        'benefits_section_enabled' => 'boolean',
        'instagram_section_enabled' => 'boolean',
        'promo_show_text' => 'boolean',
        'subcategory_cards_show_text' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get categories under this main category
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'main_category_id');
    }

    /**
     * Get active categories
     */
    public function activeCategories()
    {
        return $this->hasMany(Category::class, 'main_category_id')->where('is_active', true);
    }

    /**
     * Main categories shown on the storefront (header, footer, filters).
     */
    public function scopeVisible($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Primary category used for storefront navigation links.
     */
    public function navigationCategory(): ?Category
    {
        if ($this->relationLoaded('activeCategories')) {
            $categories = $this->activeCategories;

            return $categories->whereNull('parent_id')->sortBy('sort_order')->first()
                ?? $categories->sortBy('sort_order')->first();
        }

        return $this->activeCategories()->whereNull('parent_id')->orderBy('sort_order')->first()
            ?? $this->activeCategories()->orderBy('sort_order')->first();
    }

    /**
     * URL for header/footer/mobile nav.
     */
    public function storefrontUrl(): string
    {
        $category = $this->navigationCategory();

        return route('category', $category?->slug ?? $this->slug);
    }

    /**
     * Homepage category card image (custom upload or theme default by slug).
     */
    public function homepageImageUrl(): string
    {
        if ($this->image) {
            return storage_asset($this->image);
        }

        $defaults = [
            'drinkware' => 'assets/images/product/Bottle-1.webp',
            'barware' => 'assets/images/product/Bottle-4.webp',
            'kitchenware' => 'assets/images/product/Bottle-8.webp',
        ];

        return asset($defaults[$this->slug] ?? 'assets/images/product/Bottle-1.webp');
    }

    /**
     * Homepage category card image for mobile (falls back to desktop/default).
     */
    public function homepageMobileImageUrl(): string
    {
        if ($this->image_mobile) {
            return storage_asset($this->image_mobile);
        }

        return $this->homepageImageUrl();
    }
}




