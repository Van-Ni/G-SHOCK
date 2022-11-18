<?php

namespace App\Providers;

use App\demoObserver;
use App\Observers\DemoWithObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *  Register any authentication / authorization services.
     *
     * @return void
     */
    public function register()
    {
        //

    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
