<?php

namespace LaMomo\Support\Traits;

use Illuminate\Http\Request;
use LaMomo\Support\Responses\RequestStatus;
use LaMomo\Facades\Disbursements;

trait DisbursementsWebHookTrait
{
    public function extractCallbackData(Request $request)
    {
        $refrenceId = $request->json('refrenceId');
        if (!is_null($refrenceId)) {
            $result = Disbursements::transferStatus($refrenceId);
            if ($result->resourceExists()) {
                $this->momoConfirmed($result);
            } else {
                $this->momoNotConfirmed($result);
            }
        }
        return response();
    }
    protected function momoConfirmed(RequestStatus $result)
    {
        //the request was from 
    }
    protected function momoNotConfirmed(RequestStatus $result)
    { }
}
