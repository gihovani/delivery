<?php

namespace App\Providers;

use App\Address;
use App\Observers\AddressObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\VariationObserver;
use App\Order;
use App\Product;
use App\User;
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
        Address::observe(AddressObserver::class);
        Product::observe(ProductObserver::class);
        Variation::observe(VariationObserver::class);

        \Blade::if('admin', function () {
            return auth()->check() && auth()->user()->hasRole(User::ROLE_ADMIN);
        });
    }
}
