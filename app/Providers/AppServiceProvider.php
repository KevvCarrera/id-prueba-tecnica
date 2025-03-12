<?php

namespace App\Providers;

use App\Events\SaleCreated;
use App\Services\SaleService;
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use App\Listeners\UpdateStockAndTotal;
use App\Services\SaleServiceInterface;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SaleRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(SaleServiceInterface::class, SaleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
