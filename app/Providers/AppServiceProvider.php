<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
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
    try {
        $settings = cache()->remember('settings', 3600, function () {
            return \App\Models\Setting::first();
        });

        view()->share('settings', $settings);
    } catch (\Throwable $e) {
        view()->share('settings', null);
    }
}
}
