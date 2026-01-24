@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order Details: ' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="200">Order Number</th>
                        <td><strong>{{ $order->order_number }}</strong></td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    @if($order->customer_phone)
                    <tr>
                        <th>Phone</th>
                        <td>{{ $order->customer_phone }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $order->status_badge_class }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td>
                            <span class="badge bg-{{ $order->payment_status_badge_class }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @if($order->payment_method)
                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Subtotal</th>
                        <td>${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Tax</th>
                        <td>${{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Shipping</th>
                        <td>${{ number_format($order->shipping, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Billing Address</h5>
            </div>
            <div class="card-body">
                <pre style="white-space: pre-wrap; font-family: inherit;">{{ $order->billing_address }}</pre>
            </div>
        </div>

        @if($order->shipping_address)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <pre style="white-space: pre-wrap; font-family: inherit;">{{ $order->shipping_address }}</pre>
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_sku ?? '—' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Notes</h5>
            </div>
            <div class="card-body">
                <p>{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-between">
            <a href="{{{ route('admin.orders.index') }}}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
            <a href="{{{ route('admin.orders.edit', $order) }}}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Order
            </a>
        </div>
    </div>
</div>
@endsection

