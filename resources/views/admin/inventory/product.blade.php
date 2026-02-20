@extends('admin.layout')

@section('title', 'Inventory: ' . $product->name)
@section('page-title', 'Inventory: ' . $product->name)

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Inventory
        </a>
    </div>
</div>

@php
    $totalStock = $product->inventories->sum('quantity');
    $inventories = $product->inventories()->orderBy('color')->orderBy('size')->get();
@endphp

{{-- Total Stock --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);">
            <div class="card-body text-white py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-90">Total Stock</div>
                        <h3 class="mb-0 fw-bold">{{ $totalStock }} <span class="fw-normal small">items in stock</span></h3>
                    </div>
                    <div style="font-size: 2.5rem; opacity: 0.3;"><i class="bi bi-box-seam"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stock by Color & Size (cards) --}}
@if($inventories->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <h5 class="fw-bold mb-3" style="color: #2d3748;">Stock by Color & Size</h5>
        <div class="row g-3">
            @foreach($inventories as $inv)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);">
                    <div class="card-body text-white py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-light text-dark me-1">{{ $inv->color ?: '—' }}</span>
                                <span class="badge bg-light text-dark">{{ $inv->size ?: '—' }}</span>
                                <div class="mt-2 small opacity-90">{{ $inv->quantity }} entry · Current available stock</div>
                            </div>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@php
    $colorOptions = array_unique(array_merge(
        $inventories->pluck('color')->filter()->map(fn($c) => trim($c))->values()->toArray(),
        ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White', 'Gray', 'Grey', 'Brown', 'Pink', 'Orange', 'Purple', 'Navy', 'Maroon', 'Dark Blue', 'Dark Green', 'Charcoal', 'Light Blue', 'Light Green', 'Beige', 'Cream', 'Ivory', 'Coral', 'Turquoise', 'Magenta', 'Teal', 'Indigo', 'Violet', 'Lavender', 'Khaki', 'Tan', 'Olive', 'Burgundy', 'Camel', 'Taupe', 'Silver', 'Gold', 'Bronze', 'Champagne', 'Nude', 'Royal Blue', 'Forest Green', 'Amber', 'Crimson', 'Mustard', 'Ash', 'Azure', 'Bei', 'Cerulean', 'Chartreuse', 'Copper', 'Mocha', 'Peach', 'Sky Blue', 'Slate']
    ));
    sort($colorOptions);
    $sizeOptions = array_unique(array_merge(
        $inventories->pluck('size')->filter()->map(fn($s) => trim($s))->values()->toArray(),
        ['Free Size', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '28', '30', '32', '34', '36', '38', '40', '42', '32GB', '64GB', '128GB', '256GB', '512GB', '1TB', '4GB RAM', '6GB RAM', '8GB RAM', '12GB RAM', '16GB RAM', '128GB+8GB', '256GB+8GB', '512GB+12GB', 'Standard', 'Premium', 'Pro', 'Max']
    ));
    sort($sizeOptions);
@endphp

{{-- Add Inventory --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header py-3 text-white border-0 d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: linear-gradient(135deg, #dc2626 0%, #8b5cf6 100%);">
                <div>
                    <h5 class="mb-0 fw-bold">Add Inventory</h5>
                    <small class="opacity-90">Select color, size, and enter the initial stock quantity. Upload image for this color (optional).</small>
                </div>
                <ul class="nav nav-pills nav-fill gap-1 mb-0" id="addInventoryTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="single-tab" data-bs-toggle="tab" data-bs-target="#single-pane" type="button" role="tab">Single</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk-pane" type="button" role="tab">Bulk</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="addInventoryTabContent">
                    <div class="tab-pane fade show active" id="single-pane" role="tabpanel">
                        <form action="{{ route('admin.inventory.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Color (Optional)</label>
                                    <input type="text" name="color" class="form-control" list="colorOptions" placeholder="e.g., Red, Blue, Black, etc." value="{{ old('color') }}">
                                    <datalist id="colorOptions">
                                        @foreach($colorOptions as $c)
                                            <option value="{{ $c }}"></option>
                                        @endforeach
                                    </datalist>
                                    <small class="text-muted">Type color name or choose from list.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Size / Variant (Optional)</label>
                                    <input type="text" name="size" class="form-control" list="sizeOptions" placeholder="e.g., 64GB, 128GB, L, XL, etc." value="{{ old('size') }}">
                                    <datalist id="sizeOptions">
                                        @foreach($sizeOptions as $s)
                                            <option value="{{ $s }}"></option>
                                        @endforeach
                                    </datalist>
                                    <small class="text-muted">Type size/variant or choose from list.</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Initial Stock <span class="text-danger">*</span></label>
                                    <input type="number" name="initial_quantity" class="form-control" min="0" value="{{ old('initial_quantity') }}" placeholder="Enter quantity" required>
                                    <small class="text-muted">Total stock to add (reduces as orders come in).</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Price (₹) (Optional)</label>
                                    <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" placeholder="₹">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Sale Price (₹) (Optional)</label>
                                    <input type="number" name="sale_price" class="form-control" step="0.01" min="0" value="{{ old('sale_price') }}" placeholder="₹">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Image for this color (Optional)</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="text-muted">Upload images specific to this color (optional).</small>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #dc2626 0%, #8b5cf6 100%); border: none;">
                                        <i class="bi bi-plus-lg me-1"></i>Add Inventory
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="bulk-pane" role="tabpanel">
                        <form action="{{ route('admin.inventory.bulk.store', $product->id) }}" method="POST" id="bulk-inventory-form">
                            @csrf
                            <p class="text-muted small mb-3">Add multiple inventory entries at once. Same color+size will add to existing stock.</p>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-sm" id="bulk-inventory-table">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th>Size / Variant</th>
                                            <th>Quantity *</th>
                                            <th>Price (₹)</th>
                                            <th>Sale Price (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 0; $i < 5; $i++)
                                        <tr>
                                            <td><input type="text" name="items[{{ $i }}][color]" class="form-control form-control-sm" list="colorOptionsBulk" placeholder="Red, Blue..."></td>
                                            <td><input type="text" name="items[{{ $i }}][size]" class="form-control form-control-sm" list="sizeOptionsBulk" placeholder="L, XL, 64GB..."></td>
                                            <td><input type="number" name="items[{{ $i }}][quantity]" class="form-control form-control-sm" min="0" placeholder="0"></td>
                                            <td><input type="number" name="items[{{ $i }}][price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>
                                            <td><input type="number" name="items[{{ $i }}][sale_price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <datalist id="colorOptionsBulk">
                                @foreach($colorOptions as $c)
                                    <option value="{{ $c }}"></option>
                                @endforeach
                            </datalist>
                            <datalist id="sizeOptionsBulk">
                                @foreach($sizeOptions as $s)
                                    <option value="{{ $s }}"></option>
                                @endforeach
                            </datalist>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="add-bulk-row"><i class="bi bi-plus me-1"></i>Add row</button>
                            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #dc2626 0%, #8b5cf6 100%); border: none;">
                                <i class="bi bi-plus-lg me-1"></i>Bulk Add Inventory
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Inventory Details --}}
<div class="row">
    <div class="col-12">
        <h5 class="fw-bold mb-3" style="color: #2d3748;">Inventory Details</h5>
        @if($inventories->count() > 0)
            <div class="row g-3">
                @foreach($inventories as $inv)
                <div class="col-md-6 col-lg-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-secondary">{{ $inv->color ?: '—' }}</span>
                                <span class="badge bg-secondary">{{ $inv->size ?: '—' }}</span>
                            </div>
                            @if($inv->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $inv->image) }}" alt="" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                            @endif
                            <div class="small mb-1"><strong>Initial Stock:</strong> {{ $inv->initial_quantity }}</div>
                            <div class="small mb-1 text-danger"><strong>Sold:</strong> {{ $inv->sold_quantity }}</div>
                            <div class="small mb-2"><span class="badge bg-success">Current: {{ $inv->quantity }}</span> <span class="text-muted">(Initial − Sold)</span></div>
                            @if($inv->price !== null || $inv->sale_price !== null)
                                <div class="small mb-1"><strong>Price:</strong> ₹{{ number_format($inv->price ?? 0, 2) }}</div>
                                @if($inv->sale_price !== null)
                                    <div class="small text-danger mb-2"><strong>Sale Price:</strong> ₹{{ number_format($inv->sale_price, 2) }}</div>
                                @endif
                            @endif
                            <div class="small text-muted mb-2">Available stock for {{ $inv->color ?: 'N/A' }} - {{ $inv->size ?: 'N/A' }}</div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $inv->id }}"><i class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.inventory.destroy', $inv->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this inventory entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $inv->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.inventory.update', $inv->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Inventory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Color</label>
                                        <input type="text" name="color" class="form-control" value="{{ old('color', $inv->color) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Size</label>
                                        <input type="text" name="size" class="form-control" value="{{ old('size', $inv->size) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Current Quantity *</label>
                                        <input type="number" name="quantity" class="form-control" min="0" value="{{ old('quantity', $inv->quantity) }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Price (₹)</label>
                                        <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $inv->price) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Sale Price (₹)</label>
                                        <input type="number" name="sale_price" class="form-control" step="0.01" min="0" value="{{ old('sale_price', $inv->sale_price) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Image (color)</label>
                                        @if($inv->image)
                                            <div class="mb-1"><img src="{{ asset('storage/' . $inv->image) }}" style="max-height: 80px;" class="rounded"></div>
                                            <label class="small"><input type="checkbox" name="remove_image" value="1"> Remove image</label>
                                        @endif
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <p class="text-muted small mt-2">Showing 1 to {{ $inventories->count() }} of {{ $inventories->count() }} entries.</p>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No inventory entries yet. Use the form above to add stock by color/size.
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function() {
    var table = document.getElementById('bulk-inventory-table');
    var tbody = table && table.querySelector('tbody');
    var addBtn = document.getElementById('add-bulk-row');
    var colorList = 'colorOptionsBulk';
    var sizeList = 'sizeOptionsBulk';
    if (!tbody || !addBtn) return;
    addBtn.addEventListener('click', function() {
        var rows = tbody.querySelectorAll('tr');
        var last = rows[rows.length - 1];
        var idx = rows.length;
        var tr = document.createElement('tr');
        tr.innerHTML =
            '<td><input type="text" name="items[' + idx + '][color]" class="form-control form-control-sm" list="' + colorList + '" placeholder="Red, Blue..."></td>' +
            '<td><input type="text" name="items[' + idx + '][size]" class="form-control form-control-sm" list="' + sizeList + '" placeholder="L, XL, 64GB..."></td>' +
            '<td><input type="number" name="items[' + idx + '][quantity]" class="form-control form-control-sm" min="0" placeholder="0"></td>' +
            '<td><input type="number" name="items[' + idx + '][price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>' +
            '<td><input type="number" name="items[' + idx + '][sale_price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>';
        tbody.appendChild(tr);
    });
})();
</script>
@endpush
@endsection
