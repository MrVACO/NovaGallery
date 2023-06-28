<?php

namespace MrVaco\NovaGallery;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use MrVaco\NovaGallery\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->booted(function()
        {
            $this->routes();
        });
        
        Nova::serving(function(ServingNova $event)
        {
            Nova::tools([
                new NovaGallery
            ]);
        });
    }
    
    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        if ($this->app->routesAreCached())
        {
            return;
        }
        
        Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-gallery')
            ->group(__DIR__ . '/../routes/inertia.php');
        
        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-gallery')
            ->group(__DIR__ . '/../routes/api.php');
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    
    }
}
