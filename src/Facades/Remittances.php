<?php

namespace LaMomo\Facades;

use Illuminate\Support\Facades\Facade;

class Remittances extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'momo_remittances';
    }
}
