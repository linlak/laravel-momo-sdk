# Laravel MTN MOMO SDK #
This laravel library has been designed to to enable **Laravel Developers** to easily integrate the MTN open Api into their systems.

## Prerequisites ##
Before you continue, we assume you have the following in place.

- XAMPP or LAMPP installation with latest php version i.e PHP>=7.1
- Composer package to install the required php packages.
- We also recommend installation of Redis or Memchached drivers to store cache and running queues
- You must also have an account on the MTN Developer portal and Subscribe to the api products.
- We also assume you already have a running laravel app or project.

## Installation ##

The installation of this **laravel-momo-sdk** is straight forward. Simply run the command bellow in terminal or cmd.

	composer require linlak/laravel-momo-sdk
	
## Configuration ##
For laravel versions that support auto discover, you can skip this step while for versions prior to 5.5, add the following code in your **config/app.php** in the **proveders** array

    'providers' => [
    	/*
    	*......add this code at the end of the providers array
    	*/
    	LaMomo\Providers\MomoProvider::class,
    ],

Still in the same file locate that **aliases** array

    'aliases'=>[
    	//appended at the end of aliases array
    	'Remittances' => LaMomo\Facades\Remittances::class,
        'RequestToPay' => LaMomo\Facades\RequestToPay::class,
        'Disbursements' => LaMomo\Facades\Disbursements::class,
    ],

Now we have set-up the require files registered our provider.

This step should be performed by all users. In your terminal or cmd run the following artisan command


	php artisan vendor:publish --provider=LaMomo\\Providers\\MomoProvider


The command above will publish the **momosdk.php** in the config directory.
## Environment variables (.env) ##
In the **.env** file add the follow code for each api product

    MOMO_BASE=https://sandbox.momodeveloper.mtn.com/
    MOMO_API_VERSION=v1_0
    MOMO_ENVIRONMENT=sandbox
    DISABLE_TAGS=false

    MOMO_HOST=example.com

**Collection product**

    COLLECTIONS_PRIMARY=your collections primary key
    COLLECTIONS_SECONDARY=your collections secondary key
    COLLECTIONS_API_USER=uuid for apiuser
    COLLECTIONS_API_KEY=api key here
    COLLECTIONS_CALLBACK_URL=your collections callback url "optional"

**Disbursements product**

    REMITTANCES_PRIMARY=
    REMITTANCES_SECONDARY=
    REMITTANCES_API_USER=
    REMITTANCES_API_KEY=
    REMITTANCES_CALLBACK_URL=

**Remittances product**

    DISBURSEMENTS_PRIMARY=
    DISBURSEMENTS_SECONDARY=
    DISBURSEMENTS_API_USER=
    DISBURSEMENTS_API_KEY=
    DISBURSEMENTS_CALLBACK_URL=

If all of the code snippets above are bundled up our **.env** file must have the following code appended at the end.

	MOMO_BASE=https://sandbox.momodeveloper.mtn.com/
	MOMO_API_VERSION=v1_0
	MOMO_ENVIRONMENT=sandbox
	DISABLE_TAGS=false
	MOMO_HOST=example.com
	COLLECTIONS_PRIMARY=
	COLLECTIONS_SECONDARY=
	COLLECTIONS_API_USER=
	COLLECTIONS_API_KEY=
	COLLECTIONS_CALLBACK_URL=
	REMITTANCES_PRIMARY=
	REMITTANCES_SECONDARY=
	REMITTANCES_API_USER=
	REMITTANCES_API_KEY=
	REMITTANCES_CALLBACK_URL=
	DISBURSEMENTS_PRIMARY=
	DISBURSEMENTS_SECONDARY=
	DISBURSEMENTS_API_USER=
	DISBURSEMENTS_API_KEY=
	DISBURSEMENTS_CALLBACK_URL=
	
## Definitions ##
**MOMO_BASE:** This is the base_uri for the wallet system. We have designed this library to be flexible with api changes. After finding differences between sandbox and live endpoints, this environment variable will help you to set right endpoint
e.g for collections request to pay, the link is

> https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay

In the link above you find that we are sending our request to the **https://sandbox.momodeveloper.mtn.com/** endpoint.

**MOMO_API_VERSION:** This is self explanatory. It the version of the api endpoint. By default its value is **v1_0**.

**MOMO_ENVIRONMENT:** This is either sandbox or live

**DISABLE_TAGS:** This library is cache based. Laravel has made caching as simple as possible. Caching drivers like Redis and Memcached support component tagging but for drivers such as file and database do not support tagging. If you are using file or database as your default cache driver, set the environment variable to **true** .

    DISABLE_TAGS=true

**MOMO_HOST:** This is the callback host as stated in the documentation.

**COLLECTIONS\_\_PRIMARY:** This primary_key for the collections product, can be found on your profile on the developers portal. Other products are prefixed with their respective product names

i.e

REMITTANCES_PRIMARY

DISBURSEMENTS_PRIMARY

**COLLECTIONS_SECONDARY:** This secondary_key for the collections product, can be found on your profile on the developers portal. Other products are prefixed with their respective product names

i.e

REMITTANCES_SECONDARY

DISBURSEMENTS_SECONDARY

**COLLECTIONS_ API_USER :** This is the apiUser for collections product.

**COLLECTIONS_API_KEY:** This the apiKey for the collections product.

**COLLECTIONS_CALLBACK_URL:** This is default callback url for the collections product. This is optional.

## Function Definitions ##
**Collections**

- createApiUser() //sandbox only
- getApiUser() //sandbox only
- getApikey() //sandbox only
- acountHolder($accountHolderIdType, $accountHolderId)
- requestToPay(DataModel $dataModel, $callback_url)
- requestToPayStatus(\$referenceId)

**Remittances**

- createApiUser() //sandbox only
- getApiUser() //sandbox only
- getApikey() //sandbox only
- acountHolder($accountHolderIdType, $accountHolderId)
- transferFunds(DataModel $dataModel, $callback_url)
- transferStatus(\$referenceId)

**Disbursements**

- createApiUser() //sandbox only
- getApiUser() //sandbox only
- getApikey() //sandbox only
- acountHolder($accountHolderIdType, $accountHolderId)
- transferFunds(DataModel $dataModel, $callback_url)
- transferStatus(\$referenceId)

## Examples ##
We are going to consider an e-commerse store selling different products.

The product has the following attributes

- pdt_name
- price
- pdt_no

The Order Model

Let us first create our controllers and models

These first steps are for sandbox users.

After every step remember to clear the configuration cache so that changes can take effect. Run

    php artisan conf:cache

**Creating apiUser (Collections)**

	<?php
	use LaMomo\Facades\Collections;
	Route::get('/collection-create-api-user', function () {
	$result=Collections::createApiUser();
		    if($result->isCreated()){
	echo 'apiUser:- '.$result->getUid();
		    }else{
		    	echo 'apiUser not created <br>';
		    	echo 'Reason: '.$result->getPhrase();
	}
	});

**Creating apiUser (Remittances)**

	<?php
	use LaMomo\Facades\Remittances;
	Route::get('/remittances-create-api-user', function () {
	$result=Remittances::createApiUser();
		    if($result->isCreated()){
	echo 'apiUser:- '.$result->getUid();
		    }else{
		    	echo 'apiUser not created <br>';
		    	echo 'Reason: '.$result->getPhrase();
	}
	});

**Creating apiUser (Disbursements)**

	<?php
	use LaMomo\Facades\Disbursements;
	Route::get('/disbursements-create-api-user', function () {
	$result=Disbursements::createApiUser();
		    if($result->isCreated()){
	echo 'apiUser:- '.$result->getUid();
		    }else{
		    	echo 'apiUser not created <br>';
		    	echo 'Reason: '.$result->getPhrase();
	}
	});
	
**Note**

The **apiUser** function returns the **ApiUserResponse**. This has the following function mapping.

> These apply to all Api products.

- isCreated()
- getUid()

**Creating apiKey (Collections)**

	<?php
	use LaMomo\Facades\Collections;
	Route::get('/collection-get-api-key', function () {
	$result=Collections::getApikey();
		    if($result->isCreated()){
	echo 'apiKey- '.$result->getApiKey();
		    }else{
		    	echo 'apiKey not created <br>';
		    	echo 'Reason: '.$result->getPhrase();
	}
	});

**Creating apiKey (Remittances)**

	<?php
	use LaMomo\Facades\Remittances;
	Route::get('/remittances-get-api-key', function () {
	$result=Remittances::getApikey();
		    if($result->isCreated()){
	echo 'apiKey:- '.$result->getApiKey();
		    }else{
		    	echo 'apiKey not created <br>';
		    	echo 'Reason: '.$result->getPhrase();
	}
	});

**Creating apiKey (Disbursements)**

	<?php
	use LaMomo\Facades\Disbursements;
	Route::get('/disbursements-get-api-key', function () {
	$result=Disbursements::getApikey();
		    if($result->isCreated()){
	echo 'apiKey:- '.$result->getApiKey();
		    }else{
		    	echo 'apiKey not created <br>';
		    	echo 'Reason: '.$result->getPhrase();
	}
	});

The **getApikey** function returns the **ApiKeyResponse**. This has the following function mapping.( applies to all api products)

- isCreated()
- getApiKey()

You should copy the apiUser and apiKey to the **.env** file. Read **configuration** to find out how to.

**Note**

**accessToken** will be created automatically if there is no token in the cache store.

For the remaining steps, we are going to use the Collections facade because of the consistence in function naming therefore, when you are making requests for other products replace the Collections facade with either Remittances or Disbursements facades.

**Request Balance (Collections)**

    <?php

    	use LaMomo\Facades\Collections;

    	Route::get('/collection-get-balance', 'Collectionsontroller@checkBalance');


In our controller we have the following code
	
	<?php
	
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


The **checkBalance** function is used to check the account balance for all products i.e collections,remittances,disbursements. This function returns a **LaMomo\Support\Responses\BalanceResponse**

**Function mapping for BalanceResponse**

- isFound()
- getAvailableBalance()
- getCurrency()

**Account Holder (Collections)**

    <?php

    	use LaMomo\Facades\Collections;

    	Route::get('/collection-get-account-holder', 'CollectionsController@accountHolder');

In our controller we have the following code

    <?php
    	/**
    	*
    	*@param \Illuminate\Http\Request $request
    	*/
    	public function accountHolder(Request $request){
    		$accountHolderIdType = "";
    	        $accountHolderId = "";

    	        $result = Collections::acountHolder($accountHolderIdType, $accountHolderId);

    	        //let just see the response still working on this

    	        dump($result);
    	}


The **acountHolder** function returns the **AccountHolderResponse** this is still pending because this library has been test on sandbox environment. But will be updated just keep this document for updates and bug fixes.

**RequestToPay (Collections)**
We have assumed that you have an Invoice Model

    <?php

    	Route::get('/collection-request-to-pay/{id}', 'CollectionsController@requestToPay');


In our controller we have the following code

    <?php

    	use App\Invoice;
    	use LaMomo\Models\DataModel;

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


The **requestToPay** function returns a **RequestToPayResponse** and its function mapping is as follows:-

- isAccepted()
- isDuplicate()
- getReferenceId()
- getRequestBody()

The referenceId is generated for and you can get it by calling function **getReferenceId()** of the result.

## WebHooks ##
We have created traits for you to include in your controllers for callback_url routes.

**Note**

Don't put these traits in the same Controller else you will run into errors because they have the same naming convention.

Don't user CollectionsWebHookTrait to register callback route for different products, else you will not get desirable results. These Traits have been named in a way that makes it easy to identify what product it represents.

- CollectionsWebHookTrait
- DisbursementsWebHookTrait
- RemittancesWebHookTrait

Functional representation for all Traits **(same naming, different functionality)**

- extractCallbackData(Request $request)
- momoConfirmed(RequestStatus $result)
- momoNotConfirmed(RequestStatus $result)

**extractCallbackData** This function takes Illuminate\Http\Request as its argument. We do not recommend change this functions code unless you know what you are doing.

All this function does is to get the referenceId from the request and check wallet system for a requestToPayStatus or transferStatus. This function aims at verifying that the request originated from the wallet system.

**momoConfirmed:** This is called by **extractCallbackData** if the resource was found on the wallet system. Place your validation and activation logic in this function.

**NB:** Don't perform a requestToPayStatus or transferStatus request because it is what we have just done in the **extractCallbackData** function.

**momoConfirmed:** This is called by **extractCallbackData** if the resource is not found on wallet system.

**Recommendation**

We recommend you to always use the **extractCallbackData** for all your callback route.

**What you must do**

- Create a controller for each callback route (callback_url).
- Use the WebHook traits for their respective product callback_url. **i.e.** For collections product callback_url, you must use **CollectionsWebHookTrait** while for remittances and disbursements use **RemittancesWebHookTrait** and **DisbursementsWebHookTrait** respectively.

**Register WebHook (Collections)**

We have assumed that your project has a Controller named CollectionsController

Our Route will look like
Route::post('{collections_collback_url}','CollectionsController@extractCallbackData');
In our CollectionsController it will the following code

    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use LaMomo\Support\Responses\RequestStatus;
    use LaMomo\Support\Traits\CollectionsWebHookTrait;

    class CollectionsController extends Controller{
    	use CollectionsWebHookTrait;

    	protected function momoConfirmed(RequestStatus $result)
    	{
    		//check if payment is SUCCESSFUL, PENDING or FAILED
    	}

    	protected function momoNotConfirmed(RequestStatus $result)
    	{
    		//action to perform
    	}
    }

**Register WebHook (Remittances)**

We have assumed that your project has a Controller named RemittancesController

Our Route will look like
Route::post('{remittances_collback_url}','RemittancesController@extractCallbackData');
In our RemittancesController it will the following code

    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use LaMomo\Support\Responses\RequestStatus;
    use LaMomo\Support\Traits\RemittancesWebHookTrait;

    class RemittancesController extends Controller{
    	use RemittancesWebHookTrait;

    	protected function momoConfirmed(RequestStatus $result)
    	{
    		//check if payment is SUCCESSFUL, PENDING or FAILED
    	}

    	protected function momoNotConfirmed(RequestStatus $result)
    	{
    		//action to perform
    	}
    }

**Register WebHook (Disbursements)**

We have assumed that your project has a Controller named DisbursementsController

Our Route will look like
Route::post('{disbursements_collback_url}','DisbursementsController@extractCallbackData');
In our DisbursementsController it will the following code

    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use LaMomo\Support\Responses\RequestStatus;
    use LaMomo\Support\Traits\DisbursementsWebHookTrait;

    class DisbursementsController extends Controller{
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

**Function map for RequestStatus**

- getReferenceId()//string (uuid)
- getStatus()//string (SUCCESSFUL, PENDING, FAILED)
- getReason()//string
- getFinancialTransId() //string
- isSucess()//boolean
- isPending()//boolean
- isFailed()//boolean
- isRejected()//boolean
- isTimeOut()//boolean
- resourceExists()//boolean
