@php
    $promoSlotCount = 6;
    $bannerImages = old('banner_images', isset($category) && is_array($category->banner_images ?? null) ? $category->banner_images : []);
    $bannerImagesMobile = old('banner_images_mobile', isset($category) && is_array($category->banner_images_mobile ?? null) ? $category->banner_images_mobile : []);
    $bannerTexts = old('banner_texts', isset($category) && is_array($category->banner_texts ?? null) ? $category->banner_texts : []);
    while (count($bannerImages) < $promoSlotCount) {
        $bannerImages[] = null;
    }
    while (count($bannerImagesMobile) < $promoSlotCount) {
        $bannerImagesMobile[] = null;
    }
    while (count($bannerTexts) < $promoSlotCount) {
        $bannerTexts[] = '';
    }
    $bannerImages = array_slice($bannerImages, 0, $promoSlotCount);
    $bannerImagesMobile = array_slice($bannerImagesMobile, 0, $promoSlotCount);
    $bannerTexts = array_slice($bannerTexts, 0, $promoSlotCount);
    $currentPromoCount = (int) old('promo_banner_count', isset($category) ? ($category->promo_banner_count ?? 3) : 3);
@endphp

<div class="mb-3" style="max-width: 220px;">
    <label for="promo_banner_count" class="form-label">Number of promo blocks on site</label>
    <select class="form-select" id="promo_banner_count" name="promo_banner_count">
        @for($n = 1; $n <= $promoSlotCount; $n++)
            <option value="{{ $n }}" {{ $currentPromoCount === $n ? 'selected' : '' }}>{{ $n }}</option>
        @endfor
    </select>
    <small class="text-muted">Upload images for each block below. Only the first {{ $currentPromoCount }} appear on the category page.</small>
</div>

<div id="promo-banner-slots">
    @for($i = 0; $i < $promoSlotCount; $i++)
        <div class="card mb-3 promo-banner-slot" data-promo-slot="{{ $i + 1 }}" @if($i + 1 > $currentPromoCount) style="display:none;" @endif>
            <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0">Banner {{ $i + 1 }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Banner Image {{ $i + 1 }}</label>
                    @if(!empty($bannerImages[$i]))
                        <div class="mb-2 position-relative d-inline-block">
                            <img src="{{ storage_asset($bannerImages[$i]) }}"
                                 alt="Promo block {{ $i + 1 }}"
                                 style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                            <input type="hidden" name="remove_banner_image[{{ $i }}]" value="0" id="removeBannerImageInput{{ $i }}">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveBannerImage({{ $i }})">
                                <i class="bi bi-trash me-1"></i>Remove
                            </button>
                        </div>
                    @else
                        <input type="hidden" name="remove_banner_image[{{ $i }}]" value="0" id="removeBannerImageInput{{ $i }}">
                    @endif
                    <input type="file"
                           class="form-control"
                           name="banner_images[{{ $i }}]"
                           accept="image/*"
                           onchange="previewBannerImage(this, {{ $i }})">
                    <small class="form-text text-muted">Recommended size: 600×750px (desktop). Max size: 2MB</small>
                    <div id="bannerImagePreview{{ $i }}" class="mt-2" style="display: none;">
                        <img id="bannerPreviewImg{{ $i }}" src="" alt="Preview" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                    </div>
                    @include('admin.partials.banner-mobile-upload', [
                        'name' => 'banner_images_mobile['.$i.']',
                        'inputId' => 'bannerImageMobile'.$i,
                        'removeName' => 'remove_banner_image_mobile['.$i.']',
                        'currentMobile' => $bannerImagesMobile[$i] ?? null,
                        'recommended' => '600×750px',
                    ])
                </div>
                <div class="mb-0">
                    <label class="form-label">Banner Text {{ $i + 1 }}</label>
                    <input type="text"
                           class="form-control"
                           name="banner_texts[{{ $i }}]"
                           value="{{ $bannerTexts[$i] ?? '' }}"
                           maxlength="120"
                           placeholder="e.g. Drinkware, Barware, Kitchenware">
                    <small class="form-text text-muted">Optional overlay text (max 120 characters). Banner size stays fixed — long text is clamped to 3 lines on the site.</small>
                </div>
            </div>
        </div>
    @endfor
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var countSelect = document.getElementById('promo_banner_count');
    if (!countSelect) return;
    function syncPromoSlots() {
        var count = parseInt(countSelect.value, 10) || 1;
        document.querySelectorAll('.promo-banner-slot').forEach(function (card) {
            var slot = parseInt(card.getAttribute('data-promo-slot'), 10);
            card.style.display = slot <= count ? '' : 'none';
        });
    }
    countSelect.addEventListener('change', syncPromoSlots);
});
</script>
@endpush
