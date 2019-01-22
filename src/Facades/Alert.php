<?php

namespace Prologue\Alerts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Prologue\Alerts\AlertsMessageBag success(string $text)
 * @method static \Prologue\Alerts\AlertsMessageBag error(string $text)
 * @method static \Prologue\Alerts\AlertsMessageBag warning(string $text)
 * @method static \Prologue\Alerts\AlertsMessageBag info(string $text)
 */
class Alert extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'alerts';
    }
}
