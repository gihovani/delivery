<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\VariationObserver;
use App\Order;
use App\Product;
use App\Variation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        Product::observe(ProductObserver::class);
        Variation::observe(VariationObserver::class);
    }
}
