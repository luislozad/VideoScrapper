<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        $pluginsPath = __DIR__.'/../../resources/views/livewire/admin/plugins';
        Blade::anonymousComponentPath($pluginsPath, 'pg');
        Blade::anonymousComponentPath($pluginsPath.'/media-downloader', 'pg-media-downloader');
    }
}
