@php
    $fieldName = $name ?? 'text_color';
    $fieldId = $id ?? $fieldName;
    $fieldValue = old($fieldName, $value ?? '');
    $fieldLabel = $label ?? 'Banner text color';
    $allowDefault = $allowDefault ?? true;
@endphp
<div class="{{ $wrapperClass ?? 'mb-3' }}">
    <label for="{{ $fieldId }}" class="form-label">{{ $fieldLabel }}</label>
    <select class="form-select @error($fieldName) is-invalid @enderror" id="{{ $fieldId }}" name="{{ $fieldName }}">
        @if($allowDefault)
            <option value="" @selected((string) $fieldValue === '')>Use site default</option>
        @endif
        <option value="black" @selected($fieldValue === 'black')>Black</option>
        <option value="white" @selected($fieldValue === 'white')>White</option>
    </select>
    @error($fieldName)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Use white on dark banner images; black on light backgrounds.</small>
</div>
