<?php

namespace LaMomo\Facades;

use Illuminate\Support\Facades\Facade;
use LaMomo\Contracts\Remittances;

class RemittancesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Remittances::class;
    }
}
