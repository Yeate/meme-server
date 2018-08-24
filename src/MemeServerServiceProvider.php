<?php

namespace Pokeface\MemeServer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Pokeface\MemeServer\Http\Controller\MemeServer;
use Pokeface\MemeServer\Http\Service\DouTuLaChannel;
use Pokeface\MemeServer\Http\Service\SougouChannel;

class MemeServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/memeserver.php' => config_path('memeserver.php'), 
        ]);
        $this->registerRoutes();


    }

     
    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('memeserver.route.prefix'),
            'namespace'     => 'Pokeface\MemeServer\Http\Controller',
            'as'    => config('memeserver.route.as'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/router/web.php');
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('MemeServer', function () {
            return new MemeServer();
        });
        $this->app->singleton('Sougou', function () {
            return new SougouChannel();
        });
        $this->app->singleton('DouTuLa', function () {
            return new DouTuLaChannel();
        });
        
    }

    /**
     * @return array
     */
    public function provides()
    {
        return array('MemeServer');
    }
}
