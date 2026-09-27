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
                                <th>Color</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Delivery Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    $colors = $order->items->pluck('color')->filter()->unique()->values();
                                    $sizes = $order->items->pluck('size')->filter()->unique()->values();
                                @endphp
                                <tr>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->user ? $order->user->name : ($order->customer_name ?? 'Guest') }}</td>
                                    <td>{{ $order->user ? $order->user->email : ($order->customer_email ?? 'N/A') }}</td>
                                    <td><strong>{{ currency($order->total_amount ?? $order->total ?? 0) }}</strong></td>
                                    <td>{{ $colors->isNotEmpty() ? $colors->implode(', ') : '—' }}</td>
                                    <td>{{ $sizes->isNotEmpty() ? $sizes->implode(', ') : '—' }}</td>
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
                                    <td>
                                        @if($order->shiprocket_awb)
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">AWB: {{ $order->shiprocket_awb }}</small>
                                                <button class="btn btn-xs btn-outline-info mt-1" onclick="trackOrder({{ $order->id }}, 'shiprocket')">
                                                    <i class="bi bi-geo-alt"></i> Track
                                                </button>
                                            </div>
                                        @elseif($order->delhivery_waybill)
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">Waybill: {{ $order->delhivery_waybill }}</small>
                                                <button class="btn btn-xs btn-outline-info mt-1" onclick="trackOrder({{ $order->id }}, 'delhivery')">
                                                    <i class="bi bi-geo-alt"></i> Track
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">Not shipped</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
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
                                            </div>
                                            <div class="btn-group mt-1" role="group">
                                                @if(!$order->shiprocket_awb && !$order->delhivery_waybill && $order->status !== 'cancelled')
                                                    <button class="btn btn-sm btn-outline-success" 
                                                            onclick="createShipment({{ $order->id }})" 
                                                            title="Create Shipment">
                                                        <i class="bi bi-truck"></i>
                                                    </button>
                                                @endif
                                                @if($order->status !== 'cancelled' && $order->status !== 'delivered')
                                                    <button class="btn btn-sm btn-outline-warning" 
                                                            onclick="cancelOrder({{ $order->id }})" 
                                                            title="Cancel Order">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                @endif
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
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

@push('scripts')
<script>
// Track order function
function trackOrder(orderId, provider) {
    const url = provider === 'shiprocket'
        ? `/admin/orders/${orderId}/shiprocket/track`
        : `/api/admin/orders/${orderId}/${provider}/track`;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show tracking information in modal
            showTrackingModal(data.data);
        } else {
            alert('Failed to fetch tracking information: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error fetching tracking information');
    });
}

function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function (char) {
        return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[char];
    });
}

function shipmentSteps(data) {
    if (Array.isArray(data.steps) && data.steps.length) {
        return data.steps;
    }

    const reason = String(data.reason || data.message || '').toLowerCase();
    if (reason.includes('access forbidden') || reason.includes('api user') || reason.includes('blocked this login')) {
        return [
            'In Shiprocket open Settings → API → Create API User. Use an email different from the panel login.',
            'Put that API email and password in the server .env as SHIPROCKET_EMAIL and SHIPROCKET_PASSWORD.',
            'On the server run php artisan config:clear, then click the truck icon again.'
        ];
    }

    return [
        'Read the reason below. That is what the server or Shiprocket returned.',
        'Fix the field it names, then click the truck icon again.'
    ];
}

function showShipmentResult(data) {
    const status = data.status || (data.success ? 'success' : 'failed');
    const colors = {
        success: 'success',
        already_sent: 'warning',
        working: 'info',
        failed: 'danger'
    };
    const titles = {
        success: 'Success',
        already_sent: 'Already sent',
        working: 'Working',
        failed: 'Failed'
    };
    const title = titles[status] || 'Failed';
    const color = colors[status] || 'danger';
    const steps = shipmentSteps(data).map(function (step, index) {
        return '<li class="mb-1">' + escapeHtml(step) + '</li>';
    }).join('');
    const ids = data.data || {};
    const detailLines = [
        data.order_number ? 'Order: ' + data.order_number : '',
        ids.shiprocket_order_id ? 'Shiprocket order id: ' + ids.shiprocket_order_id : '',
        ids.shiprocket_shipment_id ? 'Shipment id: ' + ids.shiprocket_shipment_id : '',
        ids.shiprocket_awb ? 'AWB: ' + ids.shiprocket_awb : ''
    ].filter(Boolean);

    const existing = document.getElementById('shipmentResultModal');
    if (existing) {
        const instance = bootstrap.Modal.getInstance(existing);
        if (instance) instance.dispose();
        existing.remove();
        document.querySelectorAll('.modal-backdrop').forEach(function (el) { el.remove(); });
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');
    }

    const reloadButton = status === 'success'
        ? '<button type="button" class="btn btn-primary" onclick="location.reload()">Reload orders</button>'
        : '';

    document.body.insertAdjacentHTML('beforeend', `
        <div class="modal fade" id="shipmentResultModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create shipment: ${escapeHtml(title)}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-${color} mb-3">
                            <strong>${escapeHtml(title)}.</strong> ${escapeHtml(data.message || '')}
                        </div>
                        <p class="mb-1"><strong>Reason</strong></p>
                        <p>${escapeHtml(data.reason || data.message || 'No reason returned.')}</p>
                        <p class="mb-1"><strong>${status === 'failed' ? 'Steps to fix' : 'What to do next'}</strong></p>
                        <ol class="mb-3">${steps}</ol>
                        ${detailLines.length ? '<p class="mb-1"><strong>Details</strong></p><pre class="bg-light border rounded p-2 mb-0 small">' + escapeHtml(detailLines.join('\n')) + '</pre>' : ''}
                    </div>
                    <div class="modal-footer">
                        ${reloadButton}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `);

    new bootstrap.Modal(document.getElementById('shipmentResultModal')).show();
}

function createShipment(orderId) {
    if (!confirm('Create shipment for this order?')) return;

    const token = csrfToken();
    if (!token) {
        showShipmentResult({
            success: false,
            status: 'failed',
            message: 'Shipment was not created.',
            reason: 'This admin page has no CSRF token, so the request was blocked before it started.',
            steps: [
                'Hard refresh this page (Cmd+Shift+R).',
                'If it still fails, deploy the latest admin layout and run php artisan view:clear on the server.'
            ]
        });
        return;
    }

    const button = document.querySelector('button[onclick="createShipment(' + orderId + ')"]');
    if (button) {
        button.disabled = true;
    }

    showShipmentResult({
        status: 'working',
        message: 'Creating shipment. Please wait.',
        reason: 'The order is being sent to Shiprocket.',
        steps: ['Leave this box open. The result will replace this message.']
    });

    fetch('/admin/orders/' + orderId + '/shiprocket/create-shipment', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        }
    })
    .then(async function (response) {
        const text = await response.text();
        let data;
        try {
            data = JSON.parse(text);
        } catch (error) {
            data = {
                success: false,
                status: 'failed',
                message: 'Shipment was not created.',
                reason: response.status + ' ' + response.statusText + '. The server did not return a result.',
                steps: [
                    'Refresh the admin orders page and try the truck icon again.',
                    'If this keeps happening, the create-shipment update is not deployed on perchlife.in yet.'
                ]
            };
        }
        if (!data.status) {
            data.status = data.success ? 'success' : 'failed';
        }
        showShipmentResult(data);
    })
    .catch(function (error) {
        showShipmentResult({
            success: false,
            status: 'failed',
            message: 'Shipment was not created.',
            reason: error && error.message ? error.message : 'The request did not reach the server.',
            steps: [
                'Check that you are still logged in to the admin panel.',
                'Refresh the page and click the truck icon again.'
            ]
        });
    })
    .finally(function () {
        if (button) {
            button.disabled = false;
        }
    });
}

// Cancel order function
function cancelOrder(orderId) {
    if (!confirm('Are you sure you want to cancel this order? This action cannot be undone.')) return;
    
    const url = `/api/admin/orders/${orderId}/cancel`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order cancelled successfully!');
            location.reload();
        } else {
            alert('Failed to cancel order: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error cancelling order');
    });
}

// Show tracking modal
function showTrackingModal(trackingData) {
    let modalHtml = `
        <div class="modal fade" id="trackingModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Tracking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>AWB/Waybill:</strong> ${trackingData.awb || trackingData.waybill || 'N/A'}
                            </div>
                            <div class="col-md-6">
                                <strong>Current Status:</strong> ${trackingData.current_status || 'Unknown'}
                            </div>
                        </div>
                        <hr>
                        <div class="tracking-timeline">
                            <h6>Tracking History:</h6>
    `;
    
    if (trackingData.tracking_data && trackingData.tracking_data.length > 0) {
        trackingData.tracking_data.forEach(track => {
            modalHtml += `
                <div class="timeline-item mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted">${track.date || track.timestamp || ''}</small>
                        </div>
                        <div class="col-md-9">
                            <strong>${track.status || track.activity || ''}</strong><br>
                            <small>${track.location || track.remarks || ''}</small>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        modalHtml += '<p class="text-muted">No tracking information available.</p>';
    }
    
    modalHtml += `
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('trackingModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('trackingModal'));
    modal.show();
}
</script>
@endpush

