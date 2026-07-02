@extends('admin.layout')

@section('title', 'Edit Main Category')
@section('page-title', 'Edit Main Category')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Main Category Information</h5>
            </div>
            <div class="card-body">
                <form action="{{{ route('admin.main-categories.update', $category) }}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $category->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" 
                                    id="is_active" 
                                    name="is_active">
                                <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Category Image</label>
                        <small class="text-muted d-block mb-2">Shown on the homepage category cards (Drinkware, Barware, etc.).</small>
                        @php
                            $hasImage = !empty($category->image);
                            $imageExists = false;
                            if ($hasImage) {
                                try {
                                    $imageExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($category->image);
                                } catch (\Exception $e) {
                                    $imageExists = false;
                                }
                            }
                        @endphp
                        
                        @if($hasImage && $imageExists)
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label text-muted small mb-0 fw-semibold">Current Image:</label>
                                    <span class="badge bg-success">Image Set</span>
                                </div>
                                <div class="position-relative d-inline-block">
                                    <img src="{{ storage_asset($category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         id="currentCategoryImage"
                                         class="img-thumbnail border"
                                         style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover; display: block; border: 2px solid #dee2e6 !important;">
                                    <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeImageBtn" onclick="toggleRemoveImage('image')">
                                            <i class="bi bi-trash me-1"></i>Remove Image
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-file-image me-1"></i>File: {{ basename($category->image) }}
                                </small>
                            </div>
                        @elseif($hasImage && !$imageExists)
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>Image path exists in database but file not found: <code>{{ $category->image }}</code>
                            </div>
                        @else
                            <div class="alert alert-info mb-3">
                                <i class="bi bi-info-circle me-2"></i>No image currently set for this category. Upload an image below.
                            </div>
                        @endif
                        
                        <div class="mb-2">
                            <label class="form-label text-muted small fw-semibold">{{ $hasImage && $imageExists ? 'Upload New Image (will replace current):' : 'Upload Image:' }}</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this, 'imagePreview', 'previewImg')">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted d-block mb-2">
                            <i class="bi bi-info-circle me-1"></i>Recommended size: 750×1000px (3:4 portrait). Max size: 2MB. 
                            @if($hasImage && $imageExists)
                                Leave empty to keep current image.
                            @endif
                        </small>
                        <div id="imagePreview" class="mt-2 p-2 border rounded bg-light" style="display: none;">
                            <label class="form-label text-muted small mb-2 fw-semibold">Preview:</label>
                            <img id="previewImg" src="" alt="Preview" class="img-thumbnail border" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover; display: block; border: 2px solid #dee2e6 !important;">
                        </div>
                        @include('admin.partials.banner-mobile-upload', [
                            'name' => 'image_mobile',
                            'inputId' => 'image_mobile',
                            'removeName' => 'remove_image_mobile',
                            'currentMobile' => $category->image_mobile ?? null,
                            'recommended' => '750×1000px',
                        ])
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 fw-bold">Category Page UI/Content Settings</h5>
                    <p class="text-muted mb-4">Configure the content and images displayed on the category page.</p>

                    @include('admin.main-categories.partials.section-toggles', ['category' => $category])

                    <hr class="my-4">
                    <h5 class="mb-3">Hero Section</h5>

                    <div class="mb-3">
                        <input type="hidden" name="hero_show_text" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="hero_show_text" id="hero_show_text" value="1" {{ old('hero_show_text', $category->hero_show_text ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hero_show_text">Show Shop button on category hero banner</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="hero_image" class="form-label">Hero Image</label>
                        @if($category->hero_image)
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="{{ storage_asset($category->hero_image) }}" 
                                     alt="Hero" 
                                     id="currentHeroImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_hero_image" value="0" id="removeHeroImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('hero_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('hero_image') is-invalid @enderror" 
                               id="hero_image" 
                               name="hero_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'heroImagePreview', 'heroPreviewImg')">
                        @error('hero_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Main banner image for category page. Recommended size: 1920×600px. Max size: 5MB. Banner height stays fixed when text is added.</small>
                        <div id="heroImagePreview" class="mt-2" style="display: none;">
                            <img id="heroPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                        @include('admin.partials.banner-mobile-upload', [
                            'name' => 'hero_image_mobile',
                            'inputId' => 'hero_image_mobile',
                            'removeName' => 'remove_hero_image_mobile',
                            'currentMobile' => $category->hero_image_mobile ?? null,
                            'recommended' => '750×1000px',
                        ])
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="hero_text" class="form-label">Hero Text</label>
                            <input type="text" 
                                   class="form-control @error('hero_text') is-invalid @enderror" 
                                   id="hero_text" 
                                   name="hero_text" 
                                   value="{{ old('hero_text', $category->hero_text) }}"
                                   placeholder="e.g. Loved For A Lifetime, FOR EVERY SHADE IN YOU">
                            @error('hero_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Main heading text displayed on hero banner</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hero_button_text" class="form-label">Button Text</label>
                            <input type="text" 
                                   class="form-control @error('hero_button_text') is-invalid @enderror" 
                                   id="hero_button_text" 
                                   name="hero_button_text" 
                                   value="{{ old('hero_button_text', $category->hero_button_text ?? 'Shop Now') }}">
                            @error('hero_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Text for hero button (default: Shop Now)</small>
                        </div>
                    </div>

                    @include('admin.partials.banner-text-color-select', [
                        'name' => 'hero_text_color',
                        'id' => 'hero_text_color',
                        'label' => 'Hero banner text color',
                        'value' => old('hero_text_color', $category->hero_text_color),
                    ])

                    <hr class="my-4">
                    <h5 class="mb-3">Promotional Banners (small blocks)</h5>
                    <p class="text-muted small mb-3">Shown on Drinkware / Barware pages after Testimonial. Set count (e.g. 2 for Drinkware, 6 for Barware).</p>
                    <div class="mb-3">
                        <input type="hidden" name="promo_show_text" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="promo_show_text" id="promo_show_text" value="1" {{ old('promo_show_text', $category->promo_show_text ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="promo_show_text">Show Shop Now text on promo blocks</label>
                        </div>
                    </div>

                    @include('admin.partials.banner-text-color-select', [
                        'name' => 'promo_text_color',
                        'id' => 'promo_text_color',
                        'label' => 'Promo block text color',
                        'value' => old('promo_text_color', $category->promo_text_color),
                    ])

                    @include('admin.main-categories.partials.promo-banner-fields', ['category' => $category])

                    <hr class="my-4">
                    <h5 class="mb-3">Subcategory cards</h5>
                    <div class="mb-4">
                        <input type="hidden" name="subcategory_cards_show_text" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="subcategory_cards_show_text" id="subcategory_cards_show_text" value="1" {{ old('subcategory_cards_show_text', $category->subcategory_cards_show_text ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subcategory_cards_show_text">Show Shop button on subcategory grid cards</label>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Bottom Banner Section (sale banner)</h5>
                    <p class="text-muted small mb-3">Wide split banner on Drinkware / Barware pages — text on the left, product image on the right (above the 4 image blocks). Enable/disable under <strong>Category page sections</strong> above.</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="hidden" name="bottom_banner_show_text" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="bottom_banner_show_text" id="bottom_banner_show_text" value="1" {{ old('bottom_banner_show_text', $category->bottom_banner_show_text ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="bottom_banner_show_text">Show text on banner</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="bottom_banner_subtext" class="form-label">Subheading</label>
                            <input type="text" class="form-control" id="bottom_banner_subtext" name="bottom_banner_subtext" value="{{ old('bottom_banner_subtext', $category->bottom_banner_subtext) }}" placeholder="e.g. Sale! Up To 50% Off!">
                        </div>
                        <div class="col-md-6">
                            <label for="bottom_banner_text" class="form-label">Main heading</label>
                            <input type="text" class="form-control @error('bottom_banner_text') is-invalid @enderror" id="bottom_banner_text" name="bottom_banner_text" value="{{ old('bottom_banner_text', $category->bottom_banner_text) }}" placeholder="e.g. Perch Bottle on sale">
                            @error('bottom_banner_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="bottom_banner_button_text" class="form-label">Button text</label>
                            <input type="text" class="form-control" id="bottom_banner_button_text" name="bottom_banner_button_text" value="{{ old('bottom_banner_button_text', $category->bottom_banner_button_text ?? 'Shop Now') }}">
                        </div>
                        <div class="col-md-8">
                            <label for="bottom_banner_button_url" class="form-label">Button link (product URL or path)</label>
                            <input type="text" class="form-control" id="bottom_banner_button_url" name="bottom_banner_button_url" value="{{ old('bottom_banner_button_url', $category->bottom_banner_button_url) }}" placeholder="/product/your-product-slug or full URL">
                        </div>
                        <div class="col-md-6">
                            <label for="bottom_banner_bg_image" class="form-label">Background image (left side)</label>
                            @if($category->bottom_banner_bg_image)
                                <div class="mb-2">
                                    <img src="{{ storage_asset($category->bottom_banner_bg_image) }}" alt="" class="img-thumbnail" style="max-height: 120px; object-fit: cover;">
                                    <input type="hidden" name="remove_bottom_banner_bg_image" value="0" id="removeBottomBannerBgInput">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('bottom_banner_bg_image')">Remove</button>
                                </div>
                            @else
                                <input type="hidden" name="remove_bottom_banner_bg_image" value="0" id="removeBottomBannerBgInput">
                            @endif
                            <input type="file" class="form-control" id="bottom_banner_bg_image" name="bottom_banner_bg_image" accept="image/*">
                            <small class="text-muted">Recommended: 1920×700px. Default theme background used if empty.</small>
                            @include('admin.partials.banner-mobile-upload', [
                                'name' => 'bottom_banner_bg_image_mobile',
                                'inputId' => 'bottom_banner_bg_image_mobile',
                                'removeName' => 'remove_bottom_banner_bg_image_mobile',
                                'currentMobile' => $category->bottom_banner_bg_image_mobile ?? null,
                                'recommended' => '750×1000px',
                            ])
                        </div>
                        <div class="col-md-6">
                            <label for="bottom_banner_image" class="form-label">Product image (right side)</label>
                            @if($category->bottom_banner_image)
                                <div class="mb-2 position-relative d-inline-block">
                                    <img src="{{ storage_asset($category->bottom_banner_image) }}" alt="Bottom Banner" id="currentBottomBannerImage" style="max-width: 100%; max-height: 140px; object-fit: cover;" class="img-thumbnail">
                                    <input type="hidden" name="remove_bottom_banner_image" value="0" id="removeBottomBannerImageInput">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('bottom_banner_image')"><i class="bi bi-trash me-1"></i>Remove</button>
                                </div>
                            @else
                                <input type="hidden" name="remove_bottom_banner_image" value="0" id="removeBottomBannerImageInput">
                            @endif
                            <input type="file" class="form-control @error('bottom_banner_image') is-invalid @enderror" id="bottom_banner_image" name="bottom_banner_image" accept="image/*" onchange="previewImage(this, 'bottomBannerImagePreview', 'bottomBannerPreviewImg')">
                            @error('bottom_banner_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Recommended: 900×700px. Default product image used if empty.</small>
                            <div id="bottomBannerImagePreview" class="mt-2" style="display: none;">
                                <img id="bottomBannerPreviewImg" src="" alt="Preview" style="max-height: 140px; object-fit: cover;" class="img-thumbnail">
                            </div>
                            @include('admin.partials.banner-mobile-upload', [
                                'name' => 'bottom_banner_image_mobile',
                                'inputId' => 'bottom_banner_image_mobile',
                                'removeName' => 'remove_bottom_banner_image_mobile',
                                'currentMobile' => $category->bottom_banner_image_mobile ?? null,
                                'recommended' => '750×1000px',
                            ])
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Bottom 4 Image Blocks</h5>
                    <p class="text-muted small mb-3">Four-card row below the sale banner on Drinkware / Barware pages. Recommended: 600×750px each. Enable/disable the row under <strong>Category page sections</strong> above.</p>

                    @php
                        $bottomBannerImages = old('bottom_banner_images', is_array($category->bottom_banner_images ?? null) ? $category->bottom_banner_images : []);
                        $bottomBannerImagesMobile = old('bottom_banner_images_mobile', is_array($category->bottom_banner_images_mobile ?? null) ? $category->bottom_banner_images_mobile : []);
                        while (count($bottomBannerImages) < 4) { $bottomBannerImages[] = null; }
                        while (count($bottomBannerImagesMobile) < 4) { $bottomBannerImagesMobile[] = null; }
                        $bottomBannerBlockUrls = old('bottom_banner_block_urls', is_array($category->bottom_banner_block_urls ?? null) ? $category->bottom_banner_block_urls : []);
                        while (count($bottomBannerBlockUrls) < 4) { $bottomBannerBlockUrls[] = ''; }
                    @endphp
                    @for($bi = 0; $bi < 4; $bi++)
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2"><h6 class="mb-0">Image block {{ $bi + 1 }}</h6></div>
                        <div class="card-body">
                            @if(!empty($bottomBannerImages[$bi]))
                                <div class="mb-2">
                                    <img src="{{ storage_asset($bottomBannerImages[$bi]) }}" alt="" class="img-thumbnail" style="max-height: 140px; object-fit: cover;">
                                    <input type="hidden" name="remove_bottom_banner_images[{{ $bi }}]" value="0">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="this.previousElementSibling.value='1'">Remove image</button>
                                </div>
                            @else
                                <input type="hidden" name="remove_bottom_banner_images[{{ $bi }}]" value="0">
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Upload image</label>
                                <input type="file" class="form-control" name="bottom_banner_images[]" accept="image/*">
                                @include('admin.partials.banner-mobile-upload', [
                                    'name' => 'bottom_banner_images_mobile['.$bi.']',
                                    'inputId' => 'bottomBannerImageMobile'.$bi,
                                    'removeName' => 'remove_bottom_banner_images_mobile['.$bi.']',
                                    'currentMobile' => $bottomBannerImagesMobile[$bi] ?? null,
                                    'recommended' => '600×750px',
                                ])
                            </div>
                            <div>
                                <label class="form-label">Link URL (product or page)</label>
                                <input type="text" class="form-control" name="bottom_banner_block_urls[]" value="{{ $bottomBannerBlockUrls[$bi] ?? '' }}" placeholder="/product/slug or /shop">
                            </div>
                        </div>
                    </div>
                    @endfor

                    <hr class="my-4">
                    <h5 class="mb-3">Testimonial Section</h5>

                    <div class="mb-3">
                        <label for="testimonial_text" class="form-label">Testimonial/Quote Text</label>
                        <textarea class="form-control @error('testimonial_text') is-invalid @enderror" 
                                  id="testimonial_text" 
                                  name="testimonial_text" 
                                  rows="3"
                                  placeholder="e.g. I absolutely love this shop! The products are high-quality...">{{ old('testimonial_text', $category->testimonial_text) }}</textarea>
                        @error('testimonial_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Customer testimonial or quote text displayed on category page</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-muted">Additional Banner (Optional) <span class="badge bg-secondary ms-1">Not used on site</span></h5>

                    <div class="mb-3">
                        <label for="additional_banner_image" class="form-label">Additional Banner Image</label>
                        @if($category->additional_banner_image)
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="{{ storage_asset($category->additional_banner_image) }}" 
                                     alt="Additional Banner" 
                                     id="currentAdditionalBannerImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_additional_banner_image" value="0" id="removeAdditionalBannerImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('additional_banner_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('additional_banner_image') is-invalid @enderror" 
                               id="additional_banner_image" 
                               name="additional_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'additionalBannerImagePreview', 'additionalBannerPreviewImg')">
                        @error('additional_banner_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Optional additional banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="additionalBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="additionalBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additional_banner_text" class="form-label">Additional Banner Text</label>
                        <input type="text" 
                               class="form-control @error('additional_banner_text') is-invalid @enderror" 
                               id="additional_banner_text" 
                               name="additional_banner_text" 
                               value="{{ old('additional_banner_text', $category->additional_banner_text) }}"
                               placeholder="e.g. Palettes, Check & Coutour">
                        @error('additional_banner_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Text displayed on additional banner</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{{ route('admin.main-categories.index') }}}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-warning" onclick="resetForm()">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Main Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Store original form values for reset functionality
    @php
        $originalBannerTexts = old('banner_texts', is_array($category->banner_texts) ? $category->banner_texts : []);
        while(count($originalBannerTexts) < 3) {
            $originalBannerTexts[] = '';
        }
    @endphp
    const originalFormValues = {
        name: @json(old('name', $category->name)),
        slug: @json(old('slug', $category->slug)),
        sort_order: @json(old('sort_order', $category->sort_order ?? 0)),
        is_active: @json(old('is_active', $category->is_active ? 1 : 0)),
        hero_text: @json(old('hero_text', $category->hero_text ?? '')),
        hero_button_text: @json(old('hero_button_text', $category->hero_button_text ?? 'Shop Now')),
        bottom_banner_text: @json(old('bottom_banner_text', $category->bottom_banner_text ?? '')),
        testimonial_text: @json(old('testimonial_text', $category->testimonial_text ?? '')),
        additional_banner_text: @json(old('additional_banner_text', $category->additional_banner_text ?? '')),
        banner_texts: @json($originalBannerTexts)
    };

    function previewImage(input, previewId, imgId) {
        const preview = document.getElementById(previewId);
        const previewImg = document.getElementById(imgId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    function previewBannerImage(input, index) {
        previewImage(input, 'bannerImagePreview' + index, 'bannerPreviewImg' + index);
    }

    function toggleRemoveImage(type) {
        let removeInput, removeBtn, currentImg;
        
        if (type === 'image') {
            removeInput = document.getElementById('removeImageInput');
            removeBtn = document.getElementById('removeImageBtn');
            currentImg = document.getElementById('currentCategoryImage');
        } else if (type === 'hero_image') {
            removeInput = document.getElementById('removeHeroImageInput');
            removeBtn = document.querySelector('[onclick*="hero_image"]');
            currentImg = document.getElementById('currentHeroImage');
        } else if (type === 'bottom_banner_image') {
            removeInput = document.getElementById('removeBottomBannerImageInput');
            removeBtn = document.querySelector('[onclick*="bottom_banner_image"]');
            currentImg = document.getElementById('currentBottomBannerImage');
        } else if (type === 'bottom_banner_bg_image') {
            removeInput = document.getElementById('removeBottomBannerBgInput');
            removeBtn = document.querySelector('[onclick*="bottom_banner_bg_image"]');
            currentImg = document.querySelector('[id="bottom_banner_bg_image"]')?.closest('.col-md-6')?.querySelector('img.img-thumbnail');
        } else if (type === 'additional_banner_image') {
            removeInput = document.getElementById('removeAdditionalBannerImageInput');
            removeBtn = document.querySelector('[onclick*="additional_banner_image"]');
            currentImg = document.getElementById('currentAdditionalBannerImage');
        }
        
        if (removeInput && removeInput.value == '0') {
            removeInput.value = '1';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
                removeBtn.classList.remove('btn-outline-danger');
                removeBtn.classList.add('btn-danger');
            }
            if (currentImg) {
                currentImg.style.opacity = '0.5';
            }
        } else if (removeInput) {
            removeInput.value = '0';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                removeBtn.classList.remove('btn-danger');
                removeBtn.classList.add('btn-outline-danger');
            }
            if (currentImg) {
                currentImg.style.opacity = '1';
            }
        }
    }

    function toggleRemoveBannerImage(index) {
        const removeInput = document.getElementById('removeBannerImageInput' + index);
        const removeBtn = document.querySelector('[onclick*="toggleRemoveBannerImage(' + index + ')"]');
        
        if (removeInput && removeInput.value == '0') {
            removeInput.value = '1';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo';
                removeBtn.classList.remove('btn-outline-danger');
                removeBtn.classList.add('btn-danger');
            }
        } else if (removeInput) {
            removeInput.value = '0';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                removeBtn.classList.remove('btn-danger');
                removeBtn.classList.add('btn-outline-danger');
            }
        }
    }

    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
            // Reset all text inputs to original values
            const nameField = document.getElementById('name');
            if (nameField) nameField.value = originalFormValues.name;
            
            const slugField = document.getElementById('slug');
            if (slugField) slugField.value = originalFormValues.slug;
            
            const sortOrderField = document.getElementById('sort_order');
            if (sortOrderField) sortOrderField.value = originalFormValues.sort_order;
            
            const isActiveField = document.getElementById('is_active');
            if (isActiveField) isActiveField.value = originalFormValues.is_active;
            
            // Reset UI content fields
            const heroText = document.getElementById('hero_text');
            if (heroText) heroText.value = originalFormValues.hero_text || '';
            
            const heroButtonText = document.getElementById('hero_button_text');
            if (heroButtonText) heroButtonText.value = originalFormValues.hero_button_text || 'Shop Now';
            
            const bottomBannerText = document.getElementById('bottom_banner_text');
            if (bottomBannerText) bottomBannerText.value = originalFormValues.bottom_banner_text || '';
            
            const testimonialText = document.getElementById('testimonial_text');
            if (testimonialText) testimonialText.value = originalFormValues.testimonial_text || '';
            
            const additionalBannerText = document.getElementById('additional_banner_text');
            if (additionalBannerText) additionalBannerText.value = originalFormValues.additional_banner_text || '';
            
            // Reset banner texts
            const bannerTextInputs = document.querySelectorAll('input[name="banner_texts[]"]');
            bannerTextInputs.forEach((input, index) => {
                if (input && originalFormValues.banner_texts && originalFormValues.banner_texts[index] !== undefined) {
                    input.value = originalFormValues.banner_texts[index] || '';
                } else {
                    input.value = '';
                }
            });
            
            // Reset all remove image inputs
            const removeInputs = document.querySelectorAll('input[type="hidden"][name^="remove"]');
            removeInputs.forEach(input => {
                if (input) {
                    input.value = '0';
                }
            });
            
            // Reset all remove buttons to original state
            const removeButtons = document.querySelectorAll('button[onclick*="toggleRemoveImage"], button[onclick*="toggleRemoveBannerImage"]');
            removeButtons.forEach(btn => {
                if (btn) {
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-outline-danger');
                    const icon = btn.querySelector('i');
                    if (icon && icon.classList.contains('bi-arrow-counterclockwise')) {
                        btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                    }
                }
            });
            
            // Hide all image previews
            const previews = document.querySelectorAll('[id$="Preview"]');
            previews.forEach(preview => {
                if (preview) {
                    preview.style.display = 'none';
                }
            });
            
            // Show and restore all current images to original state
            const currentImageIds = ['currentCategoryImage', 'currentHeroImage', 'currentBottomBannerImage', 'currentAdditionalBannerImage'];
            currentImageIds.forEach(id => {
                const img = document.getElementById(id);
                if (img) {
                    img.style.display = 'block';
                    img.style.opacity = '1';
                    img.style.visibility = 'visible';
                }
            });
            
            // Reset banner image remove buttons
            for (let i = 0; i < 3; i++) {
                const removeInput = document.getElementById('removeBannerImageInput' + i);
                if (removeInput) {
                    removeInput.value = '0';
                }
                const removeBtn = document.querySelector('[onclick*="toggleRemoveBannerImage(' + i + ')"]');
                if (removeBtn) {
                    removeBtn.classList.remove('btn-danger');
                    removeBtn.classList.add('btn-outline-danger');
                    removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                }
            }
            
            // Reset file inputs
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                if (input) {
                    input.value = '';
                }
            });
            
            // Reload page to ensure everything is reset to original state from server
            window.location.reload();
        }
    }
</script>
@endpush
@endsection


