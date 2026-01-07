@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Category Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Category
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Children</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        @if($category->description)
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-info">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->children->count() > 0)
                                            <span class="badge bg-secondary">{{ $category->children->count() }}</span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                                        <p class="text-muted mb-0">No categories found.</p>
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary mt-2">
                                            Create First Category
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Tree View -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Tree</h5>
            </div>
            <div class="card-body">
                <div class="category-tree">
                    @php
                        $mainCategories = $categories->whereNull('parent_id');
                    @endphp
                    @foreach($mainCategories as $mainCategory)
                        <div class="tree-item mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-folder-fill text-warning me-2"></i>
                                <strong>{{ $mainCategory->name }}</strong>
                                @if(!$mainCategory->is_active)
                                    <span class="badge bg-danger ms-2">Inactive</span>
                                @endif
                            </div>
                            @if($mainCategory->children->count() > 0)
                                <div class="ms-4">
                                    @foreach($mainCategory->children as $subCategory)
                                        <div class="tree-item mb-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="bi bi-folder text-info me-2"></i>
                                                <span>{{ $subCategory->name }}</span>
                                                @if(!$subCategory->is_active)
                                                    <span class="badge bg-danger ms-2">Inactive</span>
                                                @endif
                                            </div>
                                            @if($subCategory->children->count() > 0)
                                                <div class="ms-4">
                                                    @foreach($subCategory->children as $product)
                                                        <div class="d-flex align-items-center mb-1">
                                                            <i class="bi bi-file-earmark text-secondary me-2"></i>
                                                            <small>{{ $product->name }}</small>
                                                            @if(!$product->is_active)
                                                                <span class="badge bg-danger ms-2">Inactive</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

