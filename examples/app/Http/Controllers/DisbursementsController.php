<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaMomo\Support\Responses\RequestStatus;
use LaMomo\Support\Traits\DisbursementsWebHookTrait;

class DisbursementsController extends Controller
{
    use DisbursementsWebHookTrait;

    protected function momoConfirmed(RequestStatus $result)
    {
        //check if payment is SUCCESSFUL, PENDING or FAILED
    }

    protected function momoNotConfirmed(RequestStatus $result)
    {
        //action to perform
    }
}
