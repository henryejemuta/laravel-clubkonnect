<?php

namespace HenryEjemuta\LaravelClubKonnect;

use HenryEjemuta\LaravelClubKonnect\Console\InstallLaravelClubKonnect;
use Illuminate\Support\ServiceProvider;

class ClubKonnectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('clubkonnect.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                InstallLaravelClubKonnect::class,
            ]);

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'clubkonnect');

        // Register the main class to use with the facade
        $this->app->singleton('clubkonnect', function ($app) {
            $baseUrl = config('clubkonnect.base_url');
            $instanceName = 'clubkonnect';

            return new ClubKonnect(
                $baseUrl,
                $instanceName,
                config('clubkonnect')
            );
        });

    }
}
