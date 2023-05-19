<?php
/**
 * DeliveryEndpointsApi
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
 * DeliveryEndpointsApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class DeliveryEndpointsApi
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
        'acceptDeliveryCallback' => [
            'application/json',
        ],
        'cancelDeliveryCallback' => [
            'application/json',
        ],
        'deliveryCallbackError' => [
            'application/json',
        ],
        'requestDeliveryQuoteCallback' => [
            'application/json',
        ],
        'updateDeliveryRequestCallback' => [
            'application/json',
        ],
        'updateDeliveryStatus' => [
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
     * Operation acceptDeliveryCallback
     *
     * Notify the result of an accept delivery event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  string $delivery_reference_id delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest $accept_delivery_callback_request accept_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['acceptDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function acceptDeliveryCallback($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, string $contentType = self::contentTypes['acceptDeliveryCallback'][0])
    {
        $this->acceptDeliveryCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, $contentType);
    }

    /**
     * Operation acceptDeliveryCallbackWithHttpInfo
     *
     * Notify the result of an accept delivery event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest $accept_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['acceptDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function acceptDeliveryCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, string $contentType = self::contentTypes['acceptDeliveryCallback'][0])
    {
        $request = $this->acceptDeliveryCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, $contentType);

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
     * Operation acceptDeliveryCallbackAsync
     *
     * Notify the result of an accept delivery event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest $accept_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['acceptDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function acceptDeliveryCallbackAsync($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, string $contentType = self::contentTypes['acceptDeliveryCallback'][0])
    {
        return $this->acceptDeliveryCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation acceptDeliveryCallbackAsyncWithHttpInfo
     *
     * Notify the result of an accept delivery event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest $accept_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['acceptDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function acceptDeliveryCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, string $contentType = self::contentTypes['acceptDeliveryCallback'][0])
    {
        $returnType = '';
        $request = $this->acceptDeliveryCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, $contentType);

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
     * Create request for operation 'acceptDeliveryCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest $accept_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['acceptDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function acceptDeliveryCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request, string $contentType = self::contentTypes['acceptDeliveryCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling acceptDeliveryCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling acceptDeliveryCallback'
            );
        }

        // verify the required parameter 'delivery_reference_id' is set
        if ($delivery_reference_id === null || (is_array($delivery_reference_id) && count($delivery_reference_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delivery_reference_id when calling acceptDeliveryCallback'
            );
        }

        // verify the required parameter 'accept_delivery_callback_request' is set
        if ($accept_delivery_callback_request === null || (is_array($accept_delivery_callback_request) && count($accept_delivery_callback_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $accept_delivery_callback_request when calling acceptDeliveryCallback'
            );
        }


        $resourcePath = '/v1/delivery/{deliveryReferenceId}/accept';
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

        // path params
        if ($delivery_reference_id !== null) {
            $resourcePath = str_replace(
                '{' . 'deliveryReferenceId' . '}',
                ObjectSerializer::toPathValue($delivery_reference_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($accept_delivery_callback_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($accept_delivery_callback_request));
            } else {
                $httpBody = $accept_delivery_callback_request;
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
     * Operation cancelDeliveryCallback
     *
     * Notify the result of a cancel delivery event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  string $delivery_reference_id delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\CancelDeliveryCallbackRequest $cancel_delivery_callback_request cancel_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['cancelDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function cancelDeliveryCallback($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, string $contentType = self::contentTypes['cancelDeliveryCallback'][0])
    {
        $this->cancelDeliveryCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, $contentType);
    }

    /**
     * Operation cancelDeliveryCallbackWithHttpInfo
     *
     * Notify the result of a cancel delivery event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\CancelDeliveryCallbackRequest $cancel_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['cancelDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function cancelDeliveryCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, string $contentType = self::contentTypes['cancelDeliveryCallback'][0])
    {
        $request = $this->cancelDeliveryCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, $contentType);

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
     * Operation cancelDeliveryCallbackAsync
     *
     * Notify the result of a cancel delivery event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\CancelDeliveryCallbackRequest $cancel_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['cancelDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function cancelDeliveryCallbackAsync($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, string $contentType = self::contentTypes['cancelDeliveryCallback'][0])
    {
        return $this->cancelDeliveryCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation cancelDeliveryCallbackAsyncWithHttpInfo
     *
     * Notify the result of a cancel delivery event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\CancelDeliveryCallbackRequest $cancel_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['cancelDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function cancelDeliveryCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, string $contentType = self::contentTypes['cancelDeliveryCallback'][0])
    {
        $returnType = '';
        $request = $this->cancelDeliveryCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, $contentType);

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
     * Create request for operation 'cancelDeliveryCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\CancelDeliveryCallbackRequest $cancel_delivery_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['cancelDeliveryCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function cancelDeliveryCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request, string $contentType = self::contentTypes['cancelDeliveryCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling cancelDeliveryCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling cancelDeliveryCallback'
            );
        }

        // verify the required parameter 'delivery_reference_id' is set
        if ($delivery_reference_id === null || (is_array($delivery_reference_id) && count($delivery_reference_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delivery_reference_id when calling cancelDeliveryCallback'
            );
        }

        // verify the required parameter 'cancel_delivery_callback_request' is set
        if ($cancel_delivery_callback_request === null || (is_array($cancel_delivery_callback_request) && count($cancel_delivery_callback_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $cancel_delivery_callback_request when calling cancelDeliveryCallback'
            );
        }


        $resourcePath = '/v1/delivery/{deliveryReferenceId}/cancel';
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

        // path params
        if ($delivery_reference_id !== null) {
            $resourcePath = str_replace(
                '{' . 'deliveryReferenceId' . '}',
                ObjectSerializer::toPathValue($delivery_reference_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($cancel_delivery_callback_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($cancel_delivery_callback_request));
            } else {
                $httpBody = $cancel_delivery_callback_request;
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
     * Operation deliveryCallbackError
     *
     * Publish delivery callback error
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  \OpenAPI\Client\Model\EventCallbackError $event_callback_error event_callback_error (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['deliveryCallbackError'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function deliveryCallbackError($x_store_id, $x_event_id, $event_callback_error, string $contentType = self::contentTypes['deliveryCallbackError'][0])
    {
        $this->deliveryCallbackErrorWithHttpInfo($x_store_id, $x_event_id, $event_callback_error, $contentType);
    }

    /**
     * Operation deliveryCallbackErrorWithHttpInfo
     *
     * Publish delivery callback error
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\EventCallbackError $event_callback_error (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['deliveryCallbackError'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function deliveryCallbackErrorWithHttpInfo($x_store_id, $x_event_id, $event_callback_error, string $contentType = self::contentTypes['deliveryCallbackError'][0])
    {
        $request = $this->deliveryCallbackErrorRequest($x_store_id, $x_event_id, $event_callback_error, $contentType);

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
     * Operation deliveryCallbackErrorAsync
     *
     * Publish delivery callback error
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\EventCallbackError $event_callback_error (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['deliveryCallbackError'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deliveryCallbackErrorAsync($x_store_id, $x_event_id, $event_callback_error, string $contentType = self::contentTypes['deliveryCallbackError'][0])
    {
        return $this->deliveryCallbackErrorAsyncWithHttpInfo($x_store_id, $x_event_id, $event_callback_error, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation deliveryCallbackErrorAsyncWithHttpInfo
     *
     * Publish delivery callback error
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\EventCallbackError $event_callback_error (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['deliveryCallbackError'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deliveryCallbackErrorAsyncWithHttpInfo($x_store_id, $x_event_id, $event_callback_error, string $contentType = self::contentTypes['deliveryCallbackError'][0])
    {
        $returnType = '';
        $request = $this->deliveryCallbackErrorRequest($x_store_id, $x_event_id, $event_callback_error, $contentType);

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
     * Create request for operation 'deliveryCallbackError'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  \OpenAPI\Client\Model\EventCallbackError $event_callback_error (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['deliveryCallbackError'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function deliveryCallbackErrorRequest($x_store_id, $x_event_id, $event_callback_error, string $contentType = self::contentTypes['deliveryCallbackError'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling deliveryCallbackError'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling deliveryCallbackError'
            );
        }

        // verify the required parameter 'event_callback_error' is set
        if ($event_callback_error === null || (is_array($event_callback_error) && count($event_callback_error) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $event_callback_error when calling deliveryCallbackError'
            );
        }


        $resourcePath = '/v1/delivery/callback/error';
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
        if (isset($event_callback_error)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($event_callback_error));
            } else {
                $httpBody = $event_callback_error;
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
     * Operation requestDeliveryQuoteCallback
     *
     * Notify the result of a request delivery quote event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  string $delivery_reference_id delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest $request_delivery_quote_callback_request request_delivery_quote_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['requestDeliveryQuoteCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function requestDeliveryQuoteCallback($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, string $contentType = self::contentTypes['requestDeliveryQuoteCallback'][0])
    {
        $this->requestDeliveryQuoteCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, $contentType);
    }

    /**
     * Operation requestDeliveryQuoteCallbackWithHttpInfo
     *
     * Notify the result of a request delivery quote event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest $request_delivery_quote_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['requestDeliveryQuoteCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function requestDeliveryQuoteCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, string $contentType = self::contentTypes['requestDeliveryQuoteCallback'][0])
    {
        $request = $this->requestDeliveryQuoteCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, $contentType);

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
     * Operation requestDeliveryQuoteCallbackAsync
     *
     * Notify the result of a request delivery quote event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest $request_delivery_quote_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['requestDeliveryQuoteCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function requestDeliveryQuoteCallbackAsync($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, string $contentType = self::contentTypes['requestDeliveryQuoteCallback'][0])
    {
        return $this->requestDeliveryQuoteCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation requestDeliveryQuoteCallbackAsyncWithHttpInfo
     *
     * Notify the result of a request delivery quote event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest $request_delivery_quote_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['requestDeliveryQuoteCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function requestDeliveryQuoteCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, string $contentType = self::contentTypes['requestDeliveryQuoteCallback'][0])
    {
        $returnType = '';
        $request = $this->requestDeliveryQuoteCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, $contentType);

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
     * Create request for operation 'requestDeliveryQuoteCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest $request_delivery_quote_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['requestDeliveryQuoteCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function requestDeliveryQuoteCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request, string $contentType = self::contentTypes['requestDeliveryQuoteCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling requestDeliveryQuoteCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling requestDeliveryQuoteCallback'
            );
        }

        // verify the required parameter 'delivery_reference_id' is set
        if ($delivery_reference_id === null || (is_array($delivery_reference_id) && count($delivery_reference_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delivery_reference_id when calling requestDeliveryQuoteCallback'
            );
        }

        // verify the required parameter 'request_delivery_quote_callback_request' is set
        if ($request_delivery_quote_callback_request === null || (is_array($request_delivery_quote_callback_request) && count($request_delivery_quote_callback_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $request_delivery_quote_callback_request when calling requestDeliveryQuoteCallback'
            );
        }


        $resourcePath = '/v1/delivery/{deliveryReferenceId}/quotes';
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

        // path params
        if ($delivery_reference_id !== null) {
            $resourcePath = str_replace(
                '{' . 'deliveryReferenceId' . '}',
                ObjectSerializer::toPathValue($delivery_reference_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($request_delivery_quote_callback_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($request_delivery_quote_callback_request));
            } else {
                $httpBody = $request_delivery_quote_callback_request;
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
     * Operation updateDeliveryRequestCallback
     *
     * Notify the result of an update delivery request event
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $x_event_id x_event_id (required)
     * @param  string $delivery_reference_id delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest $update_delivery_request_callback_request update_delivery_request_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryRequestCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function updateDeliveryRequestCallback($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, string $contentType = self::contentTypes['updateDeliveryRequestCallback'][0])
    {
        $this->updateDeliveryRequestCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, $contentType);
    }

    /**
     * Operation updateDeliveryRequestCallbackWithHttpInfo
     *
     * Notify the result of an update delivery request event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest $update_delivery_request_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryRequestCallback'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateDeliveryRequestCallbackWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, string $contentType = self::contentTypes['updateDeliveryRequestCallback'][0])
    {
        $request = $this->updateDeliveryRequestCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, $contentType);

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
     * Operation updateDeliveryRequestCallbackAsync
     *
     * Notify the result of an update delivery request event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest $update_delivery_request_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryRequestCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateDeliveryRequestCallbackAsync($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, string $contentType = self::contentTypes['updateDeliveryRequestCallback'][0])
    {
        return $this->updateDeliveryRequestCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateDeliveryRequestCallbackAsyncWithHttpInfo
     *
     * Notify the result of an update delivery request event
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest $update_delivery_request_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryRequestCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateDeliveryRequestCallbackAsyncWithHttpInfo($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, string $contentType = self::contentTypes['updateDeliveryRequestCallback'][0])
    {
        $returnType = '';
        $request = $this->updateDeliveryRequestCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, $contentType);

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
     * Create request for operation 'updateDeliveryRequestCallback'
     *
     * @param  string $x_store_id (required)
     * @param  string $x_event_id (required)
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest $update_delivery_request_callback_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryRequestCallback'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateDeliveryRequestCallbackRequest($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request, string $contentType = self::contentTypes['updateDeliveryRequestCallback'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling updateDeliveryRequestCallback'
            );
        }

        // verify the required parameter 'x_event_id' is set
        if ($x_event_id === null || (is_array($x_event_id) && count($x_event_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_event_id when calling updateDeliveryRequestCallback'
            );
        }

        // verify the required parameter 'delivery_reference_id' is set
        if ($delivery_reference_id === null || (is_array($delivery_reference_id) && count($delivery_reference_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delivery_reference_id when calling updateDeliveryRequestCallback'
            );
        }

        // verify the required parameter 'update_delivery_request_callback_request' is set
        if ($update_delivery_request_callback_request === null || (is_array($update_delivery_request_callback_request) && count($update_delivery_request_callback_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $update_delivery_request_callback_request when calling updateDeliveryRequestCallback'
            );
        }


        $resourcePath = '/v1/delivery/{deliveryReferenceId}/update';
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

        // path params
        if ($delivery_reference_id !== null) {
            $resourcePath = str_replace(
                '{' . 'deliveryReferenceId' . '}',
                ObjectSerializer::toPathValue($delivery_reference_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($update_delivery_request_callback_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($update_delivery_request_callback_request));
            } else {
                $httpBody = $update_delivery_request_callback_request;
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
     * Operation updateDeliveryStatus
     *
     * Update delivery status
     *
     * @param  string $delivery_reference_id delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\DeliveryStatusUpdateRequest $delivery_status_update_request delivery_status_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryStatus'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function updateDeliveryStatus($delivery_reference_id, $delivery_status_update_request, string $contentType = self::contentTypes['updateDeliveryStatus'][0])
    {
        $this->updateDeliveryStatusWithHttpInfo($delivery_reference_id, $delivery_status_update_request, $contentType);
    }

    /**
     * Operation updateDeliveryStatusWithHttpInfo
     *
     * Update delivery status
     *
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\DeliveryStatusUpdateRequest $delivery_status_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryStatus'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateDeliveryStatusWithHttpInfo($delivery_reference_id, $delivery_status_update_request, string $contentType = self::contentTypes['updateDeliveryStatus'][0])
    {
        $request = $this->updateDeliveryStatusRequest($delivery_reference_id, $delivery_status_update_request, $contentType);

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
     * Operation updateDeliveryStatusAsync
     *
     * Update delivery status
     *
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\DeliveryStatusUpdateRequest $delivery_status_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateDeliveryStatusAsync($delivery_reference_id, $delivery_status_update_request, string $contentType = self::contentTypes['updateDeliveryStatus'][0])
    {
        return $this->updateDeliveryStatusAsyncWithHttpInfo($delivery_reference_id, $delivery_status_update_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateDeliveryStatusAsyncWithHttpInfo
     *
     * Update delivery status
     *
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\DeliveryStatusUpdateRequest $delivery_status_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateDeliveryStatusAsyncWithHttpInfo($delivery_reference_id, $delivery_status_update_request, string $contentType = self::contentTypes['updateDeliveryStatus'][0])
    {
        $returnType = '';
        $request = $this->updateDeliveryStatusRequest($delivery_reference_id, $delivery_status_update_request, $contentType);

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
     * Create request for operation 'updateDeliveryStatus'
     *
     * @param  string $delivery_reference_id (required)
     * @param  \OpenAPI\Client\Model\DeliveryStatusUpdateRequest $delivery_status_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateDeliveryStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateDeliveryStatusRequest($delivery_reference_id, $delivery_status_update_request, string $contentType = self::contentTypes['updateDeliveryStatus'][0])
    {

        // verify the required parameter 'delivery_reference_id' is set
        if ($delivery_reference_id === null || (is_array($delivery_reference_id) && count($delivery_reference_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delivery_reference_id when calling updateDeliveryStatus'
            );
        }

        // verify the required parameter 'delivery_status_update_request' is set
        if ($delivery_status_update_request === null || (is_array($delivery_status_update_request) && count($delivery_status_update_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delivery_status_update_request when calling updateDeliveryStatus'
            );
        }


        $resourcePath = '/v1/delivery/{deliveryReferenceId}/status';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($delivery_reference_id !== null) {
            $resourcePath = str_replace(
                '{' . 'deliveryReferenceId' . '}',
                ObjectSerializer::toPathValue($delivery_reference_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($delivery_status_update_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($delivery_status_update_request));
            } else {
                $httpBody = $delivery_status_update_request;
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
            'PUT',
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
