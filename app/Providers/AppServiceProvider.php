<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        /**
         * set locale Indonesia secara global pada class Carbon
         */
//        \Carbon\Carbon::setlocale('id');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new \Illuminate\Routing\ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });
        $this->app->bind('GlobalAuth', 'App\Support\GlobalAuth');
        $this->app->bind('RomanConverter', 'App\Support\RomanConverter');
        $this->app->bind('Chart', 'App\Support\Chart');
    }
}
