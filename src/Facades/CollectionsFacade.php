<?php

namespace LaMomo\Facades;

use Illuminate\Support\Facades\Facade;
use LaMomo\Contracts\Collections;

class CollectionsFacade extends Facade
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
        return Collections::class;
    }
}
