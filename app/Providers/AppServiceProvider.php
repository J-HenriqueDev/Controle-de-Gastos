<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
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
        Paginator::useBootstrapFour();
        Schema::defaultStringLength(191);
        // condition 1
        if (env('APP_ENV') === 'production') {
            URL::forceSchema('https');
        }

        // condition 2
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // condition 3
        if (env('APP_FORCE_HTTPS', false)) {
            URL::forceScheme('https');
}
    }
}
