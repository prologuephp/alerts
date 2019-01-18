<?php

namespace Prologue\Alerts;

use Illuminate\Support\ServiceProvider;

class AlertsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('prologue/alerts.php')]);
    }

    public function register()
    {
        $this->mergeConfig();
        $this->registerAlertsMessageBagClass();
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'prologue.alerts');
    }

    private function registerAlertsMessageBagClass()
    {
        $this->app->singleton('alerts', function ($app) {
            return new AlertsMessageBag($app['session.store'], $app['config']);
        });
    }

    public function provides()
    {
        return ['alerts'];
    }
}
