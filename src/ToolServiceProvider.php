<?php

namespace MrVaco\NovaGallery;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
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
        
        $this->forPublish();
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
    
    protected function forPublish()
    {
        if (!$this->app->runningInConsole())
        {
            return;
        }
        
        $this->publishes([
            __DIR__ . '/Database/migrations/create_galleries_table.stub' => $this->getMigrationFileName('create_galleries_table.php'),
        ], 'gallery-migrations');
    }
    
    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(string $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');
        
        $filesystem = $this->app->make(Filesystem::class);
        
        return Collection::make([database_path('migrations/')])
            ->flatMap(fn($path) => $filesystem->glob($path . '*_' . $migrationFileName))
            ->push(database_path("/migrations/{$timestamp}_{$migrationFileName}"))
            ->first();
    }
}
