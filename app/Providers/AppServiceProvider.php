<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        // Define a new view's namespace: "backend"
        $this->app['view']->addNamespace('backend', base_path() . '/resources/views/web/backend');

        // Define a new view's namespace: "auth"
        $this->app['view']->addNamespace('auth', base_path() . '/resources/views/web/auth');

    }
}
