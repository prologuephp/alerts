<?php
namespace Prologue\Alerts;

use Illuminate\Support\ServiceProvider;

class AlertsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfig();
        $this->registerAlertsMessageBagClass();
    }

    private function registerConfig()
    {
        $this->app['config']->package('prologue/alerts', __DIR__ . '/../../config');
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
