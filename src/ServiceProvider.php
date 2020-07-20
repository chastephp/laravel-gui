<?php

namespace ChastePhp\LaravelGUI;

use ChastePhp\LaravelGUI\Console\GuiCommand;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider as Provider;
use Illuminate\Support\Facades\Response;

class ServiceProvider extends Provider
{
    public function register()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/config/gui.php', 'gui');
        }
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/config/gui.php' => config_path('gui.php'),
            ], 'gui-config');
        }

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'gui');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->commands([
            GuiCommand::class,
        ]);
    }
}
