<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
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
        Response::macro('success', function ($message = '', $data = [], $status = 200) {
            $response = [];
            if ($message) $response['message'] = $message;
            if ($data) $response['data'] = $data;
            return Response::json($response, $status);
        });

        Response::macro('error', function ($message = '', $errors = [], $status = 400) {
            $response = [];
            if ($message) $response['message'] = $message;
            if ($errors) $response['errors'] = $errors;
            return Response::json($response, $status);
        });
    }
}
