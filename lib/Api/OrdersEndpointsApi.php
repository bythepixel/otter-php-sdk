<?php
/**
 * OrdersEndpointsApi
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
 * OpenAPI Generator version: 6.2.1
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
 * OrdersEndpointsApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class OrdersEndpointsApi
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
        'createOrder' => [
            'application/json',
        ],
        'updateOrder' => [
            'application/json',
        ],
        'updateOrderCustomerPayment' => [
            'application/json',
        ],
        'updateOrderDeliveryInfo' => [
            'application/json',
        ],
        'updateOrderStatus' => [
            'application/json',
        ],
        'uploadPastOrders' => [
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
     * Operation createOrder
     *
     * Create order
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  \OpenAPI\Client\Model\Order $order order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['createOrder'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\OrderReference|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage
     */
    public function createOrder($x_store_id, $order, string $contentType = self::contentTypes['createOrder'][0])
    {
        list($response) = $this->createOrderWithHttpInfo($x_store_id, $order, $contentType);
        return $response;
    }

    /**
     * Operation createOrderWithHttpInfo
     *
     * Create order
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['createOrder'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\OrderReference|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage, HTTP status code, HTTP response headers (array of strings)
     */
    public function createOrderWithHttpInfo($x_store_id, $order, string $contentType = self::contentTypes['createOrder'][0])
    {
        $request = $this->createOrderRequest($x_store_id, $order, $contentType);

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
                case 200:
                    if ('\OpenAPI\Client\Model\OrderReference' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\OrderReference' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\OrderReference', []),
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

            $returnType = '\OpenAPI\Client\Model\OrderReference';
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
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\OrderReference',
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
     * Operation createOrderAsync
     *
     * Create order
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['createOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createOrderAsync($x_store_id, $order, string $contentType = self::contentTypes['createOrder'][0])
    {
        return $this->createOrderAsyncWithHttpInfo($x_store_id, $order, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation createOrderAsyncWithHttpInfo
     *
     * Create order
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['createOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createOrderAsyncWithHttpInfo($x_store_id, $order, string $contentType = self::contentTypes['createOrder'][0])
    {
        $returnType = '\OpenAPI\Client\Model\OrderReference';
        $request = $this->createOrderRequest($x_store_id, $order, $contentType);

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
     * Create request for operation 'createOrder'
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['createOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function createOrderRequest($x_store_id, $order, string $contentType = self::contentTypes['createOrder'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling createOrder'
            );
        }

        // verify the required parameter 'order' is set
        if ($order === null || (is_array($order) && count($order) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order when calling createOrder'
            );
        }


        $resourcePath = '/v1/orders';
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
        if (isset($order)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($order));
            } else {
                $httpBody = $order;
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
                $httpBody = \GuzzleHttp\json_encode($formParams);
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
     * Operation updateOrder
     *
     * Update order
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $order_id order_id (required)
     * @param  \OpenAPI\Client\Model\Order $order order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrder'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\OrderReference|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage
     */
    public function updateOrder($x_store_id, $order_id, $order, string $contentType = self::contentTypes['updateOrder'][0])
    {
        list($response) = $this->updateOrderWithHttpInfo($x_store_id, $order_id, $order, $contentType);
        return $response;
    }

    /**
     * Operation updateOrderWithHttpInfo
     *
     * Update order
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrder'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\OrderReference|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateOrderWithHttpInfo($x_store_id, $order_id, $order, string $contentType = self::contentTypes['updateOrder'][0])
    {
        $request = $this->updateOrderRequest($x_store_id, $order_id, $order, $contentType);

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
                case 200:
                    if ('\OpenAPI\Client\Model\OrderReference' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\OrderReference' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\OrderReference', []),
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

            $returnType = '\OpenAPI\Client\Model\OrderReference';
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
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\OrderReference',
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
     * Operation updateOrderAsync
     *
     * Update order
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderAsync($x_store_id, $order_id, $order, string $contentType = self::contentTypes['updateOrder'][0])
    {
        return $this->updateOrderAsyncWithHttpInfo($x_store_id, $order_id, $order, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateOrderAsyncWithHttpInfo
     *
     * Update order
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderAsyncWithHttpInfo($x_store_id, $order_id, $order, string $contentType = self::contentTypes['updateOrder'][0])
    {
        $returnType = '\OpenAPI\Client\Model\OrderReference';
        $request = $this->updateOrderRequest($x_store_id, $order_id, $order, $contentType);

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
     * Create request for operation 'updateOrder'
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\Order $order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateOrderRequest($x_store_id, $order_id, $order, string $contentType = self::contentTypes['updateOrder'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling updateOrder'
            );
        }

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling updateOrder'
            );
        }

        // verify the required parameter 'order' is set
        if ($order === null || (is_array($order) && count($order) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order when calling updateOrder'
            );
        }


        $resourcePath = '/v1/orders/{orderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }

        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($order)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($order));
            } else {
                $httpBody = $order;
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
                $httpBody = \GuzzleHttp\json_encode($formParams);
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
     * Operation updateOrderCustomerPayment
     *
     * Update order customer payment
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $order_id order_id (required)
     * @param  \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest $order_customer_payment_update_request order_customer_payment_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderCustomerPayment'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function updateOrderCustomerPayment($x_store_id, $order_id, $order_customer_payment_update_request, string $contentType = self::contentTypes['updateOrderCustomerPayment'][0])
    {
        $this->updateOrderCustomerPaymentWithHttpInfo($x_store_id, $order_id, $order_customer_payment_update_request, $contentType);
    }

    /**
     * Operation updateOrderCustomerPaymentWithHttpInfo
     *
     * Update order customer payment
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest $order_customer_payment_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderCustomerPayment'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateOrderCustomerPaymentWithHttpInfo($x_store_id, $order_id, $order_customer_payment_update_request, string $contentType = self::contentTypes['updateOrderCustomerPayment'][0])
    {
        $request = $this->updateOrderCustomerPaymentRequest($x_store_id, $order_id, $order_customer_payment_update_request, $contentType);

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
     * Operation updateOrderCustomerPaymentAsync
     *
     * Update order customer payment
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest $order_customer_payment_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderCustomerPayment'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderCustomerPaymentAsync($x_store_id, $order_id, $order_customer_payment_update_request, string $contentType = self::contentTypes['updateOrderCustomerPayment'][0])
    {
        return $this->updateOrderCustomerPaymentAsyncWithHttpInfo($x_store_id, $order_id, $order_customer_payment_update_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateOrderCustomerPaymentAsyncWithHttpInfo
     *
     * Update order customer payment
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest $order_customer_payment_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderCustomerPayment'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderCustomerPaymentAsyncWithHttpInfo($x_store_id, $order_id, $order_customer_payment_update_request, string $contentType = self::contentTypes['updateOrderCustomerPayment'][0])
    {
        $returnType = '';
        $request = $this->updateOrderCustomerPaymentRequest($x_store_id, $order_id, $order_customer_payment_update_request, $contentType);

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
     * Create request for operation 'updateOrderCustomerPayment'
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest $order_customer_payment_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderCustomerPayment'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateOrderCustomerPaymentRequest($x_store_id, $order_id, $order_customer_payment_update_request, string $contentType = self::contentTypes['updateOrderCustomerPayment'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling updateOrderCustomerPayment'
            );
        }

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling updateOrderCustomerPayment'
            );
        }

        // verify the required parameter 'order_customer_payment_update_request' is set
        if ($order_customer_payment_update_request === null || (is_array($order_customer_payment_update_request) && count($order_customer_payment_update_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_customer_payment_update_request when calling updateOrderCustomerPayment'
            );
        }


        $resourcePath = '/v1/orders/{orderId}/payments';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }

        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($order_customer_payment_update_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($order_customer_payment_update_request));
            } else {
                $httpBody = $order_customer_payment_update_request;
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
                $httpBody = \GuzzleHttp\json_encode($formParams);
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
     * Operation updateOrderDeliveryInfo
     *
     * Update order delivery information
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $order_id order_id (required)
     * @param  \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest $order_delivery_info_update_request order_delivery_info_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderDeliveryInfo'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function updateOrderDeliveryInfo($x_store_id, $order_id, $order_delivery_info_update_request, string $contentType = self::contentTypes['updateOrderDeliveryInfo'][0])
    {
        $this->updateOrderDeliveryInfoWithHttpInfo($x_store_id, $order_id, $order_delivery_info_update_request, $contentType);
    }

    /**
     * Operation updateOrderDeliveryInfoWithHttpInfo
     *
     * Update order delivery information
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest $order_delivery_info_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderDeliveryInfo'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateOrderDeliveryInfoWithHttpInfo($x_store_id, $order_id, $order_delivery_info_update_request, string $contentType = self::contentTypes['updateOrderDeliveryInfo'][0])
    {
        $request = $this->updateOrderDeliveryInfoRequest($x_store_id, $order_id, $order_delivery_info_update_request, $contentType);

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
     * Operation updateOrderDeliveryInfoAsync
     *
     * Update order delivery information
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest $order_delivery_info_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderDeliveryInfo'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderDeliveryInfoAsync($x_store_id, $order_id, $order_delivery_info_update_request, string $contentType = self::contentTypes['updateOrderDeliveryInfo'][0])
    {
        return $this->updateOrderDeliveryInfoAsyncWithHttpInfo($x_store_id, $order_id, $order_delivery_info_update_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateOrderDeliveryInfoAsyncWithHttpInfo
     *
     * Update order delivery information
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest $order_delivery_info_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderDeliveryInfo'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderDeliveryInfoAsyncWithHttpInfo($x_store_id, $order_id, $order_delivery_info_update_request, string $contentType = self::contentTypes['updateOrderDeliveryInfo'][0])
    {
        $returnType = '';
        $request = $this->updateOrderDeliveryInfoRequest($x_store_id, $order_id, $order_delivery_info_update_request, $contentType);

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
     * Create request for operation 'updateOrderDeliveryInfo'
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest $order_delivery_info_update_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderDeliveryInfo'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateOrderDeliveryInfoRequest($x_store_id, $order_id, $order_delivery_info_update_request, string $contentType = self::contentTypes['updateOrderDeliveryInfo'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling updateOrderDeliveryInfo'
            );
        }

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling updateOrderDeliveryInfo'
            );
        }

        // verify the required parameter 'order_delivery_info_update_request' is set
        if ($order_delivery_info_update_request === null || (is_array($order_delivery_info_update_request) && count($order_delivery_info_update_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_delivery_info_update_request when calling updateOrderDeliveryInfo'
            );
        }


        $resourcePath = '/v1/orders/{orderId}/delivery';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_store_id !== null) {
            $headerParams['X-Store-Id'] = ObjectSerializer::toHeaderValue($x_store_id);
        }

        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($order_delivery_info_update_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($order_delivery_info_update_request));
            } else {
                $httpBody = $order_delivery_info_update_request;
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
                $httpBody = \GuzzleHttp\json_encode($formParams);
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
     * Operation updateOrderStatus
     *
     * Update order status
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  string $order_id order_id (required)
     * @param  \OpenAPI\Client\Model\OrderStatusUpdateRequest $order_status_update_request order_status_update_request (required)
     * @param  string $x_event_id x_event_id (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderStatus'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function updateOrderStatus($x_store_id, $order_id, $order_status_update_request, $x_event_id = null, string $contentType = self::contentTypes['updateOrderStatus'][0])
    {
        $this->updateOrderStatusWithHttpInfo($x_store_id, $order_id, $order_status_update_request, $x_event_id, $contentType);
    }

    /**
     * Operation updateOrderStatusWithHttpInfo
     *
     * Update order status
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderStatusUpdateRequest $order_status_update_request (required)
     * @param  string $x_event_id (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderStatus'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateOrderStatusWithHttpInfo($x_store_id, $order_id, $order_status_update_request, $x_event_id = null, string $contentType = self::contentTypes['updateOrderStatus'][0])
    {
        $request = $this->updateOrderStatusRequest($x_store_id, $order_id, $order_status_update_request, $x_event_id, $contentType);

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
     * Operation updateOrderStatusAsync
     *
     * Update order status
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderStatusUpdateRequest $order_status_update_request (required)
     * @param  string $x_event_id (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderStatusAsync($x_store_id, $order_id, $order_status_update_request, $x_event_id = null, string $contentType = self::contentTypes['updateOrderStatus'][0])
    {
        return $this->updateOrderStatusAsyncWithHttpInfo($x_store_id, $order_id, $order_status_update_request, $x_event_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation updateOrderStatusAsyncWithHttpInfo
     *
     * Update order status
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderStatusUpdateRequest $order_status_update_request (required)
     * @param  string $x_event_id (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function updateOrderStatusAsyncWithHttpInfo($x_store_id, $order_id, $order_status_update_request, $x_event_id = null, string $contentType = self::contentTypes['updateOrderStatus'][0])
    {
        $returnType = '';
        $request = $this->updateOrderStatusRequest($x_store_id, $order_id, $order_status_update_request, $x_event_id, $contentType);

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
     * Create request for operation 'updateOrderStatus'
     *
     * @param  string $x_store_id (required)
     * @param  string $order_id (required)
     * @param  \OpenAPI\Client\Model\OrderStatusUpdateRequest $order_status_update_request (required)
     * @param  string $x_event_id (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['updateOrderStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function updateOrderStatusRequest($x_store_id, $order_id, $order_status_update_request, $x_event_id = null, string $contentType = self::contentTypes['updateOrderStatus'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling updateOrderStatus'
            );
        }

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling updateOrderStatus'
            );
        }

        // verify the required parameter 'order_status_update_request' is set
        if ($order_status_update_request === null || (is_array($order_status_update_request) && count($order_status_update_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_status_update_request when calling updateOrderStatus'
            );
        }



        $resourcePath = '/v1/orders/{orderId}/status';
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
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($order_status_update_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($order_status_update_request));
            } else {
                $httpBody = $order_status_update_request;
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
                $httpBody = \GuzzleHttp\json_encode($formParams);
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
     * Operation uploadPastOrders
     *
     * Upload past orders
     *
     * @param  string $x_store_id x_store_id (required)
     * @param  \OpenAPI\Client\Model\UploadPastOrdersRequest $upload_past_orders_request upload_past_orders_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['uploadPastOrders'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\UploadPastOrdersResponse|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage
     */
    public function uploadPastOrders($x_store_id, $upload_past_orders_request, string $contentType = self::contentTypes['uploadPastOrders'][0])
    {
        list($response) = $this->uploadPastOrdersWithHttpInfo($x_store_id, $upload_past_orders_request, $contentType);
        return $response;
    }

    /**
     * Operation uploadPastOrdersWithHttpInfo
     *
     * Upload past orders
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\UploadPastOrdersRequest $upload_past_orders_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['uploadPastOrders'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\UploadPastOrdersResponse|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage|\OpenAPI\Client\Model\ErrorMessage, HTTP status code, HTTP response headers (array of strings)
     */
    public function uploadPastOrdersWithHttpInfo($x_store_id, $upload_past_orders_request, string $contentType = self::contentTypes['uploadPastOrders'][0])
    {
        $request = $this->uploadPastOrdersRequest($x_store_id, $upload_past_orders_request, $contentType);

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
                case 200:
                    if ('\OpenAPI\Client\Model\UploadPastOrdersResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\UploadPastOrdersResponse' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\UploadPastOrdersResponse', []),
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

            $returnType = '\OpenAPI\Client\Model\UploadPastOrdersResponse';
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
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\UploadPastOrdersResponse',
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
     * Operation uploadPastOrdersAsync
     *
     * Upload past orders
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\UploadPastOrdersRequest $upload_past_orders_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['uploadPastOrders'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function uploadPastOrdersAsync($x_store_id, $upload_past_orders_request, string $contentType = self::contentTypes['uploadPastOrders'][0])
    {
        return $this->uploadPastOrdersAsyncWithHttpInfo($x_store_id, $upload_past_orders_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation uploadPastOrdersAsyncWithHttpInfo
     *
     * Upload past orders
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\UploadPastOrdersRequest $upload_past_orders_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['uploadPastOrders'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function uploadPastOrdersAsyncWithHttpInfo($x_store_id, $upload_past_orders_request, string $contentType = self::contentTypes['uploadPastOrders'][0])
    {
        $returnType = '\OpenAPI\Client\Model\UploadPastOrdersResponse';
        $request = $this->uploadPastOrdersRequest($x_store_id, $upload_past_orders_request, $contentType);

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
     * Create request for operation 'uploadPastOrders'
     *
     * @param  string $x_store_id (required)
     * @param  \OpenAPI\Client\Model\UploadPastOrdersRequest $upload_past_orders_request (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['uploadPastOrders'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function uploadPastOrdersRequest($x_store_id, $upload_past_orders_request, string $contentType = self::contentTypes['uploadPastOrders'][0])
    {

        // verify the required parameter 'x_store_id' is set
        if ($x_store_id === null || (is_array($x_store_id) && count($x_store_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_store_id when calling uploadPastOrders'
            );
        }

        // verify the required parameter 'upload_past_orders_request' is set
        if ($upload_past_orders_request === null || (is_array($upload_past_orders_request) && count($upload_past_orders_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $upload_past_orders_request when calling uploadPastOrders'
            );
        }


        $resourcePath = '/v1/orders/past-orders';
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
        if (isset($upload_past_orders_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($upload_past_orders_request));
            } else {
                $httpBody = $upload_past_orders_request;
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
                $httpBody = \GuzzleHttp\json_encode($formParams);
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
