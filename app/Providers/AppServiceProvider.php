<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator ;
use App\Services\PaystackService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');
    }

    public function register()
    {
        $this->app->singleton(PaystackService::class, function ($app) {
            return new PaystackService();
        });
    }

}
