<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_number }} — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 24px;
            background: #1a1a1e;
            color: #e8e8ec;
            line-height: 1.5;
        }
        .invoice-wrap {
            max-width: 800px;
            margin: 0 auto;
            background: #25252b;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 32px;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(0, 255, 238, 0.25);
        }
        .brand { font-size: 1.5rem; font-weight: 700; color: #00ffee; }
        .invoice-meta { text-align: right; font-size: 0.9rem; color: #aaa; }
        .invoice-meta strong { color: #fff; display: block; font-size: 1.1rem; margin-bottom: 4px; }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }
        @media (max-width: 600px) { .grid-2 { grid-template-columns: 1fr; } }
        .block h3 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #888;
            margin: 0 0 10px 0;
        }
        .block p { margin: 0; white-space: pre-wrap; font-size: 0.95rem; }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        table.items th {
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
        }
        table.items td {
            padding: 12px 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        table.items td.num { text-align: right; }
        .totals {
            max-width: 280px;
            margin-left: auto;
            font-size: 0.95rem;
        }
        .totals tr td { padding: 6px 0; }
        .totals tr td:last-child { text-align: right; font-weight: 600; }
        .totals .grand td {
            padding-top: 12px;
            margin-top: 8px;
            border-top: 2px solid #00ffee;
            font-size: 1.15rem;
            color: #00ffee;
        }
        .no-print {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-primary { background: linear-gradient(45deg, #00ffee, #0099cc); color: #0a0a0a; }
        .btn-outline { background: transparent; color: #aaa; border: 1px solid rgba(255,255,255,0.2); }
        .btn-outline:hover { color: #fff; border-color: #00ffee; }
        .footer-note { margin-top: 28px; font-size: 0.8rem; color: #666; text-align: center; }
        @media print {
            body { background: #fff; color: #111; padding: 0; }
            .invoice-wrap {
                background: #fff;
                border: none;
                border-radius: 0;
                padding: 0;
                max-width: 100%;
            }
            .brand { color: #0a6b6b; }
            .invoice-meta { color: #444; }
            .invoice-meta strong { color: #000; }
            .block h3 { color: #555; }
            table.items th { color: #555; border-color: #ccc; }
            table.items td { border-color: #eee; }
            .totals .grand td { border-color: #0a6b6b; color: #0a6b6b; }
            .no-print { display: none !important; }
            .footer-note { color: #888; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Print / Save PDF
        </button>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline">
            <i class="bi bi-arrow-left"></i> Back to order
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">
            <i class="bi bi-list-ul"></i> All orders
        </a>
    </div>

    <div class="invoice-wrap">
        <div class="header-row">
            <div>
                <div class="brand">{{ config('app.name') }}</div>
                <div style="color:#888;font-size:0.85rem;margin-top:6px;">Tax invoice / Order summary</div>
            </div>
            <div class="invoice-meta">
                <strong>Invoice</strong>
                {{ $order->order_number }}<br>
                Date: {{ $order->created_at->format('M d, Y') }}<br>
                @if($order->payment_method)
                    Payment: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}<br>
                @endif
                Status: {{ ucfirst($order->status) }} · {{ ucfirst($order->payment_status ?? 'pending') }}
            </div>
        </div>

        <div class="grid-2">
            <div class="block">
                <h3>Bill to</h3>
                <p>{{ $order->formattedBillingAddress() ?: ($order->user ? trim($order->user->name . "\n" . $order->user->email) : '—') }}</p>
            </div>
            <div class="block">
                <h3>Ship to</h3>
                <p>{{ $order->formattedShippingAddress() ?: $order->formattedBillingAddress() ?: '—' }}</p>
            </div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>SKU</th>
                    <th class="num">Qty</th>
                    <th class="num">Price</th>
                    <th class="num">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name ?? $item->product?->name ?? 'Product' }}</td>
                        <td>{{ $item->product_sku ?? '—' }}</td>
                        <td class="num">{{ $item->quantity }}</td>
                        <td class="num">{{ currency($item->price) }}</td>
                        <td class="num">{{ currency($item->total ?? ($item->price * $item->quantity)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $subtotal = $order->subtotal;
            if ($subtotal === null || $subtotal == 0) {
                $subtotal = $order->items->sum(fn ($i) => (float) ($i->total ?? ($i->price * $i->quantity)));
            }
            $tax = (float) ($order->tax ?? 0);
            $shipping = (float) ($order->shipping_charge ?? $order->shipping ?? 0);
            $discount = (float) ($order->coupon_discount ?? 0);
            $grand = (float) ($order->total_amount ?? $order->total ?? ($subtotal + $tax + $shipping - $discount));
        @endphp

        <table class="totals">
            <tr>
                <td>Subtotal</td>
                <td>{{ currency($subtotal) }}</td>
            </tr>
            @if($tax > 0)
                <tr>
                    <td>Tax</td>
                    <td>{{ currency($tax) }}</td>
                </tr>
            @endif
            @if($shipping > 0)
                <tr>
                    <td>Shipping</td>
                    <td>{{ currency($shipping) }}</td>
                </tr>
            @endif
            @if($discount > 0)
                <tr>
                    <td>Discount</td>
                    <td>−{{ currency($discount) }}</td>
                </tr>
            @endif
            <tr class="grand">
                <td>Total</td>
                <td>{{ currency($grand) }}</td>
            </tr>
        </table>

        @if($order->razorpay_payment_id)
            <p class="footer-note" style="margin-top:16px;text-align:left;">
                Payment ref: {{ $order->razorpay_payment_id }}
            </p>
        @endif

        @if($order->notes)
            <div class="block" style="margin-top:20px;">
                <h3>Notes</h3>
                <p>{{ $order->notes }}</p>
            </div>
        @endif

        <p class="footer-note">This document was generated from the admin panel for internal / customer records.</p>
    </div>
</body>
</html>
