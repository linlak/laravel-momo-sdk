<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaMomo\Support\Responses\RequestStatus;
use LaMomo\Support\Traits\CollectionsWebHookTrait;
use App\Invoice;
use LaMomo\Models\DataModel;

class CollectionsController extends Controller
{
    use CollectionsWebHookTrait;
    public function checkBalance()
    {
        $result = Collections::requestBalance();
        if ($result->isFound()) {
            echo 'Available balance- ' . $result->getAvailableBalance();
        } else {
            echo 'Error fetching balance. <br>';
            echo 'Reason: ' . $result->getPhrase();
        }
    }
    public function accountHolder()
    {

        $accountHolderIdType = "";
        $accountHolderId = "";

        $result = Collections::acountHolder($accountHolderIdType, $accountHolderId);

        //let just see the response still working on this

        dump($result);
    }
    public function requestToPay(Request $request, $id)
    {
        $callback_url = "";

        $invoice = Invoice::find($id);

        $dataModel = new DataModel($invoice->id,  $invoice->total,  $invoice->payment->partyId,  $invoice->payment->partyIdType, 'Pay invoice no. ' . $invoice->invoice_number, 'Invoice payment');

        $result = Collections::requestToPay($dataModel, $callback_url);

        if ($result->isAccepted()) {

            echo 'refrenceId: ' . $result->getReferenceId();
        } else if ($result->isDuplicate()) {

            echo 'Status: ' . $result->getCode() . '<br>';

            echo 'Status: ' . $result->getPhrase();
        }
    }
    protected function momoConfirmed(RequestStatus $result)
    {
        //check if payment is SUCCESSFUL, PENDING or FAILED
    }

    protected function momoNotConfirmed(RequestStatus $result)
    {
        //action to perform
    }
}
