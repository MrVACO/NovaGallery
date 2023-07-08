<?php

namespace MrVaco\NovaGallery;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use MrVaco\NovaGallery\Nova\Gallery;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::serving(function(ServingNova $event)
        {
            Nova::tools([
                new NovaGallery
            ]);
            
            Lang::addJsonPath(__DIR__ . '/../lang');
        });
        
        $this->app->booted(function()
        {
            $this->routes();
        });
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::resources([
            Gallery::class
        ]);
    }
    
    protected function routes(): void
    {
        if ($this->app->routesAreCached())
        {
            return;
        }
        
        app('router')
            ->middleware('api')
            ->prefix('api/gallery')
            ->group(__DIR__ . '/../routes/api.php');
    }
}
