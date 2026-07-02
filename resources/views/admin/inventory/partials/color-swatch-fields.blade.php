@php
    use App\Models\MasterColor;

    $swatchColors = collect($inventoryColors ?? [])
        ->filter(fn ($c) => trim((string) $c) !== '')
        ->values();
    $swatchImages = is_array($product->color_swatch_images ?? null) ? $product->color_swatch_images : [];
    $variantNames = is_array($product->color_variant_names ?? null) ? $product->color_variant_names : [];
    $masterColorCodes = $masterColorCodes ?? MasterColor::pluck('color_code', 'name')->toArray();

    $productBaseName = $product->name;
    foreach ($swatchColors as $colorName) {
        $suffix = ', ' . $colorName;
        if (str_ends_with($productBaseName, $suffix)) {
            $productBaseName = substr($productBaseName, 0, -strlen($suffix));
            break;
        }
    }
@endphp

@if($swatchColors->isNotEmpty())
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header py-3 text-white border-0" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                <h5 class="mb-0 fw-bold">Color display settings</h5>
                <small class="opacity-90 d-block mt-1">Set the product title shown on the product page for each color, and upload swatch images for dual-tone colors.</small>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inventory.color-swatches', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        @foreach($swatchColors as $index => $colorName)
                            @php
                                $storedPath = $swatchImages[$colorName] ?? null;
                                $hexCode = trim((string) ($masterColorCodes[$colorName] ?? ''));
                                $defaultTitle = trim($productBaseName) . ', ' . $colorName;
                                $storedTitle = trim((string) ($variantNames[$colorName] ?? ''));
                            @endphp
                            <div class="col-md-6 col-lg-4">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <strong>{{ $colorName }}</strong>
                                        @if($hexCode !== '')
                                            <span class="d-inline-block rounded-circle border" style="width:18px;height:18px;background:{{ $hexCode }};" title="Master hex: {{ $hexCode }}"></span>
                                            <span class="small text-muted">{{ $hexCode }}</span>
                                        @endif
                                    </div>
                                    <label class="form-label small mb-1">Product title for this color</label>
                                    <input type="hidden" name="swatch_color_keys[{{ $index }}]" value="{{ $colorName }}">
                                    <input type="text"
                                           name="variant_names[{{ $index }}]"
                                           class="form-control form-control-sm mb-2"
                                           value="{{ old('variant_names.' . $index, $storedTitle !== '' ? $storedTitle : $defaultTitle) }}"
                                           placeholder="{{ $defaultTitle }}">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if($storedPath)
                                            <img src="{{ storage_asset($storedPath) }}" alt="{{ $colorName }} swatch" class="rounded-circle border" style="width:48px;height:48px;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle border bg-white d-flex align-items-center justify-content-center text-muted small" style="width:48px;height:48px;">
                                                No img
                                            </div>
                                        @endif
                                        <div class="small text-muted">
                                            Swatch image (optional): 96×96px square.
                                        </div>
                                    </div>
                                    <input type="hidden" name="remove_swatch[{{ $index }}]" value="0" id="removeSwatch{{ $index }}">
                                    <input type="file" name="swatch_images[{{ $index }}]" class="form-control form-control-sm mb-2" accept="image/jpeg,image/png,image/webp,image/gif">
                                    @if($storedPath)
                                        <button type="button" class="btn btn-sm btn-outline-danger swatch-remove-btn" data-remove-input="removeSwatch{{ $index }}">
                                            <i class="bi bi-trash me-1"></i>Remove swatch
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary inventory-submit-btn">
                            <i class="bi bi-check-lg me-1"></i>Save color settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
