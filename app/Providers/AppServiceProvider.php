<?php

namespace App\Providers;

use App\Services\CommerceToolsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CommerceToolsService::class, function (Application $app) {
            return new CommerceToolsService(
                config('services.commercetools.client_id'),
                config('services.commercetools.client_secret'),
                config('services.commercetools.scope'),
                config('services.commercetools.region'),
                config('services.commercetools.project_key')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
