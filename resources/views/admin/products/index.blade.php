@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Product Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Products</h4>
                <p class="text-muted mb-0">Manage your product inventory</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bearingImportModal">
                    <i class="bi bi-upload me-2"></i>Import bearings (CSV / Excel)
                </button>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </a>
            </div>
        </div>

        @if(session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Import notes</strong>
                <ul class="mb-0 small">
                    @foreach(session('import_errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Search and Filter Form -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Search by name, SKU, or category..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="stock" class="form-label">Stock</label>
                        <select class="form-select" id="stock" name="stock">
                            <option value="">All Stock</option>
                            <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="out_of_stock" {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="low_stock" {{ request('stock') === 'low_stock' ? 'selected' : '' }}>Low Stock (≤10)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Search
                            </button>
                            @if(request()->hasAny(['search', 'status', 'stock']))
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(request()->hasAny(['search', 'status', 'stock']))
    <div class="alert alert-info mb-3">
        <i class="bi bi-info-circle me-2"></i>
        Found <strong>{{ $products->total() }}</strong> product(s) matching your search criteria.
        @if(request('search'))
            <br><small>Searching for: "<strong>{{ request('search') }}</strong>"</small>
        @endif
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $productPlaceholder = asset('assets/images/product/perch-bottal.webp');
                                $getImageUrlFromPath = function($path) {
                                    if (!$path || !is_string($path)) return null;
                                    if (str_starts_with($path, 'http') || str_starts_with($path, '//')) return $path;
                                    if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) return asset($path);
                                    return storage_asset($path);
                                };
                                $getProductImageUrl = function($product) use ($getImageUrlFromPath) {
                                    if ($product->image) return $getImageUrlFromPath($product->image);
                                    if (is_array($product->images) && count($product->images) > 0) {
                                        $first = $product->images[0];
                                        return is_string($first) ? $getImageUrlFromPath($first) : null;
                                    }
                                    return null;
                                };
                            @endphp
                            @forelse($products as $product)
                                @php $imageUrl = $getProductImageUrl($product) ?? $productPlaceholder; @endphp
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; background: #f0f0f0;"
                                             onerror="this.onerror=null; this.src='{{ $productPlaceholder }}';">
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $product->name }}</div>
                                        @if($product->sku)
                                            <small class="text-muted">SKU: {{ $product->sku }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge bg-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->sale_price)
                                            <span class="text-decoration-line-through text-muted">₹{{ number_format($product->price, 2) }}</span>
                                            <br>
                                            <strong class="text-danger">₹{{ number_format($product->sale_price, 2) }}</strong>
                                        @else
                                            <strong>₹{{ number_format($product->price, 2) }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->stock_quantity < 10)
                                            <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="badge bg-primary">Featured</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <p class="text-muted mb-0">No products found.</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary mt-2">
                                            Create First Product
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($products->hasPages())
                <div class="card-footer-pagination">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="bearingImportModal" tabindex="-1" aria-labelledby="bearingImportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bearingImportModalLabel">Import bearing catalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.products.bearing-import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Upload exports in the same shape as WordPress <strong>DGBB</strong>, <strong>SRB</strong>, or <strong>CRB</strong> files
                        (pipe-separated <code>Image URL</code>s, <code>bearing_no</code> as SKU, <code>Bearing Category</code> / <code>bearing_category</code> must match a seeded bearing category).
                    </p>
                    <div class="mb-3">
                        <label for="import_file" class="form-label">File (.csv, .txt, .xlsx, .xls — max 20&nbsp;MB)</label>
                        <input type="file" class="form-control" name="import_file" id="import_file" accept=".csv,.txt,.xlsx,.xls" required>
                    </div>
                    <p class="mb-2">
                        <a href="{{ route('admin.products.bearing-import.sample') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-download me-1"></i>Download sample header (DGBB-style)
                        </a>
                    </p>
                    <details class="small text-muted mt-3">
                        <summary class="fw-semibold text-secondary mb-2">Expected columns (reference)</summary>
                        <p class="mb-2"><strong>DGBB / SRB-style</strong> (first row headers): <code>ID</code>, <code>Title</code>, <code>Post Type</code>, <code>Image URL</code> (optional, multiple URLs with <code>|</code>), <code>Bearing Category</code>, <code>bearing_no</code>, <code>bore_diameter</code>, <code>outside_diameter</code>, <code>width</code>, <code>basic_dynamic_load_rating</code>, <code>basic_static_load_rating</code>, <code>limiting_speed_grease</code>, <code>limiting_speed_oil</code>, <code>number_of_rows</code>, <code>radial_internal_clearance</code>, <code>tolerance_class_for_dimensions</code>, <code>cage</code>, <code>bore_type</code>, equivalents <code>skf</code>, <code>fag</code>, <code>ntn</code>, <code>timken</code>, suffix fields, <code>bearing_category</code>, and optionally <code>bearing_description</code>, <code>product_net_weight</code>.</p>
                        <p class="mb-0"><strong>CRB-style</strong>: same bearing columns; uses a single <code>limiting_speed</code> column (mapped to both grease and oil in specs). Category from <code>bearing_category</code> / title context.</p>
                    </details>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-1"></i>Run import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

