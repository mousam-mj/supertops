<div class="card border-primary mb-4">
    <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h6 class="mb-0 text-primary fw-bold">Subcategory banners</h6>
            <small class="text-muted">Controls images on the parent category page cards and this subcategory page top banner.</small>
        </div>
        @if(!empty($category->slug))
            <a href="{{ route('category', $category->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i> View on site
            </a>
        @endif
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-6">
                <label for="image" class="form-label fw-semibold">Card image</label>
                <small class="text-muted d-block mb-2">Shown on Drinkware / Barware page in the subcategory grid (e.g. Double wall Bottles).</small>
                @if($category->image)
                    <div class="mb-2 position-relative d-inline-block">
                        <img src="{{ storage_asset($category->image) }}"
                             alt="{{ $category->name }}"
                             id="currentCategoryImage"
                             class="img-thumbnail"
                             style="max-width: 100%; max-height: 220px; object-fit: cover;">
                        <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" id="removeImageBtn" onclick="toggleRemoveImage('image')">
                                <i class="bi bi-trash me-1"></i> Remove card image
                            </button>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                    <p class="small text-muted mb-2">No card image uploaded — default bottle image is used.</p>
                @endif
                <input type="file"
                       class="form-control @error('image') is-invalid @enderror"
                       id="image"
                       name="image"
                       accept="image/*"
                       onchange="previewImage(this, 'imagePreview', 'previewImg')">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Recommended: 800×1000px (portrait). Max 2MB.</small>
                <div id="imagePreview" class="mt-2" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-height: 220px; object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6">
                <label for="hero_image" class="form-label fw-semibold">Subcategory page top banner</label>
                <small class="text-muted d-block mb-2">Large banner at the top when customers open this subcategory page.</small>
                @if($category->hero_image)
                    <div class="mb-2 position-relative d-inline-block">
                        <img src="{{ storage_asset($category->hero_image) }}"
                             alt="Page banner"
                             id="currentHeroImage"
                             class="img-thumbnail"
                             style="max-width: 100%; max-height: 220px; object-fit: cover;">
                        <input type="hidden" name="remove_hero_image" value="0" id="removeHeroImageInput">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="toggleRemoveImage('hero_image')">
                                <i class="bi bi-trash me-1"></i> Remove page banner
                            </button>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="remove_hero_image" value="0" id="removeHeroImageInput">
                    <p class="small text-muted mb-2">No banner uploaded — default theme banner is used.</p>
                @endif
                <input type="file"
                       class="form-control @error('hero_image') is-invalid @enderror"
                       id="hero_image"
                       name="hero_image"
                       accept="image/*"
                       onchange="previewImage(this, 'heroImagePreview', 'heroPreviewImg')">
                @error('hero_image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Recommended: 1920×600px. Max 5MB.</small>
                <div id="heroImagePreview" class="mt-2" style="display: none;">
                    <img id="heroPreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-height: 220px; object-fit: cover;">
                </div>
            </div>
            <div class="col-12">
                <label for="hero_button_text" class="form-label">Shop button text</label>
                <input type="text"
                       class="form-control @error('hero_button_text') is-invalid @enderror"
                       id="hero_button_text"
                       name="hero_button_text"
                       value="{{ old('hero_button_text', $category->hero_button_text ?? 'Shop Now') }}"
                       style="max-width: 280px;">
                @error('hero_button_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
