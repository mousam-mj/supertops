@extends('admin.layout')

@section('title', 'Inventory')
@section('page-title', 'Inventory Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">Product Inventory</h4>
            <p class="text-muted mb-0">Manage stock levels for all products</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                                @endif
                                                <div>
                                                    <a href="{{{ route('admin.products.show', $product) }}}" class="fw-semibold">{{ $product->name }}</a>
                                                    @if($product->sku)
                                                        <div class="text-muted small">{{ $product->sku }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $stock = $product->stock_quantity ?? 0;
                                            @endphp
                                            @if($stock <= 0)
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @elseif($stock < 10)
                                                <span class="badge bg-warning">{{ $stock }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $stock }}</span>
                                            @endif
                                        </td>
                                        <td>₹{{ number_format($product->sale_price ?? $product->price ?? 0, 2) }}</td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{{ route('admin.products.edit', $product) }}}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No products found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


