<?php

namespace App\Providers;

use App\Repositories\addresses\ReadAddressInterface;
use App\Repositories\addresses\WriteAddressInterface;
use App\Repositories\contacts\ReadContactInterface;
use App\Repositories\contacts\WriteContactInterface;
use App\Repositories\emails\ReadEmailInterface;
use App\Repositories\emails\WriteEmailInterface;
use App\Repositories\phoneNumbers\ReadPhoneNumberInterface;
use App\Repositories\phoneNumbers\WritePhoneNumberInterface;
use App\Services\addresses\ReadAddressService;
use App\Services\contacts\ReadContactService;
use App\Services\addresses\WriteAddressService;
use App\Services\contacts\WriteContactService;
use App\Services\emails\ReadEmailService;
use App\Services\emails\WriteEmailService;
use App\Services\phoneNumbers\ReadPhoneNumberService;
use App\Services\phoneNumbers\WritePhoneNumberService;
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
        $this->app->bind(WriteContactInterface::class, WriteContactService::class);
        $this->app->bind(WriteAddressInterface::class, WriteAddressService::class);
        $this->app->bind(WritePhoneNumberInterface::class, WritePhoneNumberService::class);
        $this->app->bind(WriteEmailInterface::class, WriteEmailService::class);
        $this->app->bind(ReadPhoneNumberInterface::class, ReadPhoneNumberService::class);
        $this->app->bind(ReadEmailInterface::class, ReadEmailService::class);
        $this->app->bind(ReadAddressInterface::class, ReadAddressService::class);
    }
}
