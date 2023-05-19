<?php
/**
 * MenusEndpointsApi
 * PHP version 7.4
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Public API
 *
 * # Overview  The API endpoints are developed around [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) principles secure via the OAuth2.0 protocol.  Beyond the entry points, the API also provides a line of communication into your system via [webhooks](https://en.wikipedia.org/wiki/Webhook).  For testing purposes, we offer a staging environment. Also, more detailed information about the business rules and workflows can be found on the [**Documentation Section**](/docs/)  ## Versioning Each API is versioned individually, but we follow these rules: - Non breaking changes (eg: adding new fields) are added in the current version without previous communication - Breaking changes (fields removal, semantic changed or schema update) have the version incremented - Users will be notified about new versions and will be given time to migrate (the time will be set on a case by case basis) - Once users migrate to the new version, we will deprecate the old ones - Once there is a new version for an API, we won't accept new integrations targeting old versions  ## API General Definitions The APIs use resource-oriented URLs communicating, primarily, via JSON and leveraging the HTTP headers, [response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status), and verbs.  To exemplify how the API is to be consumed, consider a fake GET resource endpoint invocation below:  ``` curl --request GET 'https://{{public-api-url}}/v1/resource/123' \\ --header 'Authorization: Bearer 34fdabeeafds=' --header 'X-Store-Id: 321' ```  |      Header      | Description | | ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | |`Authorization`   | Standard HTTP header is used to associate the request with the originating invoker. The content of this header is a `Bearer` token generated from you client_secret, defined in the [API Auth](#/section/Guides/API-Auth) guide.| |`X-Store-Id`      | The ID of the store in your system this call acts on behalf of. |  _All resource endpoints expect the `Authorization` header, the remaining headers are explicitly stated in the individual endpoint documentation section._  With these headers, the system will:  - Validate the client token, making sure the call is originating from a trusted source.  - Validate that the Application has the permission to access the `v1/resource/{id}` resource via the Application's pre-configured scopes.  - Translate your X-Store-Id to our internal store ID (e.g. `AAA`).  - Validate and retrieve resource `AAA`, that is associated to your Application via store id `321`.  POST/PUT methods will look similar to the GET calls, but they'll take in a body in the HTTP request (default to the application/json content-type).  ``` curl --location --request POST 'https://{{public-api-url}}/v1/resource' \\ --header 'Authorization: Bearer 34fdabeeafds=' --header 'X-Store-Id: 321' --data '{\"foo\": \"bar\"}' ```  ## API Authentication/Authorization  <SecurityDefinitions />  The **Authorization API** is based on the [OAuth2.0 protocol](https://tools.ietf.org/html/rfc6749), using the [client credentials grant](https://tools.ietf.org/html/rfc6749#section-4.4). Resources expect a valid token sent as a `Bearer` token in the HTTP `Authorization` header.  To generate the token, use the `Application ID` and `Client Secret` (provided during onboarding) to the [Token Auth endpoint](#operation/requestToken) endpoint. The result of this invocation is a token that is valid for a pre-determined time or until it is manually revoked.  The response of the following endpoints will return a token that will be sent as a `Bearer` value of the `Authorization` HTTP header, along with meta information such as expiry-date.  _Note that the referred `client_id` is the `Application ID` because though we chose adhere to the OAuth2.0 standard for the auth APIs._  ### Request Examples  #### URL Encoded Form  The API exposes a token generation endpoint expects your *client_id* and *client_secret* to be formatted as *application/x-www-form-urlencoded* content type. ``` curl --location --request POST 'https://{{public-api-url}}/v1/auth/token' \\ --header 'Content-Type: application/x-www-form-urlencoded' \\ --data-urlencode 'scope=ping' \\ --data-urlencode 'grant_type=client_credentials' \\ --data-urlencode 'client_id=[APPLICATION_ID]' \\ --data-urlencode 'client_secret=[CLIENT_SECRET]' ```  #### HTTP Basic Auth  Alternatively, the API also accepts a `Basic` Authorization header with the Base64 encoding of the `client_id` (`Application ID`) and `client_secret` joined by a single colon `:`.  ``` BASE64_ENCODED_CREDENTIALS = base64_encode(client_id + \":\" + client_secret) ```  ``` curl --location --request POST 'https://{{public-api-url}}/v1/auth/token' \\ --header 'Authorization: Basic [BASE64_ENCODED_CREDENTIALS]' \\ --header 'Content-Type: application/x-www-form-urlencoded' \\ --data-urlencode 'scope=ping' \\ --data-urlencode 'grant_type=client_credentials' ```  ## Webhook  The Public API is able to send notifications to your system via HTTP POST requests.  Every webhook is signed using HMAC-SHA256 that is present in the header `X-HMAC-SHA256`, and you can also authenticate the requests using Basic Auth, Bearer Token or HMAC-SHA1 (legacy). Please, refer to [**Webhook Authentication Guide**](/docs/guides-webhook-authentication/) for more details.  _Please work with your Account Representative to setup your Application's Webhook configurations._  ``` Example Base-URL = https://{{your-server-url}}/webhook ```  ### Notification Schema  | **Name**                | **Type** | **Description**                                                      | | ------------------------| ---------| -------------------------------------------------------------------- | | eventId                 | string   | Unique id of the event.                                              | | eventTime               | string   | The time the event occurred.                                         | | eventType               | string   | The type of event (e.g. create_order).                               | | metadata.storeId        | string   | Id of the store for which the event is being published.              | | metadata.applicationId  | string   | Id of the application for which the event is being published.        | | metadata.resourceId     | string   | The external identifier of the resource that this event refers to.   | | metadata.resourceHref   | string   | The endpoint to fetch the details of the resource.                   | | metadata.payload        | object   | The event object which will be detailed in each Webhook description. |  ### Notification Request Example  ``` curl --location --request POST 'https://{{your-server-url}}/webhook' \\ --header 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36' \\ --header 'Authorization: MAC <hash signature>' \\ --header 'Content-Type: application/json' \\ --data-raw '{    \"eventId\": \"123456\",    \"eventTime\": \"2020-10-10T20:06:02:123Z\",    \"eventType\": \"orders.new_order\",    \"metadata\": {       \"storeId\": \"755fd19a-7562-487a-b615-171a9f89d669\",       \"applicationId\": \"e22f94b3-967c-4e26-bf39-9e364066b68b\",       \"resourceHref\": \"https://{{public-api-url}}/v1/orders/bf9f1d81-f213-496e-a026-91b6af44996c\",       \"resourceId\": \"bf9f1d81-f213-496e-a026-91b6af44996c\",       \"payload\": {}    } } ```  ## Expected Response  The partner application should return an HTTP 200 response code with an empty response body to acknowledge receipt of the webhook event. ## Rate Limiting Please, refer to [**Rate Limiting Guide**](/docs/guides-rate-limiting/) for more details.
 *
 * The version of the OpenAPI document: v1
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.6.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OpenAPI\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use OpenAPI\Client\ApiException;
use OpenAPI\Client\Configuration;
use OpenAPI\Client\HeaderSelector;
use OpenAPI\Client\ObjectSerializer;

/**
 * MenusEndpointsApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class MenusEndpointsApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /** @var string[] $contentTypes **/
    public const contentTypes = [
        'menuPublishCallback' => [
            'application/json',
        ],
        'menuSendCallback' => [
            'application/json',
        ],
        'menuUpsertHours' => [
            'application/json',
        ],
        'updateMenuEntitiesAvailabilitiesCallback' => [
            'application/json',
        ],
        'upsertMenu' => [
            'application/json',
        ],
    ];

/**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $hostIndex (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index (required)
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation menuPublishCallback
     *
     * Notify the result of a Publish Menu event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  \OpenAPI\Client\Model\UpsertFullMenuEventCallback $upsert_full_menu_event_callback upsert_full_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuPublishCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function menuPublishCallback($x_store_id, $x_event_id, $upsert_full_menu_event_callback, string $contentType = self::contentTypes['menuPublishCallback'][0])
    {
        $this->menuPublishCallbackWithHttpInfo($x_store_id, $x_event_id, $upsert_full_menu_event_callback, $contentType);
    }

    /**
     * Operation menuPublishCallbackWithHttpInfo
     *
     * Notify the result of a Publish Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\UpsertFullMenuEventCallback $upsert_full_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuPublishCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function menuPublishCallbackWithHttpInfo($x_store_id, $x_event_id, $upsert_full_menu_event_callback, string $contentType = self::contentTypes['menuPublishCallback'][0])
    {
        $request = $this->menuPublishCallbackRequest($x_store_id, $x_event_id, $upsert_full_menu_event_callback, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation menuPublishCallbackAsync
     *
     * Notify the result of a Publish Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\UpsertFullMenuEventCallback $upsert_full_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuPublishCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function menuPublishCallbackAsync($x_store_id, $x_event_id, $upsert_full_menu_event_callback, string $contentType = self::contentTypes['menuPublishCallback'][0])
    {
        return $this->menuPublishCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $upsert_full_menu_event_callback, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation menuPublishCallbackAsyncWithHttpInfo
     *
     * Notify the result of a Publish Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\UpsertFullMenuEventCallback $upsert_full_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuPublishCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function menuPublishCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $upsert_full_menu_event_callback, string $contentType = self::contentTypes['menuPublishCallback'][0])
    {
        $returnType = '';
        $request = $this->menuPublishCallbackRequest($x_store_id, $x_event_id, $upsert_full_menu_event_callback, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'menuPublishCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\UpsertFullMenuEventCallback $upsert_full_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuPublishCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function menuPublishCallbackRequest($x_store_id, $x_event_id, $upsert_full_menu_event_callback, string $contentType = self::contentTypes['menuPublishCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling menuPublishCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling menuPublishCallback'
            );
        }

        // verify the required parameter 'upsert_full_menu_event_callback' is set
        if ($upsert_full_menu_event_callback === null || (is_array($upsert_full_menu_event_callback) && count($upsert_full_menu_event_callback) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $upsert_full_menu_event_callback when calling menuPublishCallback'
            );
        }


        $resourcePath = '/v1/menus/publish';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }
        // header params
        if ($x_event_id !== null) {
            $headerParams['X-Event-Id'] = ObjectSerializer::toHeaderValue($x_event_id);
        }



        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($upsert_full_menu_event_callback)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($upsert_full_menu_event_callback));
            } else {
                $httpBody = $upsert_full_menu_event_callback;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires OAuth (access token)
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation menuSendCallback
     *
     * Notify the result of a Send Menu event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  \OpenAPI\Client\Model\SendMenuEventCallback $send_menu_event_callback send_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuSendCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function menuSendCallback($x_store_id, $x_event_id, $send_menu_event_callback, string $contentType = self::contentTypes['menuSendCallback'][0])
    {
        $this->menuSendCallbackWithHttpInfo($x_store_id, $x_event_id, $send_menu_event_callback, $contentType);
    }

    /**
     * Operation menuSendCallbackWithHttpInfo
     *
     * Notify the result of a Send Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\SendMenuEventCallback $send_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuSendCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function menuSendCallbackWithHttpInfo($x_store_id, $x_event_id, $send_menu_event_callback, string $contentType = self::contentTypes['menuSendCallback'][0])
    {
        $request = $this->menuSendCallbackRequest($x_store_id, $x_event_id, $send_menu_event_callback, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation menuSendCallbackAsync
     *
     * Notify the result of a Send Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\SendMenuEventCallback $send_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuSendCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function menuSendCallbackAsync($x_store_id, $x_event_id, $send_menu_event_callback, string $contentType = self::contentTypes['menuSendCallback'][0])
    {
        return $this->menuSendCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $send_menu_event_callback, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation menuSendCallbackAsyncWithHttpInfo
     *
     * Notify the result of a Send Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\SendMenuEventCallback $send_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuSendCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function menuSendCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $send_menu_event_callback, string $contentType = self::contentTypes['menuSendCallback'][0])
    {
        $returnType = '';
        $request = $this->menuSendCallbackRequest($x_store_id, $x_event_id, $send_menu_event_callback, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'menuSendCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\SendMenuEventCallback $send_menu_event_callback (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuSendCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function menuSendCallbackRequest($x_store_id, $x_event_id, $send_menu_event_callback, string $contentType = self::contentTypes['menuSendCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling menuSendCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling menuSendCallback'
            );
        }

        // verify the required parameter 'send_menu_event_callback' is set
        if ($send_menu_event_callback === null || (is_array($send_menu_event_callback) && count($send_menu_event_callback) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $send_menu_event_callback when calling menuSendCallback'
            );
        }


        $resourcePath = '/v1/menus/current';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }
        // header params
        if ($x_event_id !== null) {
            $headerParams['X-Event-Id'] = ObjectSerializer::toHeaderValue($x_event_id);
        }



        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($send_menu_event_callback)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($send_menu_event_callback));
            } else {
                $httpBody = $send_menu_event_callback;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires OAuth (access token)
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation menuUpsertHours
     *
     * Notify the receival of a Upsert Hours Menu event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuUpsertHours'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function menuUpsertHours($x_store_id, $x_event_id, string $contentType = self::contentTypes['menuUpsertHours'][0])
    {
        $this->menuUpsertHoursWithHttpInfo($x_store_id, $x_event_id, $contentType);
    }

    /**
     * Operation menuUpsertHoursWithHttpInfo
     *
     * Notify the receival of a Upsert Hours Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuUpsertHours'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function menuUpsertHoursWithHttpInfo($x_store_id, $x_event_id, string $contentType = self::contentTypes['menuUpsertHours'][0])
    {
        $request = $this->menuUpsertHoursRequest($x_store_id, $x_event_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation menuUpsertHoursAsync
     *
     * Notify the receival of a Upsert Hours Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuUpsertHours'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function menuUpsertHoursAsync($x_store_id, $x_event_id, string $contentType = self::contentTypes['menuUpsertHours'][0])
    {
        return $this->menuUpsertHoursAsyncWithHttpInfo($x_store_id, $x_event_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation menuUpsertHoursAsyncWithHttpInfo
     *
     * Notify the receival of a Upsert Hours Menu event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuUpsertHours'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function menuUpsertHoursAsyncWithHttpInfo($x_store_id, $x_event_id, string $contentType = self::contentTypes['menuUpsertHours'][0])
    {
        $returnType = '';
        $request = $this->menuUpsertHoursRequest($x_store_id, $x_event_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'menuUpsertHours'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['menuUpsertHours'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function menuUpsertHoursRequest($x_store_id, $x_event_id, string $contentType = self::contentTypes['menuUpsertHours'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling menuUpsertHours'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling menuUpsertHours'
            );
        }


        $resourcePath = '/v1/menus/hours';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }
        // header params
        if ($x_event_id !== null) {
            $headerParams['X-Event-Id'] = ObjectSerializer::toHeaderValue($x_event_id);
        }



        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires OAuth (access token)
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation updateMenuEntitiesAvailabilitiesCallback
     *
     * Notify the result of a Update Menu Entities Availabilities event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function updateMenuEntitiesAvailabilitiesCallback($x_store_id, $x_event_id, string $contentType = self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'][0])
    {
        $this->updateMenuEntitiesAvailabilitiesCallbackWithHttpInfo($x_store_id, $x_event_id, $contentType);
    }

    /**
     * Operation updateMenuEntitiesAvailabilitiesCallbackWithHttpInfo
     *
     * Notify the result of a Update Menu Entities Availabilities event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateMenuEntitiesAvailabilitiesCallbackWithHttpInfo($x_store_id, $x_event_id, string $contentType = self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'][0])
    {
        $request = $this->updateMenuEntitiesAvailabilitiesCallbackRequest($x_store_id, $x_event_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation updateMenuEntitiesAvailabilitiesCallbackAsync
     *
     * Notify the result of a Update Menu Entities Availabilities event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateMenuEntitiesAvailabilitiesCallbackAsync($x_store_id, $x_event_id, string $contentType = self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'][0])
    {
        return $this->updateMenuEntitiesAvailabilitiesCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateMenuEntitiesAvailabilitiesCallbackAsyncWithHttpInfo
     *
     * Notify the result of a Update Menu Entities Availabilities event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateMenuEntitiesAvailabilitiesCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, string $contentType = self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'][0])
    {
        $returnType = '';
        $request = $this->updateMenuEntitiesAvailabilitiesCallbackRequest($x_store_id, $x_event_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'updateMenuEntitiesAvailabilitiesCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateMenuEntitiesAvailabilitiesCallbackRequest($x_store_id, $x_event_id, string $contentType = self::contentTypes['updateMenuEntitiesAvailabilitiesCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling updateMenuEntitiesAvailabilitiesCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling updateMenuEntitiesAvailabilitiesCallback'
            );
        }


        $resourcePath = '/v1/menus/entity/availability/bulk';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }
        // header params
        if ($x_event_id !== null) {
            $headerParams['X-Event-Id'] = ObjectSerializer::toHeaderValue($x_event_id);
        }



        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires OAuth (access token)
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation upsertMenu
     *
     * Upsert menus for a store
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  \OpenAPI\Client\Model\MenusUpsertRequest $menus_upsert_request menus_upsert_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['upsertMenu'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\MenuAsynchronousJob|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage
     */
    public function upsertMenu($x_store_id, $menus_upsert_request, string $contentType = self::contentTypes['upsertMenu'][0])
    {
        list($response) = $this->upsertMenuWithHttpInfo($x_store_id, $menus_upsert_request, $contentType);
        return $response;
    }

    /**
     * Operation upsertMenuWithHttpInfo
     *
     * Upsert menus for a store
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\MenusUpsertRequest $menus_upsert_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['upsertMenu'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\MenuAsynchronousJob|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage, HTTP status code, HTTP response headers (array of strings)
     */
    public function upsertMenuWithHttpInfo($x_store_id, $menus_upsert_request, string $contentType = self::contentTypes['upsertMenu'][0])
    {
        $request = $this->upsertMenuRequest($x_store_id, $menus_upsert_request, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 202:
                    if ('\OpenAPI\Client\Model\MenuAsynchronousJob' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\MenuAsynchronousJob' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\MenuAsynchronousJob', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\OpenAPI\Client\Model\ErrorMessage' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\ErrorMessage' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\ErrorMessage', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 401:
                    if ('\OpenAPI\Client\Model\ErrorMessage' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\ErrorMessage' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\ErrorMessage', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 403:
                    if ('\OpenAPI\Client\Model\ErrorMessage' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\ErrorMessage' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\ErrorMessage', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 404:
                    if ('\OpenAPI\Client\Model\ErrorMessage' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\ErrorMessage' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\ErrorMessage', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 422:
                    if ('\OpenAPI\Client\Model\ErrorMessage' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\ErrorMessage' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\ErrorMessage', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OpenAPI\Client\Model\MenuAsynchronousJob';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 202:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\MenuAsynchronousJob',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\ErrorMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation upsertMenuAsync
     *
     * Upsert menus for a store
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\MenusUpsertRequest $menus_upsert_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['upsertMenu'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function upsertMenuAsync($x_store_id, $menus_upsert_request, string $contentType = self::contentTypes['upsertMenu'][0])
    {
        return $this->upsertMenuAsyncWithHttpInfo($x_store_id, $menus_upsert_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation upsertMenuAsyncWithHttpInfo
     *
     * Upsert menus for a store
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\MenusUpsertRequest $menus_upsert_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['upsertMenu'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function upsertMenuAsyncWithHttpInfo($x_store_id, $menus_upsert_request, string $contentType = self::contentTypes['upsertMenu'][0])
    {
        $returnType = '\OpenAPI\Client\Model\MenuAsynchronousJob';
        $request = $this->upsertMenuRequest($x_store_id, $menus_upsert_request, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'upsertMenu'
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\MenusUpsertRequest $menus_upsert_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['upsertMenu'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function upsertMenuRequest($x_store_id, $menus_upsert_request, string $contentType = self::contentTypes['upsertMenu'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling upsertMenu'
            );
        }

        // verify the required parameter 'menus_upsert_request' is set
        if ($menus_upsert_request === null || (is_array($menus_upsert_request) && count($menus_upsert_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $menus_upsert_request when calling upsertMenu'
            );
        }


        $resourcePath = '/v1/menus';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }



        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($menus_upsert_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($menus_upsert_request));
            } else {
                $httpBody = $menus_upsert_request;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires OAuth (access token)
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
