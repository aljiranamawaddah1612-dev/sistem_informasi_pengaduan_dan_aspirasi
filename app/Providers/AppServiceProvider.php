<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

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
    public function boot(): void
    {
        RateLimiter::for('pengaduan', function (Request $request) {
            return Limit::perDay(3)->by($request->user()?->id ?: $request->ip());
        });

        try {
            $setting = Setting::first();
            View::share('setting', $setting);
        } catch (\Exception $e) {
            // database tidak ditemukan
        }
    }
}
