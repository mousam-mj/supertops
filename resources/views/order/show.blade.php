@extends('layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
@php
    $getImageUrl = function($path) {
        if (!$path) return asset('assets/images/product/perch-bottal.webp');
        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
            return asset($path);
        }
        return asset('storage/' . $path);
    };
    $totalAmount = $order->total_amount ?? $order->total ?? 0;
    $subtotal = $order->subtotal ?? ($order->items->sum('total') ?: $totalAmount);
    $shippingCharge = $order->shipping_charge ?? $order->shipping ?? 0;
    $statusColors = [
        'pending' => 'bg-yellow text-yellow',
        'processing' => 'bg-purple text-purple',
        'shipped' => 'bg-purple text-purple',
        'delivered' => 'bg-success text-success',
        'completed' => 'bg-success text-success',
        'cancelled' => 'bg-red text-red',
        'canceled' => 'bg-red text-red',
    ];
    $statusColor = $statusColors[strtolower($order->status)] ?? 'bg-secondary text-secondary';
@endphp
<div class="order-details-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('my-account') }}?tab=orders" class="inline-flex items-center gap-2 text-secondary hover:text-black body2">
                    <i class="ph ph-arrow-left"></i> Back to My Account
                </a>
            </div>
            <div class="bg-white border border-line rounded-2xl p-8 md:p-12">
                <h1 class="heading2 md:heading1 mb-2">Order Details</h1>
                <p class="body2 text-secondary mb-6">Order {{ $order->order_number }}</p>
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <div class="caption1 text-secondary mb-1">Order Number</div>
                        <div class="body1 font-semibold">{{ $order->order_number }}</div>
                    </div>
                    <div>
                        <div class="caption1 text-secondary mb-1">Order Date</div>
                        <div class="body1 font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div>
                        <div class="caption1 text-secondary mb-1">Status</div>
                        <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 {{ $statusColor }} caption1 font-semibold">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div>
                        <div class="caption1 text-secondary mb-1">Payment</div>
                        <div class="body1 font-semibold capitalize">{{ $order->payment_method ?? '—' }}</div>
                    </div>
                </div>
                <div class="border-t border-line pt-6">
                    <h2 class="heading6 mb-4">Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            @php
                                $product = $item->product;
                                $productImage = $product ? $getImageUrl($product->image ?? null) : asset('assets/images/product/perch-bottal.webp');
                                $productName = $item->product_name ?? ($product ? $product->name : 'Product');
                                $productSlug = $product ? $product->slug : '#';
                                $itemPrice = $item->price ?? 0;
                                $itemTotal = $item->total ?? ($itemPrice * $item->quantity);
                            @endphp
                            <div class="flex flex-wrap items-center justify-between gap-4 py-4 {{ !$loop->last ? 'border-b border-line' : '' }}">
                                <a href="{{ route('product.show', $productSlug) }}" class="flex items-center gap-4">
                                    <div class="bg-img w-20 h-20 md:w-24 md:h-24 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ $productImage }}" alt="{{ $productName }}" class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <div class="body1 font-semibold text-title">{{ $productName }}</div>
                                        @if($item->size || $item->color)
                                            <div class="caption1 text-secondary mt-1">
                                                @if($item->size)<span class="uppercase">{{ $item->size }}</span>@endif
                                                @if($item->size && $item->color)<span> / </span>@endif
                                                @if($item->color)<span class="capitalize">{{ $item->color }}</span>@endif
                                            </div>
                                        @endif
                                        <div class="caption1 text-secondary mt-1">Qty: {{ $item->quantity }} × ₹{{ number_format((float) $itemPrice, 2) }}</div>
                                    </div>
                                </a>
                                <div class="body1 font-semibold">₹{{ number_format((float) $itemTotal, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="border-t border-line pt-6 mt-6">
                    <div class="caption1 text-secondary mb-2">Amount breakdown</div>
                    <div class="space-y-2 body2">
                        <div class="flex justify-between"><span>Subtotal</span><span>₹{{ number_format((float) $subtotal, 2) }}</span></div>
                        @if($shippingCharge > 0)
                            <div class="flex justify-between"><span>Shipping</span><span>₹{{ number_format((float) $shippingCharge, 2) }}</span></div>
                        @endif
                        <div class="flex justify-between font-semibold pt-2 border-t border-line mt-2"><span>Total</span><span>₹{{ number_format((float) $totalAmount, 2) }}</span></div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="{{ route('my-account') }}?tab=orders" class="button-secondary">
                        Back to My Orders
                    </a>
                    <a href="{{ route('home') }}" class="button-main">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
