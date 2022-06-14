<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        /** just for using ngrok */
        // \Illuminate\Support\Facades\URL::forceScheme('https');

        // DB::listen(function ($query) {
        //     Log::info($query->sql);
        //     Log::info($query->bindings);
        //     Log::info($query->time);
        // });
    }
}
