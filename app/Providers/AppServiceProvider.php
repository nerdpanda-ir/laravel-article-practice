<?php

namespace App\Providers;

use App\Services\RegisterShowExecutedQueryListenerProxy;
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
    public function boot(RegisterShowExecutedQueryListenerProxy $registerShowExecutedQueryListener): void
    {
        $registerShowExecutedQueryListener->register();
    }
}
