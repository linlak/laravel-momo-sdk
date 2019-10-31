<?php

namespace LaMomo\Support\Traits;

use Illuminate\Http\Request;
use LaMomo\Facades\Remittances;
use LaMomo\Support\Responses\RequestStatus;

trait RemittancesWebHookTrait
{
    public function extractCallbackData(Request $request)
    {
        $refrenceId = $request->json('refrenceId');
        if (!is_null($refrenceId)) {
            $result = Remittances::transferStatus($refrenceId);
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
