<?php

namespace Kodio\LaravelMessaging;

use Illuminate\Support\ServiceProvider;
use Kodio\LaravelMessaging\Components\MessagingJs;
use Kodio\LaravelMessaging\Components\MessagingComponent;

class LaravelMessagingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'kodio');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'kodio');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewComponentsAs('kodio', [
            MessagingComponent::class,
            MessagingJs::class,
        ]);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-messaging.php', 'laravel-messaging');

        // Register the service the package provides.
        $this->app->singleton('laravel-messaging', function ($app) {
            return new LaravelMessaging;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-messaging'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-messaging.php' => config_path('laravel-messaging.php'),
        ], 'laravel-messaging.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/kodio'),
        ], 'laravel-messaging.views');

        // Publishing the migrations.
        $this->publishes([
            __DIR__.'/resources/database/migrations' => base_path('database/migrations'),
        ], 'laravel-messaging.migrations');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/kodio'),
        ], 'laravel-messaging.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/kodio'),
        ], 'laravel-messaging.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
