<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        if ($this->app->isProduction()) {
            URL::forceHttps(true);
            $this->app['request']->server->set('HTTPS', 'on');
            $this->app['request']->server->set('HTTP_X_FORWARDED_PROTO', 'https');
        }
    }
}
