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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sizes" class="form-label">Sizes</label>
                            <input type="text" 
                                   class="form-control @error('sizes') is-invalid @enderror" 
                                   id="sizes" 
                                   name="sizes" 
                                   value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}" 
                                   placeholder="e.g. S, M, L, XL">
                            <small class="text-muted">Comma-separated. Shown as options on the product page.</small>
                            @error('sizes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="colors" class="form-label">Colors</label>
                            <input type="text" 
                                   class="form-control @error('colors') is-invalid @enderror" 
                                   id="colors" 
                                   name="colors" 
                                   value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : '') }}" 
                                   placeholder="e.g. Red, Blue, Black">
                            <small class="text-muted">Comma-separated. Shown as options on the product page.</small>
                            @error('colors')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $product->price) }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('sale_price') is-invalid @enderror" 
                                       id="sale_price" 
                                       name="sale_price" 
                                       value="{{ old('sale_price', $product->sale_price) }}" 
                                       step="0.01" 
                                       min="0">
                            </div>
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
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
                        <div class="col-md-4 mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   id="stock_quantity" 
                                   name="stock_quantity" 
                                   value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                                   min="0" 
                                   required>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
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

                        <div class="col-md-4 mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            @if($product->image)
                                <div class="mb-2 position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
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
                            <small class="form-text text-muted">Leave empty to keep current image. Recommended size: 800x800px. Max size: 2MB</small>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="gallery_images" class="form-label">Gallery Images</label>
                            @if(is_array($product->images) && count($product->images) > 0)
                                <div class="mb-2 d-flex flex-wrap gap-2" id="galleryThumbnails">
                                    @foreach($product->images as $idx => $img)
                                        <div class="position-relative d-inline-block gallery-thumb-wrap" data-path="{{ $img }}">
                                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-0 rounded-end gallery-remove-btn" style="padding: 2px 6px; font-size: 10px;" data-path="{{ $img }}" title="Remove">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="removeGalleryInputs"></div>
                            @endif
                            <input type="file"
                                   class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror"
                                   id="gallery_images"
                                   name="gallery_images[]"
                                   accept="image/*"
                                   multiple>
                            @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('gallery_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Select additional images to add to the gallery. Click × on thumbnails to remove.</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="video" class="form-label">Product Video</label>
                            @if($product->video)
                                <div class="mb-2">
                                    <video src="{{ asset('storage/' . $product->video) }}" controls id="currentProductVideo" style="max-width: 200px; border-radius: 4px;"></video>
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
                        <div class="col-md-4">
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
@endpush
@endsection

