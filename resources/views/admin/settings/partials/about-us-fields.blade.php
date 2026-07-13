@php
    use App\Models\Setting;
    use App\Support\AboutPageContent;

    $settings = $settings ?? Setting::allAsArray();
    $homepageImageDefaults = $homepageImageDefaults ?? AboutPageContent::imageDefaults();
    $aboutDefaults = AboutPageContent::settingsDefaults();
    $aboutValue = function (string $key) use ($settings, $aboutDefaults) {
        return setting_form_value($key, $settings, $aboutDefaults[$key] ?? '');
    };
    $showHeader = $showHeader ?? true;
@endphp
@if($showHeader)
<hr class="my-4">
<h6 class="mb-2">About Us page</h6>
<p class="text-muted small mb-3">
    Edit all text and images for the <a href="{{ route('about-us') }}" target="_blank">About Us page</a>.
    The four benefit icons at the bottom are shared with the homepage under <strong>Homepage benefit icons</strong> below.
</p>
@endif

<h6 class="text-muted small text-uppercase mb-3">Hero banner</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">Background image</label>
        @include('admin.settings.partials.homepage-image-field', ['key' => 'about_us_banner_image', 'mobileKey' => 'about_us_banner_image_mobile', 'mobileRecommended' => '750×1000px', 'previewMaxHeight' => 120, 'homepageImageDefaults' => $homepageImageDefaults])
        <small class="form-text text-muted d-block mt-1">Desktop recommended: 1920×700px (wide). The banner shows the full image without cropping/zoom.</small>
        <small class="text-muted">Recommended: 1920×700px wide banner.</small>
    </div>
    <div class="col-md-6">
        <label class="form-label">Hero subtitle</label>
        <input type="text" name="about_us_hero_subtitle" class="form-control" value="{{ $aboutValue('about_us_hero_subtitle') }}">
    </div>
    <div class="col-md-6">
        @include('admin.partials.banner-text-color-select', [
            'name' => 'about_us_hero_text_color',
            'id' => 'about_us_hero_text_color',
            'label' => 'Hero text color',
            'value' => old('about_us_hero_text_color', $settings['about_us_hero_text_color'] ?? ''),
            'wrapperClass' => 'mb-0',
        ])
    </div>
    <div class="col-md-8">
        <label class="form-label">Hero heading</label>
        <input type="text" name="about_us_hero_heading" class="form-control" value="{{ $aboutValue('about_us_hero_heading') }}">
    </div>
    <div class="col-md-4">
        <label for="about_us_hero_text_align" class="form-label">Hero text alignment</label>
        @php $heroAlign = old('about_us_hero_text_align', $aboutValue('about_us_hero_text_align') ?: 'center'); @endphp
        <select class="form-select" id="about_us_hero_text_align" name="about_us_hero_text_align">
            <option value="left" @selected($heroAlign === 'left')>Left</option>
            <option value="center" @selected($heroAlign === 'center')>Center</option>
            <option value="right" @selected($heroAlign === 'right')>Right</option>
        </select>
    </div>
    <div class="col-12">
        <input type="hidden" name="about_us_hero_show_text" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="about_us_hero_show_text" id="about_us_hero_show_text" value="1"
                   {{ old('about_us_hero_show_text', setting_flag('about_us_hero_show_text', true)) ? 'checked' : '' }}>
            <label class="form-check-label" for="about_us_hero_show_text">Show banner text (subtitle &amp; heading)</label>
        </div>
        <small class="text-muted">Turn off to show the hero image only, with no overlay text.</small>
    </div>
</div>

<h6 class="text-muted small text-uppercase mb-3">About intro</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">Section heading</label>
        <input type="text" name="about_us_intro_heading" class="form-control" value="{{ $aboutValue('about_us_intro_heading') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Subheading</label>
        <input type="text" name="about_us_intro_subheading" class="form-control" value="{{ $aboutValue('about_us_intro_subheading') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Body text</label>
        <textarea name="about_us_intro_body" class="form-control" rows="5">{{ $aboutValue('about_us_intro_body') }}</textarea>
        <small class="text-muted">Separate paragraphs with a blank line.</small>
    </div>
</div>

<h6 class="text-muted small text-uppercase mb-3">Designed for modern living</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">Section image</label>
        @include('admin.settings.partials.homepage-image-field', ['key' => 'about_us_choose_image', 'mobileKey' => 'about_us_choose_image_mobile', 'mobileRecommended' => '750×1000px', 'previewMaxHeight' => 140, 'homepageImageDefaults' => $homepageImageDefaults])
        <small class="text-muted">Recommended: 900×1100px (4:5 portrait).</small>
    </div>
    <div class="col-md-6">
        <label class="form-label">Section heading</label>
        <input type="text" name="about_us_choose_heading" class="form-control mb-3" value="{{ $aboutValue('about_us_choose_heading') }}">
        <label class="form-label">Intro text</label>
        <textarea name="about_us_choose_body" class="form-control" rows="3">{{ $aboutValue('about_us_choose_body') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Feature list label</label>
        <input type="text" name="about_us_choose_feature_label" class="form-control" value="{{ $aboutValue('about_us_choose_feature_label') }}">
    </div>
    @for($fi = 1; $fi <= 3; $fi++)
        <div class="col-md-6">
            <label class="form-label">Feature {{ $fi }} title</label>
            <input type="text" name="about_us_feature_{{ $fi }}_title" class="form-control" value="{{ $aboutValue('about_us_feature_'.$fi.'_title') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Feature {{ $fi }} text</label>
            <input type="text" name="about_us_feature_{{ $fi }}_text" class="form-control" value="{{ $aboutValue('about_us_feature_'.$fi.'_text') }}">
        </div>
    @endfor
    <div class="col-12">
        <label class="form-label">Closing text</label>
        <textarea name="about_us_choose_footer" class="form-control" rows="2">{{ $aboutValue('about_us_choose_footer') }}</textarea>
    </div>
</div>

<h6 class="text-muted small text-uppercase mb-3">Quote section</h6>
<div class="row g-3 mb-4">
    <div class="col-12">
        <label class="form-label">Heading</label>
        <input type="text" name="about_us_quote_heading" class="form-control" value="{{ $aboutValue('about_us_quote_heading') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Body text</label>
        <textarea name="about_us_quote_body" class="form-control" rows="3">{{ $aboutValue('about_us_quote_body') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Subheading</label>
        <input type="text" name="about_us_quote_subheading" class="form-control" value="{{ $aboutValue('about_us_quote_subheading') }}">
    </div>
</div>

<h6 class="text-muted small text-uppercase mb-3">Growing with you</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">Section image</label>
        @include('admin.settings.partials.homepage-image-field', ['key' => 'about_us_growth_image', 'mobileKey' => 'about_us_growth_image_mobile', 'mobileRecommended' => '750×1000px', 'previewMaxHeight' => 140, 'homepageImageDefaults' => $homepageImageDefaults])
        <small class="text-muted">Recommended: 900×1100px (4:5 portrait).</small>
    </div>
    <div class="col-md-6">
        <label class="form-label">Section heading</label>
        <input type="text" name="about_us_growth_heading" class="form-control mb-3" value="{{ $aboutValue('about_us_growth_heading') }}">
        <label class="form-label">Body text</label>
        <textarea name="about_us_growth_body" class="form-control" rows="5">{{ $aboutValue('about_us_growth_body') }}</textarea>
        <small class="text-muted">Separate paragraphs with a blank line.</small>
    </div>
    <div class="col-12">
        <label class="form-label">Why choose list label</label>
        <input type="text" name="about_us_why_choose_label" class="form-control" value="{{ $aboutValue('about_us_why_choose_label') }}">
    </div>
    @for($wi = 1; $wi <= 5; $wi++)
        <div class="col-md-6">
            <label class="form-label">List item {{ $wi }}</label>
            <input type="text" name="about_us_why_{{ $wi }}" class="form-control" value="{{ $aboutValue('about_us_why_'.$wi) }}">
        </div>
    @endfor
</div>
