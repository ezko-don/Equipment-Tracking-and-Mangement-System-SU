<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Policies\BookingPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      
    }
   
}
