<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\AdminLogObserver;
use Illuminate\Support\Facades\Event;
use App\Events\BookingCreated;
use App\Listeners\SendBookingNotifications;

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
    public function boot()
    {
        Event::listen(
            BookingCreated::class,
            SendBookingNotifications::class
        );
    }
}
