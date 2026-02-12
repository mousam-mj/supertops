<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load currency helper functions
        if (file_exists($helperPath = app_path('Helpers/CurrencyHelper.php'))) {
            require_once $helperPath;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share alerts count with all views
        view()->composer('admin.layout', function ($view) {
            $lowStockCount = \App\Models\Product::where('stock_quantity', '<', 10)
                ->where('is_active', true)
                ->count();
            $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
            $alertsCount = $lowStockCount + $pendingOrdersCount;
            
            $view->with('alertsCount', $alertsCount);
        });
    }
}
