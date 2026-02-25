@extends('admin.layout')

@section('title', 'Color & Size Master')
@section('page-title', 'Color & Size Master')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Color & Size Master</h4>
        <p class="text-muted mb-0">Manage master colors and sizes for products and inventory</p>
    </div>
</div>

<div class="row">
    {{-- Master Colors --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-palette me-2"></i>Master Colors</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.color-size-master.store-color') }}" method="POST" class="row g-2 mb-4">
                    @csrf
                    <div class="col-auto flex-grow-1">
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Add new color (e.g. Red, Blue)" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-auto" style="width: 80px;">
                        <input type="number" name="sort_order" class="form-control form-control-sm" placeholder="Order" value="0" min="0">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add</button>
                    </div>
                </form>
                @if($colors->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colors as $color)
                                    <tr>
                                        <td>{{ $color->id }}</td>
                                        <td>{{ $color->name }}</td>
                                        <td>{{ $color->sort_order }}</td>
                                        <td>
                                            <form action="{{ route('admin.color-size-master.destroy-color', $color) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this color?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0 small">No colors yet. Add one above.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Master Sizes --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-rulers me-2"></i>Master Sizes</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.color-size-master.store-size') }}" method="POST" class="row g-2 mb-4">
                    @csrf
                    <div class="col-auto flex-grow-1">
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Add new size (e.g. S, M, L, 32GB)" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-auto" style="width: 80px;">
                        <input type="number" name="sort_order" class="form-control form-control-sm" placeholder="Order" value="0" min="0">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add</button>
                    </div>
                </form>
                @if($sizes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sizes as $size)
                                    <tr>
                                        <td>{{ $size->id }}</td>
                                        <td>{{ $size->name }}</td>
                                        <td>{{ $size->sort_order }}</td>
                                        <td>
                                            <form action="{{ route('admin.color-size-master.destroy-size', $size) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this size?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0 small">No sizes yet. Add one above.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
