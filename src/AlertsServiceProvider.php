<?php
namespace Prologue\Alerts;

use Illuminate\Support\ServiceProvider;

class AlertsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishConfig();
        $this->registerAlertsMessageBagClass();
    }

    private function publishConfig()
    {
        $configPath = __DIR__ . '/config/config.php';

        $this->publishes([$configPath => config_path('prologue/alerts.php')]);
        $this->mergeConfigFrom($configPath, 'prologue.alerts');
    }

    private function registerAlertsMessageBagClass()
    {
        $this->app['alerts'] = $this->app->share(function ($app) {
            return new AlertsMessageBag($app['session.store'], $app['config']);
        });
    }

    public function provides()
    {
        return ['alerts'];
    }
}
