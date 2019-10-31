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

use LaMomo\Models\DataModel;

class RequestToPayResponse extends MomoResponse
{
	private $is_accepted = false; //202 
	private $is_duplicate = false; //409
	private $referenceId = "";
	private  $requestBody;

	function __construct(array $response, $referenceId, DataModel $requestBody)
	{
		parent::__construct($response);
		$this->handleResponce();
		$this->referenceId = $referenceId;
		$this->requestBody = $requestBody;
	}
	private function handleResponce()
	{
		if ($this->getCode() === 202) {
			$this->is_accepted = true;
		} else {
			if ($this->getCode() === 409) {
				$this->is_duplicate = true;
			}
		}
	}
	public function isAccepted()
	{

		return $this->is_accepted;
	}
	public function isDuplicate()
	{
		return $this->is_duplicate;
	}
	public  function getRequestBody()
	{
		return $this->requestBody;
	}
	public function getReferenceId()
	{
		return $this->referenceId;
	}
}
