<?php

namespace LaMomo\Support\Responses;

/**
 *Copyright (c) 2019, LinWorld Tech Solutions.
 *
 *All rights reserved.
 *
 *Redistribution and use in source and binary forms, with or without
 *modification, are permitted provided that the following conditions are met:
 *
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *
 *    * Redistributions in binary form must reproduce the above
 *      copyright notice, this list of conditions and the following
 *      disclaimer in the documentation and/or other materials provided
 *      with the distribution.
 *
 *    * Neither the name of LinWorld Tech Solutions nor the names of other
 *      contributors may be used to endorse or promote products derived
 *      from this software without specific prior written permission.

 *THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 *"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 *LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 *A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 *OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 *LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 *DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 *THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 *OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
class RequestStatus extends MomoResponse
{
    private $payer = [];
    private $externalId = "";
    private $amount = 0;
    private $currency = "";
    private $partyIdType = "";
    private $partyId = "";
    private $payerMessage = "";
    private $payeeNote = "";
    private $status = "";
    private $reason = null;
    private $financialTransactionId = null;
    private $resource_exists = false; //200 
    private $referenceId = "";
    function __construct(array $response, $referenceId)
    {
        parent::__construct($response);
        $this->referenceId = $referenceId;
        $this->handleResponse();
    }
    private function handleResponse()
    {
        if ($this->getCode() === 200) {
            $this->resource_exists = true;
            $this->amount = $this->getData('amount');
            $this->financialTranactionId = $this->getData('financialTransactionId');
            $this->reason = $this->getData('reason');
            $this->status = $this->getData('status');
            $this->payerMessage = $this->getData('payerMessage');
            $this->payeeNote = $this->getData('payeeNote');
            $this->payer = $this->getData('payer');
            $this->externalId = $this->getData('externalId');
        }
    }
    public function getReferenceId()
    {
        return $this->referenceId;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getReason()
    {
        return $this->reason;
    }
    public function getFinancialTransId()
    {
        return $this->financialTransactionId;
    }
    public function isSucess()
    {
        return $this->status === "SUCCESSFUL";
    }

    public function isPending()
    {
        return $this->status === "PENDING";
    }

    public function isFailed()
    {
        return $this->status === "FAILED";
    }
    public function isRejected()
    {
        return ($this->isFailed() && $this->reason === "");
    }
    public function isTimeOut()
    {
        return ($this->isFailed() && $this->reason === "");
    }
    public function resourceExists()
    {
        return $this->resource_exists;
    }
}
