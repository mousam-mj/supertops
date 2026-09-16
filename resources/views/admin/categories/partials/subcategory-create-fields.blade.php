<div class="card border-primary mb-4" id="subcategoryFields">
    <div class="card-header bg-primary bg-opacity-10">
        <h6 class="mb-0 text-primary fw-bold">Subcategory page settings</h6>
        <small class="text-muted">Card image appears on the parent Drinkware / Barware page. Banner appears when customers open this subcategory.</small>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-6">
                <label for="sub_image" class="form-label fw-semibold">Card image</label>
                <input type="file"
                       class="form-control @error('image') is-invalid @enderror"
                       id="sub_image"
                       name="image"
                       accept="image/*"
                       onchange="previewImage(this, 'subImagePreview', 'subPreviewImg')">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Recommended: 1500×1500px (1:1 square). Max 2MB.</small>
                <div id="subImagePreview" class="mt-2" style="display: none;">
                    <img id="subPreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-height: 220px; object-fit: cover;">
                </div>
                @include('admin.partials.banner-mobile-upload', [
                    'name' => 'image_mobile',
                    'inputId' => 'image_mobile',
                    'removeName' => null,
                    'currentMobile' => null,
                    'recommended' => '1500×1500px',
                ])
            </div>
            <div class="col-lg-6">
                <label for="sub_hero_image" class="form-label fw-semibold">Subcategory page top banner</label>
                <input type="file"
                       class="form-control @error('hero_image') is-invalid @enderror"
                       id="sub_hero_image"
                       name="hero_image"
                       accept="image/*"
                       onchange="previewImage(this, 'subHeroImagePreview', 'subHeroPreviewImg')">
                @error('hero_image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Recommended: 1920×600px. Max 5MB.</small>
                <div id="subHeroImagePreview" class="mt-2" style="display: none;">
                    <img id="subHeroPreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-height: 220px; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-6">
                <label for="sub_hero_button_text" class="form-label">Card / shop button text</label>
                <input type="text"
                       class="form-control"
                       id="sub_hero_button_text"
                       name="hero_button_text"
                       value="{{ old('hero_button_text', 'Shop Now') }}">
            </div>
            <div class="col-md-6">
                <label for="sub_hero_button_url" class="form-label">Custom link (optional)</label>
                <input type="text"
                       class="form-control"
                       id="sub_hero_button_url"
                       name="hero_button_url"
                       value="{{ old('hero_button_url') }}"
                       placeholder="/shop?category=double-wall-bottles">
                <small class="form-text text-muted">Leave blank to auto-link to the filtered shop for this subcategory.</small>
            </div>
            <div class="col-12">
                <input type="hidden" name="show_on_parent_page" value="0">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="show_on_parent_page" name="show_on_parent_page" value="1" {{ old('show_on_parent_page', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_on_parent_page">Show card on parent category page (Drinkware / Barware grid)</label>
                </div>
            </div>
        </div>
    </div>
</div>
