<?php

namespace LaMomo\Facades;

use Illuminate\Support\Facades\Facade;

class Collections extends Facade
{
    /**
     * @method static requestBalance();
     *
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'momo_collections';
    }
}
