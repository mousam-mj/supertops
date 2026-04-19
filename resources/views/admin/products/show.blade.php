@extends('admin.layout')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                @if($product->resolveMainImagePath())
                    <div class="mb-3">
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="img-fluid"
                             style="max-width: 300px; border-radius: 8px;">
                    </div>
                @endif
                <table class="table">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code>{{ $product->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>SKU</th>
                        <td>{{ $product->sku ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>
                            @if($product->category)
                                <span class="badge bg-info">{{ $product->category->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                            @if($product->is_featured)
                                <span class="badge bg-primary ms-2">Featured</span>
                            @endif
                        </td>
                    </tr>
                    @if($product->short_description)
                    <tr>
                        <th>Short Description</th>
                        <td>{{ $product->short_description }}</td>
                    </tr>
                    @endif
                    @if($product->description)
                    <tr>
                        <th>Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Created At</th>
                        <td>{{ $product->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $product->updated_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{{ route('admin.products.edit', $product) }}}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Product
                    </a>
                    <a href="{{{ route('admin.products.index') }}}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

