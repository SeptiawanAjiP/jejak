<?php

namespace Dewakoding\Jejak;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Dewakoding\Jejak\Middleware\TrackJejak;
use Livewire\Livewire;
use Dewakoding\Jejak\Http\Livewire\JejakDashboard;

class JejakServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/jejak.php', 'jejak'
        );

        // Bind Jejak class
        $this->app->singleton('jejak', function ($app) {
            return new Jejak();
        });
    }

    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/jejak.php' => config_path('jejak.php'),
        ], 'jejak-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/Migrations/' => database_path('migrations'),
        ], 'jejak-migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/jejak'),
        ], 'jejak-views');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'jejak');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Register middleware alias for ease of use
        $router = $this->app['router'];
        $router->aliasMiddleware('jejak', TrackJejak::class);
        $router->aliasMiddleware('track.jejak', TrackJejak::class); // backward compatibility
    
        // Register Livewire component
        if (class_exists(Livewire::class)) {
            Livewire::component('jejak-dashboard', JejakDashboard::class);
        }
    }
}