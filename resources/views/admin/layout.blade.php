<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Ricimart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        :root {
            --primary-gradient: linear-gradient(135deg, #ff00cc, #3333ff);
            --secondary-gradient: linear-gradient(135deg, #00ffee, #ff00cc);
            --sidebar-gradient: linear-gradient(180deg, rgba(15, 15, 15, 0.98), rgba(15, 15, 15, 0.95));
            --card-shadow: 0 4px 15px rgba(0,0,0,0.3);
            --card-hover-shadow: 0 8px 25px rgba(0, 255, 238, 0.2);
        }
        
        body {
            background: #0f0f0f !important;
            color: white !important;
            overflow-x: hidden;
        }
        
        /* Animated Gradient Background */
        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff00cc, #3333ff, #00ffee, #ff0066);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            z-index: -1;
            filter: blur(120px);
            opacity: 0.3;
            top: 0;
            left: 0;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 4px 0 20px rgba(0,0,0,0.5);
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .sidebar .sidebar-nav-wrap {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 80px;
        }
        
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar { width: 6px; }
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 3px; }
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
        
        .sidebar h4, .sidebar h5 {
            font-weight: 700;
            letter-spacing: 0.5px;
            color: white !important;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 14px 20px;
            margin: 4px 0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #00ffee, #ff00cc);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #00ffee !important;
            transform: translateX(5px);
            padding-left: 25px;
        }
        
        .sidebar .nav-link:hover::before {
            transform: scaleY(1);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #00ffee !important;
            box-shadow: 0 4px 12px rgba(0, 255, 238, 0.2);
        }
        
        .sidebar .nav-link.active::before {
            transform: scaleY(1);
        }
        
        .sidebar .nav-link i {
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s ease;
        }
        
        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            color: #00ffee;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            border-radius: 16px;
            margin: 20px 20px 0 20px;
            padding: 15px 25px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #00ffee, #ff00cc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .navbar .text-muted {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        
        .main-content {
            padding: 30px;
            background: transparent;
        }
        
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        
        .card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-2px);
            border-color: rgba(0, 255, 238, 0.3) !important;
        }
        
        .card-header {
            background: linear-gradient(135deg, rgba(255, 0, 204, 0.2), rgba(51, 51, 255, 0.2)) !important;
            backdrop-filter: blur(10px);
            color: white !important;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 20px 25px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 25px;
            background: transparent;
            color: white !important;
        }
        
        .card-footer {
            background: rgba(255, 255, 255, 0.03) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }
        
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(255, 0, 204, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 0, 204, 0.5);
            color: white !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #00ffee, #00ccaa) !important;
            border: none !important;
            color: white !important;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff0066, #cc0044) !important;
            border: none !important;
            color: white !important;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffaa00, #ff8800) !important;
            border: none !important;
            color: white !important;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #00ccff, #0099cc) !important;
            border: none !important;
            color: white !important;
        }
        
        .btn-light {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        
        .btn-light:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
        }
        
        .btn-outline-danger {
            border-color: rgba(255, 0, 102, 0.5) !important;
            color: #ff0066 !important;
        }
        
        .btn-outline-danger:hover {
            background: linear-gradient(135deg, #ff0066, #cc0044) !important;
            border-color: transparent !important;
            color: white !important;
        }
        
        .table {
            border-radius: 12px;
            overflow: hidden;
            background: transparent;
        }
        
        .table thead {
            background: linear-gradient(135deg, rgba(255, 0, 204, 0.2), rgba(51, 51, 255, 0.2)) !important;
            backdrop-filter: blur(10px);
            color: white !important;
        }
        
        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: white !important;
        }
        
        .table tbody {
            background: transparent;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: white !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .badge.bg-danger {
            background: linear-gradient(135deg, #ff0066, #cc0044) !important;
        }
        
        .badge.bg-success {
            background: linear-gradient(135deg, #00ffee, #00ccaa) !important;
        }
        
        .badge.bg-primary {
            background: var(--primary-gradient) !important;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 10px 15px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: rgba(0, 255, 238, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(0, 255, 238, 0.1) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            color: white !important;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        .form-label {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
        }
        
        .alert {
            border-radius: 12px;
            border: 1px solid !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1) !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
            color: #86efac !important;
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
        }
        
        .alert-info {
            background: rgba(59, 130, 246, 0.1) !important;
            border-color: rgba(59, 130, 246, 0.3) !important;
            color: #93c5fd !important;
        }
        
        .btn-group .btn {
            margin: 0 2px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            border-radius: 8px;
        }
        
        code {
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 6px;
            color: #ff0066;
            font-size: 0.9em;
        }
        
        .pagination {
            margin-bottom: 0;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 4px;
        }
        
        .pagination .page-link {
            color: #00ffee;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            padding: 8px 14px;
            margin: 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .pagination .page-link:hover:not(.disabled):not([aria-disabled="true"]) {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 0, 204, 0.3);
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 12px rgba(255, 0, 204, 0.4);
        }
        
        .pagination .page-item.disabled .page-link,
        .pagination .page-link[aria-disabled="true"] {
            color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.02);
            border-color: rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .text-muted {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        
        .border-top {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .border-secondary {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* User Avatar */
        .bg-primary {
            background: var(--primary-gradient) !important;
        }
        
        .fw-semibold {
            color: white !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            
            .navbar {
                margin: 10px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3 pb-0">
                    <h5 class="text-white mb-0 small text-nowrap" style="background: linear-gradient(135deg, #00ffee, #ff00cc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">Ricimart Admin</h5>
                </div>
                <div class="sidebar-nav-wrap px-3">
                    <ul class="nav flex-column mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.alerts.*') ? 'active' : '' }}" href="{{ route('admin.alerts.index') }}">
                                <i class="bi bi-bell me-2"></i> Alerts
                                @if(isset($alertsCount) && $alertsCount > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">{{ $alertsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.main-categories.*') ? 'active' : '' }}" href="{{ route('admin.main-categories.index') }}">
                                <i class="bi bi-folder me-2"></i> Main Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-folder2 me-2"></i> Sub Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                <i class="bi bi-box-seam me-2"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" href="{{ route('admin.inventory.index') }}">
                                <i class="bi bi-boxes me-2"></i> Inventory
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-cart-check me-2"></i> Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                                <i class="bi bi-credit-card me-2"></i> Payments History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
                                <i class="bi bi-ticket-perforated me-2"></i> Coupons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                                <i class="bi bi-download me-2"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-2"></i> Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.policy-pages.*') ? 'active' : '' }}" href="{{ route('admin.policy-pages.index') }}">
                                <i class="bi bi-file-text me-2"></i> Policy Pages
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="p-3 pt-2 border-top flex-shrink-0">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light w-100 btn-sm">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <div>
                            <div class="navbar-brand mb-0 fw-bold" style="font-size: 1.25rem;">Admin Panel</div>
                            <div class="text-muted small">Control Center</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
                                    <div class="text-muted small">Administrator</div>
                                </div>
                            </div>
                            <form action="{{{ route('admin.logout') }}}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                <div class="main-content">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: invert(1);"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: invert(1);"></button>
                        </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: invert(1);"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
