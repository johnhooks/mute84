<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        // Implicitly grant "super" role all permission
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        // https://spatie.be/docs/laravel-permission/v6/basic-usage/super-admin#content-gatebefore
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super') ? true : null;
        });

        /** just for using ngrok */
        // \Illuminate\Support\Facades\URL::forceScheme('https');

        // DB::listen(function ($query) {
        //     Log::info($query->sql);
        //     Log::info($query->bindings);
        //     Log::info($query->time);
        // });
    }
}
