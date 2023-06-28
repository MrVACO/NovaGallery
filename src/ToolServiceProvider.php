<?php

namespace MrVaco\NovaGallery;

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
}
