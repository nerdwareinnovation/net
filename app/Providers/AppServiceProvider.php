<?php

namespace App\Providers;

use App\Models\SiteSettings;
use Illuminate\Support\ServiceProvider;

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
        // Share site settings globally if needed
        try {
            $site_settings = SiteSettings::pluck('value', 'name')->toArray();
            view()->share('site_settings', $site_settings);
        } catch (\Exception $e) {
            // If table doesn't exist yet, just continue
            view()->share('site_settings', []);
        }
    }
}
