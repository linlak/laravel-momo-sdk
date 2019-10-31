<?php

namespace LaMomo\Support\Traits;

use Illuminate\Http\Request;
use LaMomo\Support\Responses\RequestStatus;

trait CollectionsWebHookTrait
{
    public function extractCallbackData(Request $request)
    {
        $refrenceId = $request->json('refrenceId');
        if (!is_null($refrenceId)) {
            $result = Collections::requestToPayStatus($refrenceId);
            if ($result->resourceExists()) {
                $this->momoConfirmed($result);
            } else {
                $this->momoNotConfirmed($result);
            }
        }
        return response();
    }

    protected function momoConfirmed(RequestStatus $result)
    { }

    protected function momoNotConfirmed(RequestStatus $result)
    { }
}
