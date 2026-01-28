@extends('admin.layout')

@section('title', 'Orders')
@section('page-title', 'Order Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Orders</h4>
                <p class="text-muted mb-0">View and manage customer orders</p>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download Reports
            </a>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="filter-status" class="form-label small text-muted mb-1">Status</label>
                        <select name="status" id="filter-status" class="form-select form-select-sm">
                            <option value="all" {{ ($status ?? '') === 'all' || ($status ?? '') === '' ? 'selected' : '' }}>All</option>
                            <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ ($status ?? '') === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ ($status ?? '') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ ($status ?? '') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="fulfilled" {{ ($status ?? '') === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                            <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="returned" {{ ($status ?? '') === 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filter-payment" class="form-label small text-muted mb-1">Payment</label>
                        <select name="payment_status" id="filter-payment" class="form-select form-select-sm">
                            <option value="all" {{ ($paymentStatus ?? '') === 'all' || ($paymentStatus ?? '') === '' ? 'selected' : '' }}>All</option>
                            <option value="pending" {{ ($paymentStatus ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ ($paymentStatus ?? '') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ ($paymentStatus ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ ($paymentStatus ?? '') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter-search" class="form-label small text-muted mb-1">Search</label>
                        <input type="text" name="search" id="filter-search" class="form-control form-control-sm"
                               placeholder="Order #, customer, email..." value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-funnel me-1"></i> Apply
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
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
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->user ? $order->user->name : ($order->customer_name ?? 'Guest') }}</td>
                                    <td>{{ $order->user ? $order->user->email : ($order->customer_email ?? 'N/A') }}</td>
                                    <td><strong>${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge_class }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status_badge_class }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{{ route('admin.orders.show', $order) }}}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{{ route('admin.orders.edit', $order) }}}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{{ route('admin.orders.destroy', $order) }}}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this order?');">
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
                                        <p class="text-muted mb-0">No orders found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($orders->hasPages())
                <div class="card-footer-pagination">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

