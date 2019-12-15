<?php

namespace LaMomo\Facades;

use Illuminate\Support\Facades\Facade;
use LaMomo\Contracts\Disbursements;

class DisbursementsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Disbursements::class;
    }
}
