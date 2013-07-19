<?php namespace Prologue\Alerts;

use Illuminate\Support\ServiceProvider;

class AlertsServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register config file.
		$this->app['config']->package('prologue/alerts', __DIR__.'/../../config');

		// Register the AlertsMessageBag class.
		$this->app['alerts'] = $this->app->share(function($app)
		{
			return new AlertsMessageBag($app['session'], $app['config']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('alerts');
	}

}