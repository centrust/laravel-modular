<?php

namespace Idel\Modular;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var bool Indicates if loading of the provider is deferred.
     */
    protected $defer = false;
    
    /**
     * Bootstrap the provided services.
     */
    public function boot()
    {
        $this->app['modules']->register();
    }

    /**
     * Register the provided services.
     */
    public function register()
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(GeneratorServiceProvider::class);

        $this->app->singleton('modules', function ($app) {
            return new RepositoryManager($app);
        });
    }

    /**
     * Get the services provided by the package.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules'];
    }
}