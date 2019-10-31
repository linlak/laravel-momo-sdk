 <?php

	namespace LaMomo\Models;

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
	class DataModel
	{

		private $amount = '';
		private $currency = 'UGX';
		private $externalId = '';
		private $payeeNote = '';
		private $payerMessage;
		private $payer = [
			'partyId' => '',
			'partyIdType' => 'MSISDN'
		];
		public function __construct($externalId, $amount, $partyId, $partyIdType, $payeeNote, $payerMessage)
		{
			$this->amount = $amount;
			$this->externalId = $externalId;
			$this->payeeNote = $payeeNote;
			$this->payerMessage = $payerMessage;
			$this->payer = [
				'partyId' => $partyId,
				'partyIdType' => $partyIdType
			];
		}
		public function setCurrency($currency)
		{
			$this->currency = $currency;
		}
		public function generateRequestBody()
		{
			$output = [
				"amount" => $this->amount,
				"currency" => $this->currency,
				"externalId" => $this->externalId,
				"payer" => $this->payer,
				"payerMessage" => $this->payerMessage,
				"payeeNote" => $this->payeeNote
			];
			return json_encode($output, JSON_UNESCAPED_SLASHES);
		}
		public function getAmount()
		{
			return $this->amount;
		}
		public function getCurrency()
		{
			return $this->currency;
		}
		public function getExternalId()
		{
			return $this->externalId;
		}
		public function getPartId()
		{
			return $this->payer['partyId'];
		}
		public function getPartyIdType()
		{
			return $this->payer['partyIdType'];
		}
		public function getPayerMessage()
		{
			return $this->payerMessage;
		}
		public function getPayeeNote()
		{
			return $this->payeeNote;
		}
		public function getPayer()
		{
			return $this->payer;
		}
	}
