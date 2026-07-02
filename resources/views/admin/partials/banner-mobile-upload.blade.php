@php
    $inputId = $inputId ?? ($name.'_mobile');
    $removeName = $removeName ?? ('remove_'.$name);
    $currentMobile = $currentMobile ?? null;
    $recommended = $recommended ?? '750×1000px';
@endphp
<div class="mt-2 pt-2 border-top">
    <label for="{{ $inputId }}" class="form-label small fw-semibold mb-1">Mobile image <span class="text-muted fw-normal">(optional)</span></label>
    @if($currentMobile)
        <div class="mb-2">
            <img src="{{ storage_asset($currentMobile) }}" alt="Mobile preview" class="img-thumbnail" style="max-height: 100px; object-fit: cover;">
            <input type="hidden" name="{{ $removeName }}" value="0" id="{{ $removeName }}Input">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 d-block" onclick="document.getElementById('{{ $removeName }}Input').value='1'; this.closest('.mt-2').querySelector('img')?.remove(); this.remove();">
                <i class="bi bi-trash me-1"></i>Remove mobile image
            </button>
        </div>
    @else
        <input type="hidden" name="{{ $removeName }}" value="0" id="{{ $removeName }}Input">
    @endif
    <input type="file" class="form-control form-control-sm" id="{{ $inputId }}" name="{{ $name }}" accept="image/*">
    <small class="text-muted d-block mt-1">Shown on screens under 768px. Recommended: {{ $recommended }}. Falls back to desktop if empty.</small>
</div>
