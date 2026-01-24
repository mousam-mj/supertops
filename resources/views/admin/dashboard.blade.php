@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">Dashboard Overview</h4>
            <p class="text-muted mb-0">Welcome back! Here's what's happening with your store today.</p>
        </div>
    </div>
</div>

<!-- Key Metric Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">Total sales</div>
                        <h3 class="mb-0 fw-bold">₹{{ number_format($stats['total_revenue'], 0) }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">Total order</div>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_orders'] }}</h3>
                        <div class="text-white-50 small mt-1">{{ $stats['today_orders'] }} today</div>
                    </div>
                    <div style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="bi bi-bag-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">Total items</div>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_products'] }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="bi bi-cube"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">Registered users</div>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_customers'] }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row">
    <!-- Revenue Chart (Last 7 Days) -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-1">Revenue (Last 7 Days)</h6>
                <p class="text-muted small mb-3">Daily revenue trends</p>
                <div style="position: relative; height: 200px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Chart (Last 7 Days) -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-1">Orders (Last 7 Days)</h6>
                <p class="text-muted small mb-3">Daily order count</p>
                <div style="position: relative; height: 200px;">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders by Status Chart -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-1">Orders by Status</h6>
                <p class="text-muted small mb-3">Order status distribution</p>
                <div style="position: relative; height: 200px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders and Products -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
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
                                    <td><a href="{{{ route('admin.orders.show', $order) }}}">{{ $order->order_number ?? 'N/A' }}</a></td>
                                    <td>{{ $order->customer_name ?? 'Guest' }}</td>
                                    <td>₹{{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</td>
                                    <td><span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }}">{{ ucfirst($order->status ?? 'Pending') }}</span></td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{{ route('admin.orders.index') }}}" class="btn btn-sm btn-outline-primary mt-2">View All Orders</a>
                @else
                    <p class="text-muted mb-0">No orders yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
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
                                    <td><a href="{{{ route('admin.products.show', $product) }}}">{{ $product->name }}</a></td>
                                    <td>₹{{ number_format($product->sale_price ?? $product->price ?? 0, 2) }}</td>
                                    <td>{{ $product->stock_quantity ?? 0 }}</td>
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
                    <a href="{{{ route('admin.products.index') }}}" class="btn btn-sm btn-outline-primary mt-2">View All Products</a>
                @else
                    <p class="text-muted mb-0">No products yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart (Line Chart)
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = @json($last7Days);
        const maxRevenue = Math.max(...revenueData.map(d => d.revenue), 1);
        const stepSize = maxRevenue > 0 ? Math.ceil(maxRevenue / 5) : 1;
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(d => d.date),
                datasets: [{
                    label: 'Revenue',
                    data: revenueData.map(d => parseFloat(d.revenue) || 0),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₹' + parseFloat(context.parsed.y).toLocaleString('en-IN');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: stepSize,
                            callback: function(value) {
                                return '₹' + value.toLocaleString('en-IN');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Orders Chart (Bar Chart)
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        const ordersData = @json($last7Days);
        const maxOrders = Math.max(...ordersData.map(d => d.orders), 1);
        
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ordersData.map(d => d.date),
                datasets: [{
                    label: 'Orders',
                    data: ordersData.map(d => parseInt(d.orders) || 0),
                    backgroundColor: '#3b82f6',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' order' + (context.parsed.y !== 1 ? 's' : '');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Orders by Status Chart (Doughnut Chart)
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($ordersByStatus);
        const statusLabels = Object.keys(statusData);
        const statusValues = Object.values(statusData).map(v => parseInt(v) || 0);
        const totalOrders = statusValues.reduce((a, b) => a + b, 0);
        const colors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444'];
        
        // Only show statuses that have orders
        const filteredData = statusLabels.map((label, index) => ({
            label: label.charAt(0).toUpperCase() + label.slice(1),
            value: statusValues[index],
            color: colors[index]
        })).filter(item => item.value > 0);
        
        if (filteredData.length > 0) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: filteredData.map(d => d.label),
                    datasets: [{
                        data: filteredData.map(d => d.value),
                        backgroundColor: filteredData.map(d => d.color),
                        borderWidth: 0,
                        cutout: '60%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                                font: {
                                    size: 11
                                },
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const percentage = totalOrders > 0 ? ((value / totalOrders) * 100).toFixed(1) : 0;
                                    return label + ': ' + value + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        } else {
            // Create a chart with "No data" message
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['No Orders'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['#e5e7eb'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    }
                },
                plugins: [{
                    id: 'emptyState',
                    afterDraw: function(chart) {
                        const ctx = chart.ctx;
                        const width = chart.width;
                        const height = chart.height;
                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#9ca3af';
                        ctx.fillText('No orders yet', width / 2, height / 2);
                        ctx.restore();
                    }
                }]
            });
        }
    }
});
</script>
@endpush
