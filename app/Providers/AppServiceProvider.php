<?php

namespace App\Providers;

use App\Events\SaleCreated;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use App\Listeners\UpdateStockAndTotal;
use Illuminate\Support\ServiceProvider;


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
        Event::listen(
            SaleCreated::class,
            UpdateStockAndTotal::class
        );

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
