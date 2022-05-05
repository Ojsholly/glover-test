<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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

        Response::macro('success', function ($data, $message = "", $status = 200) {
            return response()->json([
                "status" => "success",
                "message" => $message,
                "data" => $data
            ], $status);
        });

        Response::macro('error', function ($message, $status = 400) {
            return response()->json([
                "status" => "error",
                "message" => $message
            ], $status);
        });

        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                ? $rule->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised() : $rule;
        });
    }
}
