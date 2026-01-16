<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Calculate today's date range for "today" stats
        $today = now()->startOfDay();
        
        // Revenue stats - use total_amount if available, otherwise total
        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum(DB::raw('COALESCE(total_amount, total, 0)')) ?? 0;
        $todayRevenue = Order::where('payment_status', 'paid')
            ->whereDate('created_at', $today)
            ->sum(DB::raw('COALESCE(total_amount, total, 0)')) ?? 0;
        
        // Orders stats
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', $today)->count();
        
        // Products stats
        $totalProducts = Product::count();
        
        // Customers stats
        $totalCustomers = User::where('is_admin', false)->orWhereNull('is_admin')->count();
        
        // Get last 7 days data for charts
        $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo)->startOfDay();
            return [
                'date' => $date->format('M d'),
                'date_full' => $date->format('Y-m-d'),
                'revenue' => Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum(DB::raw('COALESCE(total_amount, total, 0)')) ?? 0,
                'orders' => Order::whereDate('created_at', $date)->count(),
            ];
        });
        
        // Orders by status
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        // Alerts count (low stock + pending orders)
        $lowStockCount = Product::where('stock_quantity', '<', 10)
            ->where('is_active', true)
            ->count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $alertsCount = $lowStockCount + $pendingOrdersCount;

        $stats = [
            'total_revenue' => $totalRevenue,
            'today_revenue' => $todayRevenue,
            'total_orders' => $totalOrders,
            'today_orders' => $todayOrders,
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
            'alerts_count' => $alertsCount,
        ];

        $recent_orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $top_products = Product::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recent_orders', 
            'top_products', 
            'last7Days', 
            'ordersByStatus'
        ));
    }
}
