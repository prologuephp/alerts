<?php namespace Prologue\Alerts\Facades;

use Illuminate\Support\Facades\Facade;

class Alerts extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'alerts'; }

}