@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Dashboard Overview</h4>
                <p class="text-muted mb-0">Welcome back! Here's what's happening with your store today.</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="reportsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download"></i> Download Reports
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="reportsDropdown">
                    <li><h6 class="dropdown-header">Reports</h6></li>
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard.reports.inventory') }}">
                        <i class="bi bi-box-seam"></i> Inventory
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard.reports.skus') }}">
                        <i class="bi bi-upc-scan"></i> SKUs
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard.reports.orders') }}">
                        <i class="bi bi-bag-check"></i> Orders
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard.reports.revenue') }}">
                        <i class="bi bi-currency-dollar"></i> Revenue
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard.reports.customers') }}">
                        <i class="bi bi-people"></i> Customers
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-collection"></i> All reports &amp; filters
                    </a></li>
                </ul>
            </div>
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
    <!-- Revenue Chart -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="card-title fw-bold mb-1">Revenue</h6>
                        <p class="text-muted small mb-0">Daily revenue trends</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="revenueFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="revenueFilterText">Last 7 Days</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="revenueFilter">
                            <li><a class="dropdown-item filter-option" href="#" data-days="7" data-chart="revenue">Last 7 Days</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-days="15" data-chart="revenue">Last 15 Days</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-days="30" data-chart="revenue">Last 30 Days</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item filter-option-custom" href="#" data-chart="revenue">Custom Date Range</a></li>
                        </ul>
                    </div>
                </div>
                <div id="revenueCustomDateRange" class="mb-2" style="display: none;">
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="date" class="form-control form-control-sm" id="revenueStartDate" placeholder="Start Date">
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-sm" id="revenueEndDate" placeholder="End Date">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary mt-2 w-100" onclick="applyCustomDateRange('revenue')">Apply</button>
                </div>
                <div style="position: relative; height: 200px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Chart -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="card-title fw-bold mb-1">Orders</h6>
                        <p class="text-muted small mb-0">Daily order count</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="ordersFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="ordersFilterText">Last 7 Days</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="ordersFilter">
                            <li><a class="dropdown-item filter-option" href="#" data-days="7" data-chart="orders">Last 7 Days</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-days="15" data-chart="orders">Last 15 Days</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-days="30" data-chart="orders">Last 30 Days</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item filter-option-custom" href="#" data-chart="orders">Custom Date Range</a></li>
                        </ul>
                    </div>
                </div>
                <div id="ordersCustomDateRange" class="mb-2" style="display: none;">
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="date" class="form-control form-control-sm" id="ordersStartDate" placeholder="Start Date">
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-sm" id="ordersEndDate" placeholder="End Date">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary mt-2 w-100" onclick="applyCustomDateRange('orders')">Apply</button>
                </div>
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
let revenueChart = null;
let ordersChart = null;
let statusChart = null;

// Function to create or update revenue chart
function updateRevenueChart(data) {
    const revenueCtx = document.getElementById('revenueChart');
    if (!revenueCtx) return;
    
    const maxRevenue = Math.max(...data.map(d => d.revenue), 1);
    const stepSize = maxRevenue > 0 ? Math.ceil(maxRevenue / 5) : 1;
    
    const config = {
        type: 'line',
        data: {
            labels: data.map(d => d.date),
            datasets: [{
                label: 'Revenue',
                data: data.map(d => parseFloat(d.revenue) || 0),
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
    };
    
    if (revenueChart) {
        revenueChart.data.labels = config.data.labels;
        revenueChart.data.datasets[0].data = config.data.datasets[0].data;
        revenueChart.update();
    } else {
        revenueChart = new Chart(revenueCtx, config);
    }
}

// Function to create or update orders chart
function updateOrdersChart(data) {
    const ordersCtx = document.getElementById('ordersChart');
    if (!ordersCtx) return;
    
    const maxOrders = Math.max(...data.map(d => d.orders), 1);
    
    const config = {
        type: 'bar',
        data: {
            labels: data.map(d => d.date),
            datasets: [{
                label: 'Orders',
                data: data.map(d => parseInt(d.orders) || 0),
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
    };
    
    if (ordersChart) {
        ordersChart.data.labels = config.data.labels;
        ordersChart.data.datasets[0].data = config.data.datasets[0].data;
        ordersChart.update();
    } else {
        ordersChart = new Chart(ordersCtx, config);
    }
}

// Function to fetch chart data
function fetchChartData(days = null, startDate = null, endDate = null, chartType = 'both') {
    const url = '{{ route("admin.dashboard.chart-data") }}';
    const params = new URLSearchParams();
    
    if (days) {
        params.append('days', days);
    } else if (startDate && endDate) {
        params.append('start_date', startDate);
        params.append('end_date', endDate);
    } else {
        params.append('days', 7);
    }
    
    fetch(url + '?' + params.toString(), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (chartType === 'revenue' || chartType === 'both') {
                updateRevenueChart(data.data);
            }
            if (chartType === 'orders' || chartType === 'both') {
                updateOrdersChart(data.data);
            }
        }
    })
    .catch(error => {
        console.error('Error fetching chart data:', error);
    });
}

// Function to apply custom date range
function applyCustomDateRange(chartType) {
    const startDateInput = document.getElementById(chartType + 'StartDate');
    const endDateInput = document.getElementById(chartType + 'EndDate');
    
    if (!startDateInput.value || !endDateInput.value) {
        alert('Please select both start and end dates');
        return;
    }
    
    if (new Date(startDateInput.value) > new Date(endDateInput.value)) {
        alert('Start date must be before end date');
        return;
    }
    
    fetchChartData(null, startDateInput.value, endDateInput.value, chartType);
    
    // Update filter text
    const filterText = document.getElementById(chartType + 'FilterText');
    const startDate = new Date(startDateInput.value).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    const endDate = new Date(endDateInput.value).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    filterText.textContent = startDate + ' - ' + endDate;
    
    // Hide custom date range
    document.getElementById(chartType + 'CustomDateRange').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts with default data (last 7 days)
    const revenueData = @json($last7Days);
    updateRevenueChart(revenueData);
    
    const ordersData = @json($last7Days);
    updateOrdersChart(ordersData);
    
    // Event listeners for filter dropdowns
    document.querySelectorAll('.filter-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const days = this.getAttribute('data-days');
            const chartType = this.getAttribute('data-chart');
            const filterText = document.getElementById(chartType + 'FilterText');
            
            // Update filter text
            if (days == 7) {
                filterText.textContent = 'Last 7 Days';
            } else if (days == 15) {
                filterText.textContent = 'Last 15 Days';
            } else if (days == 30) {
                filterText.textContent = 'Last 30 Days';
            }
            
            // Hide custom date range if visible
            document.getElementById(chartType + 'CustomDateRange').style.display = 'none';
            
            // Fetch and update chart data
            fetchChartData(days, null, null, chartType);
        });
    });
    
    // Event listeners for custom date range option
    document.querySelectorAll('.filter-option-custom').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const chartType = this.getAttribute('data-chart');
            const customDateRange = document.getElementById(chartType + 'CustomDateRange');
            
            // Toggle custom date range visibility
            if (customDateRange.style.display === 'none') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    });

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
            statusChart = new Chart(statusCtx, {
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
