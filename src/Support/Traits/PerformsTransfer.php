<?php

namespace LaMomo\Support\Traits;

use Illuminate\Support\Str;
use LaMomo\Commons\Constants;
use LaMomo\Models\DataModel;
use LaMomo\Support\Responses\RequestToPayResponse;
use LaMomo\Support\Responses\RequestStatus;

trait PerformsTransfer
{
    public function requestToPay(DataModel $dataModel, $callback_url)
    {
        $this->setToken();
        $referenceId = Str::uuid()->toString();
        $this->setHeaders(Constants::H_REF_ID, $referenceId);
        $this->setAuth();

        if (false !== $callback_url) {
            $this->setHeaders(Constants::H_CALL_BACK, $callback_url);
        } else if (!is_null($this->_callback_url)) {
            $this->setHeaders(Constants::H_CALL_BACK, $this->_callback_url);
        }
        if ($this->_environment === 'sandbox') {
            $dataModel->setCurrency('EUR');
        }
        $response = $this->send($this->genRequest("POST", $this->transfer_uri, $dataModel->generateRequestBody()));

        $result = new RequestToPayResponse($response, $referenceId, $dataModel);

        return $result;
    }
    public function requestToPayStatus($referenceId)
    {
        $this->setToken();
        $this->setAuth();
        $response = $this->send($this->genRequest("GET", $this->transfer_uri . '/' . $referenceId));

        $result = new RequestStatus($response, $referenceId);

        return $result;
    }
    public function transferFunds(DataModel $dataModel, $callback_url)
    {
        return $this->requestToPay($dataModel, $callback_url);
    }
    public function transferStatus($referenceId)
    {
        return $this->requestToPayStatus($referenceId);
    }
}
