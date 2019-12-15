<?php

namespace LaMomo\Support;

use \Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Str;
use LaMomo\Commons\Constants;
use LaMomo\Commons\MomoLinks;
use LaMomo\Support\Responses\ApiKeyResponse;
use LaMomo\Support\Responses\ApiUserInfoResponse;
use LaMomo\Support\Responses\ApiUserResponse;
use LaMomo\Support\Responses\BalanceResponse;
use LaMomo\Support\Responses\TokenResponse;
use Psr\Http\Message\ResponseInterface;

abstract class BaseMomoModel
{
    private $_client;
    /**
     * @var string
     */
    protected $_version;
    /**
     * @var array
     */
    protected $headers = [];
    /**
     * @var string
     */
    protected $transfer_uri;
    /**
     * @var string
     */
    protected $_environment;
    /**
     * @var string
     */
    protected $_prefix;
    /**
     * @var bool
     */
    protected $_tags_disabled;
    /**
     * @var string
     */
    protected $_hostname;
    /**
     * @var string
     */
    protected $_primarykey;
    /**
     * @var string
     */
    protected $_secondarykey;
    /**
     * @var string
     */
    protected $_api_key;
    /**
     * @var string
     */
    protected $_apiuser;
    /**
     * @var string
     */
    protected $_base_uri;
    /**
     * @var string
     */
    protected $_callback_url;
    /**
     * @var string
     */
    protected $_accessToken;
    /**
     * @var string
     */
    protected $_product;
    /**
     * @var string
     */
    protected $_accessKey;
    /**
     * @var Cache
     */
    protected $cache;
    /**
     * @var bool
     */
    protected $is_cached = false;

    public function __construct(CacheManager $cache, $product)
    {
        $this->setVariables($cache, $product);

        $this->_client = new Client(
            [
                'base_uri' => $this->_base_uri,
                'verify' => false,
                'timout' => 40

            ]
        );
    }

    private function setVariables(CacheManager $cache, $product)
    {
        $this->_product = $product;
        $this->_base_uri = config('momosdk.base_uri', MomoLinks::BASE_URI);
        $this->_environment = config('momosdk.environment', 'sandbox');
        $this->_version = config('momosdk.api_version', Constants::DEFAULT_VERSION);
        $this->_prefix = config('momosdk.prefix', 'momo_sdk_');
        $this->_tags_disabled = config('momosdk.tags_disabled', false);
        $this->_hostname = config('momosdk.hostname', null);
        $this->_primarykey = config('momosdk.' . $product . '.primarykey', null);
        $this->_secondarykey = config('momosdk.' . $product . '.secondarykey', null);
        $this->_api_key = config('momosdk.' . $product . '.api_key', null);
        $this->_apiuser = config('momosdk.' . $product . '.apiuser', null);
        $this->_callback_url = config('momosdk.' . $product . '.callback_url', null);
        $this->_accessToken = "";
        $this->_accessKey = '_access_token_' . $product;
        $this->cache = new Cache($cache, (!$this->_tags_disabled) ? [$this->_prefix . $product] : false, 15);
        $this->genHeaders();
    }

    /**
     * Get cache instance.
     *
     * @return \LaMomo\Support\Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    public function requestBalance()
    {
        $this->setToken();
        $this->setAuth();
        $response = $this->send($this->genRequest("GET", $this->getBalanceUri()));

        return new BalanceResponse($response);
    }

    public function get()
    {
        return $this;
    }

    private function genHeaders()
    {
        $this->setHeaders(Constants::H_ENVIRON, $this->_environment);
        $this->setHeaders(Constants::H_C_TYPE, 'application/json');
        $this->setHeaders(Constants::H_OCP_APIM, $this->_primarykey);
    }

    protected function genRequest($mtd, $url, $body = false)
    {
        if (false === $body) {
            $this->removeHeader(Constants::H_C_TYPE);
            $request = new Request($mtd, $url, $this->headers);
        } else {
            $this->setHeaders(Constants::H_C_TYPE, 'application/json');
            if (is_array($body)) {
                $body = json_encode($body, JSON_UNESCAPED_SLASHES);
            }
            $this->setHeaders("Content-Length", strlen($body));

            $request = new Request($mtd, $url, $this->headers, $body);
        }
        return $request;
    }

    public function setAuth()
    {

        if ("" !== $this->_accessToken) {
            $this->setHeaders(Constants::H_AUTH, 'Bearer ' . $this->_accessToken);
            return;
        } else {

            $authKey = $this->_apiuser . ':' . $this->_api_key;
            $this->setHeaders(Constants::H_AUTH, 'Basic ' . base64_encode($authKey));
        }
    }

    protected function send(Request $request)
    {
        $promise = $this->_client->sendAsync($request)
            ->then(function (ResponseInterface $res) {
                // echo (Psr7\str($res));
                return $this->passResponse($res);
            }, function (RequestException $e) {
                // echo (Psr7\str($e->getRequest()) . "\n\r");
                if ($e->hasResponse()) {
                    // echo (Psr7\str($e->getResponse()) . "\n\r");
                    return $this->passResponse($e->getResponse());
                }
                return [
                    'status_code' => $e->getCode(),
                    'status_phrase' => "Connection Error"
                ];
            });
        return  $promise->wait();
    }

    private function passResponse(ResponseInterface $response)
    {

        if ($response !== null) {

            $output = [
                "status_code" => $response->getStatusCode(),
                "status_phrase" => $response->getReasonPhrase(),
            ];
            $body = $response->getBody();
            $output['data'] = json_decode($body->getContents(), 1);
            return $output;
        }
        return false;
    }

    protected function setHeaders($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function removeHeader($key)
    {
        if (!array_key_exists($key, $this->headers)) {
            return;
        }
        unset($this->headers[$key]);
    }

    private function setToken()
    {
        if (\is_null($this->_apiuser)) {
            throw new Exception('The api user for ' . $this->_product . ' is note set: check setup guide to fix this error.');
        }
        if (\is_null($this->_api_key)) {
            throw new Exception('The api key for ' . $this->_product . ' is note set: check setup guide to fix this error.');
        }
        $token = $this->getCache()->get($this->_accessKey);
        if (!\is_null($token)) {
            $this->_accessToken = $token;
            $this->is_cached = true;
            return $this;
        }
        $this->requestToken();
    }

    public function shouldCache()
    { }

    public function getMomoBase()
    {
        return $this->_base_uri;
    }

    public function getUri($uri)
    {
        return $this->getMomoBase() . $this->_product . '/' . $this->_version . '/' . $uri;
    }

    public function getTokenUri()
    {
        return $this->getMomoBase() . $this->_product . "/" . MomoLinks::TOKEN_URI;
    }

    public function getAccountHolderUri()
    {
        return $this->getUri(MomoLinks::ACOUNT_HOLDER_URI);
    }

    public function getBalanceUri()
    {
        return $this->getUri(MomoLinks::BALANCE_URI);
    }

    public function getUserUri()
    {
        return $this->getMomoBase() . $this->_version . "/" . MomoLinks::USER_URI;
    }

    public function setApiToken($apiToken)
    {
        $this->_accessToken = $apiToken;
    }

    private function requestToken()
    {
        $this->setApiToken("");
        $this->setAuth();
        $response = $this->send($this->genRequest("POST", $this->getTokenUri()));

        $result = new TokenResponse($response);
        if ($result->isCreated()) {
            $this->getCache()->set($this->_accessKey, $result->getAccessToken(), $result->getExpiresIn());
            $this->setApiToken($result->getAccessToken());
        }
    }

    final  public function acountHolder($accountHolderIdType, $accountHolderId)
    {
        $this->setToken();
        $this->setAuth();
        return $this->send($this->genRequest("GET", $this->getAccountHolderUri() . $accountHolderIdType . '/' . $accountHolderId . '/active'));
    }
    /**
     * @return \LaMomo\Support\Responses\ApiUserResponse
     */
    public function createApiUser()
    {
        $uid = Str::uuid()->toString();
        $this->setHeaders(Constants::H_REF_ID, $uid);
        $this->removeHeader(Constants::H_AUTH);
        $this->removeHeader(Constants::H_ENVIRON);
        $body = ['providerCallbackHost' => $this->_hostname];
        $result = $this->send($this->genRequest("POST", $this->getUserUri(), $body));
        return new ApiUserResponse($result, $uid);
    }
    /**
     * @return \LaMomo\Support\Responses\ApiUserInfoResponse
     */
    public function getApiUser()
    {
        $this->removeHeader(Constants::H_AUTH);
        $this->removeHeader(Constants::H_ENVIRON);
        $result = $this->send($this->genRequest("GET", $this->getUserUri() . '/' . $this->_apiuser));
        return new ApiUserInfoResponse($result, $this->_apiuser);
    }

    public function getApikey()
    {
        $this->removeHeader(Constants::H_AUTH);
        $this->removeHeader(Constants::H_ENVIRON);
        $result = $this->send($this->genRequest("POST", $this->getUserUri() . '/' . $this->_apiuser . '/apikey'));
        return new ApiKeyResponse($result, $this->_apiuser);
    }
    public function setApiUser($apiuser)
    {
        $this->_apiuser = $apiuser;
    }
    public function setApiUKey($apikey)
    {
        $this->_api_key = $apikey;
    }
}
