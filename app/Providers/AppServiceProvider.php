<?php

namespace App\Providers;

use App\Observers\ProductObserver;
use App\Observers\VariationObserver;
use App\Product;
use App\Variation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        Variation::observe(VariationObserver::class);
    }
}
