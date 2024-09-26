<?php

namespace App\Providers;

use App\Repositories\contacts\ReadContactInterface;
use App\Services\contacts\ReadContactService;
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
        $this->app->bind(ReadContactInterface::class, ReadContactService::class);
    }
}
