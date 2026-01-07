<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        View::composer('frontend.layouts.layout', function ($view) {
            $productService = app(ProductService::class);

            $view->with([
                'navBrands'     => $productService->navbarBrands(),
                'navCategories' => $productService->navbarCategories(),
                'popularCloths' => $productService->popularCloths(6),
            ]);
            
        });
         // Share fiscal years globally to all views
     // Example: share fiscal years globally
        $theFiscalYears = DB::table('fiscal_years')
            ->orderBy('start_date', 'desc')
            ->get();

        View::share('theFiscalYears', $theFiscalYears);
    }
}
