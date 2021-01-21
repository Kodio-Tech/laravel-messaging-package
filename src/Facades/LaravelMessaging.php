<?php

namespace Kodio\LaravelMessaging\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelMessaging extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-messaging';
    }
}
