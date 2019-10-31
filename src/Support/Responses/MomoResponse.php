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
abstract class MomoResponse
{
	protected $response = [];
	protected $data = [];
	protected $status_code = 0;
	protected $status_phrase = "Network error";

	function __construct(array $response)
	{
		$this->response = $response;
		$this->parseResponse();
	}
	private function parseResponse()
	{
		if (array_key_exists("status_code", $this->response)) {
			$this->status_code = $this->response['status_code'];
			$this->status_phrase = $this->response['status_phrase'];
			if (array_key_exists("data", $this->response)) {
				$data = $this->response['data'];
				if (is_array($data) && !empty($data)) {
					$this->data = $data;
				}
			}
		}
	}
	public function getData($key)
	{
		if (is_array($key) || !array_key_exists($key, $this->data)) {
			return "";
		}
		return $this->data[$key];
	}
	public function getCode()
	{
		return $this->status_code;
	}
	public function getPhrase()
	{
		return $this->status_phrase;
	}
}
