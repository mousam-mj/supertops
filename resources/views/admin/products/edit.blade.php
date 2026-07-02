@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product: ' . $product->name)

@section('content')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <form id="product-edit-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" 
                                  name="short_description" 
                                  rows="3" 
                                  placeholder="Brief summary (shown in product cards and below price)">{{ old('short_description', $product->short_description) }}</textarea>
                        <small class="text-muted">Brief teaser text, max 500 characters. Shown in product listings and below price.</small>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Detailed Description</label>
                        <div id="editor-description" class="bg-white border rounded" style="min-height: 220px;"></div>
                        <textarea class="form-control @error('description') is-invalid @enderror d-none" 
                                  id="description" 
                                  name="description" 
                                  rows="8">{{ old('description', $product->description) }}</textarea>
                        <small class="text-muted">Full product description. Shown in the Description tab on the product page. Use the toolbar to format.</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="bi bi-box-seam me-2"></i><strong>Inventory:</strong> Manage <strong>price</strong>, quantity, color &amp; size from the <a href="{{ route('admin.inventory.index') }}">Inventory</a> module. Upload <strong>color swatch images</strong> (for dual-tone colors) on the product’s <a href="{{ route('admin.inventory.product', $product->id) }}">Inventory page</a>.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Specifications</label>
                        <div id="specifications-container">
                            @php
                                $specs = old('specifications', []);
                                if (empty($specs) && is_array($product->specifications) && !empty($product->specifications)) {
                                    foreach ($product->specifications as $key => $value) {
                                        $specs[] = ['key' => $key, 'value' => $value];
                                    }
                                }
                                if (empty($specs)) $specs = [['key' => '', 'value' => '']];
                            @endphp
                            @foreach($specs as $idx => $spec)
                                <div class="spec-row mb-2 d-flex gap-2 align-items-start" data-index="{{ $idx }}">
                                    <div class="flex-grow-1">
                                        <input type="text" 
                                               name="specifications[{{ $idx }}][key]" 
                                               class="form-control form-control-sm" 
                                               placeholder="Key (e.g. Brand, Capacity, Material)" 
                                               value="{{ $spec['key'] ?? '' }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="text" 
                                               name="specifications[{{ $idx }}][value]" 
                                               class="form-control form-control-sm" 
                                               placeholder="Value (e.g. Perch, 1000ml, Stainless Steel)" 
                                               value="{{ $spec['value'] ?? '' }}">
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-success add-spec-btn" title="Add">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger remove-spec-btn" title="Remove" {{ count($specs) <= 1 ? 'style="display:none;"' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Add product specifications like Brand, Capacity, Material, etc. Click + to add more.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" 
                                   class="form-control @error('sku') is-invalid @enderror" 
                                   id="sku" 
                                   name="sku" 
                                   value="{{ old('sku', $product->sku) }}">
                            @error('sku')
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
                                   value="{{ old('sort_order', $product->sort_order) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            @if($product->image)
                                <div class="mb-2 position-relative d-inline-block">
                                    <img src="{{ storage_asset($product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         id="currentProductImage"
                                         style="max-width: 150px; max-height: 150px; border-radius: 4px;">
                                    <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" id="removeImageBtn" onclick="toggleRemoveImage()">
                                        <i class="bi bi-trash me-1"></i>Remove Image
                                    </button>
                                </div>
                            @endif
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended: 1200×1600px (3:4). Leave empty to keep current. Max 2MB</small>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gallery Images</label>
                            <div id="existing-gallery-images" class="mb-2 d-flex flex-wrap gap-2">
                                @if(is_array($product->images) && count($product->images) > 0)
                                    @foreach($product->images as $idx => $img)
                                        <div class="position-relative d-inline-block gallery-thumb-wrap" data-path="{{ $img }}">
                                            <img src="{{ storage_asset($img) }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #e2e8f0;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle gallery-remove-btn" style="width: 24px; height: 24px; padding: 0; font-size: 12px; line-height: 1;" data-path="{{ $img }}" title="Remove">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div id="removeGalleryInputs"></div>
                            <div id="new-gallery-images" class="mb-2 d-flex flex-wrap gap-2"></div>
                            <div class="d-flex gap-2">
                                <input type="file"
                                       class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror"
                                       id="gallery_image_single"
                                       accept="image/*">
                                <button type="button" class="btn btn-sm btn-success" id="add-gallery-image-btn">
                                    <i class="bi bi-plus me-1"></i>Add Image
                                </button>
                            </div>
                            <input type="file" name="gallery_images[]" id="gallery_images_hidden" multiple accept="image/*" style="display: none;">
                            @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('gallery_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended: 1200×1600px (3:4) each. Click "Add Image" to upload one by one.</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="video" class="form-label">Product Video</label>
                            @if($product->video)
                                <div class="mb-2">
                                    <video src="{{ storage_asset($product->video) }}" controls id="currentProductVideo" style="max-width: 200px; border-radius: 4px;"></video>
                                    <input type="hidden" name="remove_video" value="0" id="removeVideoInput">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" id="removeVideoBtn" onclick="toggleRemoveVideo()">
                                        <i class="bi bi-trash me-1"></i>Remove Video
                                    </button>
                                </div>
                            @endif
                            <input type="file"
                                   class="form-control @error('video') is-invalid @enderror"
                                   id="video"
                                   name="video"
                                   accept="video/*">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Upload a new video to replace the current one. Max size: 50MB.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <small class="text-muted d-block">
                                <strong>Featured</strong> → homepage Best Sellers tab &amp; category What&apos;s New.
                                <strong>New Arrival</strong> → homepage New Arrivals tab.
                                <strong>On Sale</strong> → set a <em>sale price</em> lower than regular price in <a href="{{ route('admin.inventory.index') }}">Inventory</a>.
                            </small>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="in_stock" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="in_stock" 
                                       name="in_stock" 
                                       value="1" 
                                       {{ old('in_stock', $product->in_stock) ? 'checked' : '' }}>
                                <label class="form-check-label" for="in_stock">
                                    In Stock
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="is_active" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="is_featured" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="hidden" name="is_new_arrival" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_new_arrival" 
                                       name="is_new_arrival" 
                                       value="1" 
                                       {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_new_arrival">
                                    New Arrival
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="small text-muted pt-2">
                                Current pricing:
                                @if($product->sale_price && $product->price > $product->sale_price)
                                    <span class="badge bg-danger ms-1">On Sale</span>
                                    ₹{{ number_format($product->sale_price, 2) }}
                                    <del class="text-secondary ms-1">₹{{ number_format($product->price, 2) }}</del>
                                @else
                                    ₹{{ number_format($product->price ?? 0, 2) }}
                                    <span class="text-secondary ms-1">(edit sale price in Inventory to appear under On Sale)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @php
                        $variantMode = old('variant_mode', $product->parent_product_id ? 'linked' : 'main');
                        $variantLinkRows = old('variant_links');
                        if (! is_array($variantLinkRows)) {
                            $variantLinkRows = $linkedVariants->map(fn ($v) => [
                                'product_id' => $v->id,
                                'color_label' => $v->variant_color_label ?: $v->getDisplayColorLabel(),
                            ])->values()->all();
                        }
                        if (empty($variantLinkRows)) {
                            $variantLinkRows = [['product_id' => '', 'color_label' => '']];
                        }
                    @endphp

                    <div class="card border-info mb-4">
                        <div class="card-header bg-info-subtle">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-link-45deg me-2"></i>Connected Color Variants</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">
                                Link separate products as color variants of one main product. Each linked product stays visible in the shop and appears as a color option on the product page.
                            </p>

                            <div class="mb-3">
                                <label class="form-label">Variant setup</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="variant_mode" id="variant_mode_main" value="main" {{ $variantMode === 'main' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="variant_mode_main">This is the main product (connect other products as color variants)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="variant_mode" id="variant_mode_linked" value="linked" {{ $variantMode === 'linked' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="variant_mode_linked">This product is a color variant of another product</label>
                                </div>
                            </div>

                            <div id="variant-main-panel" class="{{ $variantMode === 'linked' ? 'd-none' : '' }}">
                                <div class="mb-3">
                                    <label for="main_variant_color_label" class="form-label">Color label for this product</label>
                                    <input type="text"
                                           class="form-control"
                                           id="main_variant_color_label"
                                           name="main_variant_color_label"
                                           value="{{ old('main_variant_color_label', $product->variant_color_label) }}"
                                           placeholder="e.g. Amber Brown">
                                    <small class="text-muted">Shown in the color picker on the product page.</small>
                                </div>

                                <label class="form-label">Linked variant products</label>
                                <div id="variant-links-container" class="d-flex flex-column gap-2">
                                    @foreach($variantLinkRows as $idx => $row)
                                        <div class="variant-link-row d-flex gap-2 align-items-start flex-wrap">
                                            <div class="flex-grow-1" style="min-width: 220px;">
                                                <select name="variant_links[{{ $idx }}][product_id]" class="form-select form-select-sm">
                                                    <option value="">Select product to link</option>
                                                    @foreach($linkableProducts as $linkProduct)
                                                        <option value="{{ $linkProduct->id }}" {{ (string) ($row['product_id'] ?? '') === (string) $linkProduct->id ? 'selected' : '' }}>
                                                            {{ $linkProduct->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div style="min-width: 180px;">
                                                <input type="text"
                                                       name="variant_links[{{ $idx }}][color_label]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $row['color_label'] ?? '' }}"
                                                       placeholder="Color label (e.g. Cyan)">
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-variant-link-btn" title="Remove row">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-variant-link-btn">
                                    <i class="bi bi-plus-lg me-1"></i>Add linked product
                                </button>
                            </div>

                            <div id="variant-linked-panel" class="{{ $variantMode === 'main' ? 'd-none' : '' }}">
                                <div class="mb-3">
                                    <label for="parent_product_id" class="form-label">Main product</label>
                                    <select class="form-select" id="parent_product_id" name="parent_product_id">
                                        <option value="">Select main product</option>
                                        @foreach($mainProductOptions as $mainProduct)
                                            <option value="{{ $mainProduct->id }}" {{ (string) old('parent_product_id', $product->parent_product_id) === (string) $mainProduct->id ? 'selected' : '' }}>
                                                {{ $mainProduct->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label for="variant_color_label" class="form-label">Color label for this product</label>
                                    <input type="text"
                                           class="form-control"
                                           id="variant_color_label"
                                           name="variant_color_label"
                                           value="{{ old('variant_color_label', $product->variant_color_label) }}"
                                           placeholder="e.g. Cyan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{{ route('admin.products.index') }}}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var descTa = document.getElementById('description');
        if (descTa && document.getElementById('editor-description')) {
            var quill = new Quill('#editor-description', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [5, 6, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link'],
                        ['clean']
                    ]
                }
            });
            if (descTa.value) quill.clipboard.dangerouslyPasteHTML(descTa.value);
            document.getElementById('product-edit-form').addEventListener('submit', function(e) {
                e.preventDefault();
                descTa.value = quill.root.innerHTML;
                this.submit();
            });
        }

        var specIndex = {{ count($specs ?? [['key' => '', 'value' => '']]) }};
        var specContainer = document.getElementById('specifications-container');
        
        function updateRemoveButtons() {
            var rows = specContainer.querySelectorAll('.spec-row');
            rows.forEach(function(btn) {
                var removeBtn = btn.querySelector('.remove-spec-btn');
                if (removeBtn) {
                    removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
                }
            });
        }
        
        if (specContainer) {
            specContainer.addEventListener('click', function(e) {
                if (e.target.closest('.add-spec-btn')) {
                    var row = e.target.closest('.spec-row').cloneNode(true);
                    var idx = specIndex++;
                    row.setAttribute('data-index', idx);
                    row.querySelector('input[name*="[key]"]').setAttribute('name', 'specifications[' + idx + '][key]');
                    row.querySelector('input[name*="[value]"]').setAttribute('name', 'specifications[' + idx + '][value]');
                    row.querySelector('input[name*="[key]"]').value = '';
                    row.querySelector('input[name*="[value]"]').value = '';
                    specContainer.appendChild(row);
                    updateRemoveButtons();
                } else if (e.target.closest('.remove-spec-btn')) {
                    e.target.closest('.spec-row').remove();
                    updateRemoveButtons();
                }
            });
            updateRemoveButtons();
        }

        var gallerySingleInput = document.getElementById('gallery_image_single');
        var galleryHiddenInput = document.getElementById('gallery_images_hidden');
        var newGalleryContainer = document.getElementById('new-gallery-images');
        var addGalleryBtn = document.getElementById('add-gallery-image-btn');
        var fileList = [];
        if (gallerySingleInput && addGalleryBtn) {
            addGalleryBtn.addEventListener('click', function() {
                gallerySingleInput.click();
            });
            gallerySingleInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    var file = e.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var div = document.createElement('div');
                        div.className = 'position-relative d-inline-block gallery-thumb-wrap';
                        div.innerHTML = '<img src="' + event.target.result + '" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #e2e8f0;"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle remove-new-gallery-btn" style="width: 24px; height: 24px; padding: 0; font-size: 12px;"><i class="bi bi-x"></i></button>';
                        div.querySelector('.remove-new-gallery-btn').addEventListener('click', function() {
                            var dataTransfer = new DataTransfer();
                            fileList = fileList.filter(function(f) { return f !== file; });
                            fileList.forEach(function(f) { dataTransfer.items.add(f); });
                            galleryHiddenInput.files = dataTransfer.files;
                            div.remove();
                        });
                        newGalleryContainer.appendChild(div);
                        fileList.push(file);
                        var dataTransfer = new DataTransfer();
                        fileList.forEach(function(f) { dataTransfer.items.add(f); });
                        galleryHiddenInput.files = dataTransfer.files;
                        gallerySingleInput.value = '';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
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

    function toggleRemoveImage() {
        const input = document.getElementById('removeImageInput');
        const btn = document.getElementById('removeImageBtn');
        const img = document.getElementById('currentProductImage');
        if (!input) return;
        const isRemoving = input.value === '1';
        input.value = isRemoving ? '0' : '1';
        if (img) img.style.opacity = isRemoving ? '1' : '0.4';
        if (btn) {
            btn.classList.toggle('btn-outline-danger', isRemoving);
            btn.classList.toggle('btn-danger', !isRemoving);
            btn.innerHTML = isRemoving ? '<i class="bi bi-trash me-1"></i>Remove Image' : '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
        }
    }

    function toggleRemoveVideo() {
        const input = document.getElementById('removeVideoInput');
        const btn = document.getElementById('removeVideoBtn');
        const video = document.getElementById('currentProductVideo');
        if (!input) return;
        const isRemoving = input.value === '1';
        input.value = isRemoving ? '0' : '1';
        if (video) video.style.opacity = isRemoving ? '1' : '0.4';
        if (btn) {
            btn.classList.toggle('btn-outline-danger', isRemoving);
            btn.classList.toggle('btn-danger', !isRemoving);
            btn.innerHTML = isRemoving ? '<i class="bi bi-trash me-1"></i>Remove Video' : '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
        }
    }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.gallery-remove-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const path = this.getAttribute('data-path');
                const wrap = this.closest('.gallery-thumb-wrap');
                const container = document.getElementById('removeGalleryInputs');
                if (!wrap || !container) return;
                const inp = Array.from(container.querySelectorAll('input[name="remove_gallery_images[]"]')).find(function(i) { return i.value === path; });
                if (inp) {
                    wrap.style.opacity = '1';
                    this.innerHTML = '<i class="bi bi-x"></i>';
                    inp.remove();
                } else {
                    wrap.style.opacity = '0.4';
                    this.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i>';
                    const newInp = document.createElement('input');
                    newInp.type = 'hidden';
                    newInp.name = 'remove_gallery_images[]';
                    newInp.value = path;
                    container.appendChild(newInp);
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mainPanel = document.getElementById('variant-main-panel');
        var linkedPanel = document.getElementById('variant-linked-panel');
        var modeMain = document.getElementById('variant_mode_main');
        var modeLinked = document.getElementById('variant_mode_linked');
        var linksContainer = document.getElementById('variant-links-container');
        var addBtn = document.getElementById('add-variant-link-btn');
        var linkIndex = linksContainer ? linksContainer.querySelectorAll('.variant-link-row').length : 0;

        function toggleVariantPanels() {
            var isMain = modeMain && modeMain.checked;
            if (mainPanel) mainPanel.classList.toggle('d-none', !isMain);
            if (linkedPanel) linkedPanel.classList.toggle('d-none', isMain);
        }

        if (modeMain) modeMain.addEventListener('change', toggleVariantPanels);
        if (modeLinked) modeLinked.addEventListener('change', toggleVariantPanels);

        if (addBtn && linksContainer) {
            addBtn.addEventListener('click', function() {
                var template = linksContainer.querySelector('.variant-link-row');
                if (!template) return;
                var row = template.cloneNode(true);
                row.querySelectorAll('select, input').forEach(function(el) {
                    el.name = el.name.replace(/\[\d+\]/, '[' + linkIndex + ']');
                    el.value = '';
                });
                linksContainer.appendChild(row);
                linkIndex++;
            });

            linksContainer.addEventListener('click', function(e) {
                if (!e.target.closest('.remove-variant-link-btn')) return;
                var rows = linksContainer.querySelectorAll('.variant-link-row');
                if (rows.length <= 1) {
                    rows[0].querySelectorAll('select, input').forEach(function(el) { el.value = ''; });
                    return;
                }
                e.target.closest('.variant-link-row').remove();
            });
        }
    });
</script>
@endpush
@endsection

