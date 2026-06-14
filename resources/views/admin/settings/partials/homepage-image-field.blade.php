@php
    $storedPath = trim((string) ($settings[$key] ?? ''));
    $defaultPath = $homepageImageDefaults[$key] ?? '';
    $previewUrl = setting_image_url($storedPath, $defaultPath);
    $isCustom = $storedPath !== '';
@endphp
<div class="setting-image-field" data-setting-image-field>
    <div class="mb-2 d-flex align-items-start gap-3 flex-wrap">
        <img
            src="{{ $previewUrl }}"
            alt=""
            class="img-thumbnail setting-image-preview"
            style="max-height: {{ $previewMaxHeight ?? 120 }}px; max-width: 100%; object-fit: contain;"
        >
        <div class="small">
            @if($isCustom)
                <span class="badge bg-primary mb-1">Custom upload</span>
            @else
                <span class="badge bg-secondary mb-1">Theme default</span>
            @endif
            <div class="text-muted">Default: {{ $defaultPath }}</div>
        </div>
    </div>
    <input type="hidden" name="reset_{{ $key }}" value="0" class="setting-image-reset-flag">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <input type="file" name="{{ $key }}" class="form-control setting-image-file" accept="image/jpeg,image/png,image/webp,image/gif" style="max-width: 320px;">
        @if($isCustom)
            <button
                type="button"
                class="btn btn-outline-danger btn-sm setting-image-reset-btn"
                data-reset-key="{{ $key }}"
                data-default-url="{{ asset($defaultPath) }}"
            >
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset to default
            </button>
        @endif
    </div>
</div>
