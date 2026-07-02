@php
    $sectionToggles = [
        'hero_section_enabled' => 'Top hero banner',
        'whats_new_section_enabled' => "What's New products",
        'subcategory_cards_section_enabled' => 'Subcategory grid cards',
        'testimonial_section_enabled' => 'Testimonial quote',
        'promo_section_enabled' => 'Promotional blocks',
        'bottom_banner_section_enabled' => 'Bottom sale banner',
        'bottom_banner_blocks_enabled' => 'Bottom 4 image blocks',
        'benefits_section_enabled' => 'Company perks (4 icons)',
        'instagram_section_enabled' => 'Instagram slider',
    ];
    $categoryModel = $category ?? null;
@endphp
<hr class="my-4">
<h5 class="mb-3">Category page sections — show / hide</h5>
<p class="text-muted small mb-3">Turn sections on or off for Drinkware / Barware pages (and their subcategories) without removing content.</p>
<div class="row g-2 mb-4">
    @foreach($sectionToggles as $toggleKey => $toggleLabel)
        <div class="col-md-6">
            <input type="hidden" name="{{ $toggleKey }}" value="0">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="{{ $toggleKey }}" id="{{ $toggleKey }}" value="1" {{ old($toggleKey, $categoryModel?->{$toggleKey} ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $toggleKey }}">{{ $toggleLabel }}</label>
            </div>
        </div>
    @endforeach
</div>
