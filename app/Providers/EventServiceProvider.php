<?php

namespace App\Providers;

use App\Events\SaleCreated;
use App\Listeners\UpdateStockAndTotal;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

     protected $listen = [
        SaleCreated::class => [
            UpdateStockAndTotal::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }

   
}
