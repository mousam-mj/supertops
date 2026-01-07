@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">Dashboard Overview</h4>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your store.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Users</h6>
                        <h3 class="card-title mb-0">{{ $stats['total_users'] }}</h3>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Products</h6>
                        <h3 class="card-title mb-0">{{ $stats['total_products'] }}</h3>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Orders</h6>
                        <h3 class="card-title mb-0">{{ $stats['total_orders'] }}</h3>
                    </div>
                    <i class="bi bi-cart-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Revenue</h6>
                        <h3 class="card-title mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-warning">Pending Orders</h6>
                        <h4 class="card-title mb-0">{{ $stats['pending_orders'] }}</h4>
                    </div>
                    <i class="bi bi-clock-history fs-2 text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-danger">Low Stock Products</h6>
                        <h4 class="card-title mb-0">{{ $stats['low_stock_products'] }}</h4>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-2 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-success">Active Categories</h6>
                        <h4 class="card-title mb-0">{{ $stats['active_categories'] }}</h4>
                    </div>
                    <i class="bi bi-folder-check fs-2 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                @if($recent_orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_orders as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td><span class="badge bg-{{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span></td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All Orders</a>
                @else
                    <p class="text-muted mb-0">No orders yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Latest Products</h5>
            </div>
            <div class="card-body">
                @if($top_products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_products as $product)
                                <tr>
                                    <td><a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a></td>
                                    <td>${{ number_format($product->final_price, 2) }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">View All Products</a>
                @else
                    <p class="text-muted mb-0">No products yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary w-100">
                            <i class="bi bi-globe me-2"></i>View Website
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus me-2"></i>Manage Users
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-box me-2"></i>Add Product
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-cart me-2"></i>Manage Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





