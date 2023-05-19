<?php
/**
 * OrderWithManagerInfo
 *
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

namespace OpenAPI\Client\Model;

use \ArrayAccess;
use \OpenAPI\Client\ObjectSerializer;

/**
 * OrderWithManagerInfo Class Doc Comment
 *
 * @category Class
 * @description An order placed by a customer with manager injection details
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class OrderWithManagerInfo implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'OrderWithManagerInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'order' => '\OpenAPI\Client\Model\Order',
        'injection_state' => 'string',
        'order_cancel_details' => '\OpenAPI\Client\Model\ManagerOrderCancelDetails',
        'injection_event' => 'string',
        'order_issues' => '\OpenAPI\Client\Model\ManagerOrderIssues'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'order' => null,
        'injection_state' => null,
        'order_cancel_details' => null,
        'injection_event' => null,
        'order_issues' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'order' => false,
		'injection_state' => false,
		'order_cancel_details' => false,
		'injection_event' => false,
		'order_issues' => false
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param boolean[] $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'order' => 'order',
        'injection_state' => 'injectionState',
        'order_cancel_details' => 'orderCancelDetails',
        'injection_event' => 'injectionEvent',
        'order_issues' => 'orderIssues'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'order' => 'setOrder',
        'injection_state' => 'setInjectionState',
        'order_cancel_details' => 'setOrderCancelDetails',
        'injection_event' => 'setInjectionEvent',
        'order_issues' => 'setOrderIssues'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'order' => 'getOrder',
        'injection_state' => 'getInjectionState',
        'order_cancel_details' => 'getOrderCancelDetails',
        'injection_event' => 'getInjectionEvent',
        'order_issues' => 'getOrderIssues'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    public const INJECTION_STATE_UNKNOWN = 'UNKNOWN';
    public const INJECTION_STATE_PENDING = 'PENDING';
    public const INJECTION_STATE_SUCCEEDED = 'SUCCEEDED';
    public const INJECTION_STATE_FAILED_ATTEMPT = 'FAILED_ATTEMPT';
    public const INJECTION_STATE_MANUAL_INJECTION_SUCCEEDED = 'MANUAL_INJECTION_SUCCEEDED';
    public const INJECTION_STATE_MANUAL_INJECTION_REQUIRED = 'MANUAL_INJECTION_REQUIRED';
    public const INJECTION_STATE_SUCCEEDED_WITH_UNLINKED_ITEM = 'SUCCEEDED_WITH_UNLINKED_ITEM';
    public const INJECTION_STATE_ORDER_CANCELED = 'ORDER_CANCELED';
    public const INJECTION_STATE_ORDER_CANCEL_FAILED = 'ORDER_CANCEL_FAILED';
    public const INJECTION_STATE_ORDER_REJECTED = 'ORDER_REJECTED';
    public const INJECTION_STATE_ORDER_REJECT_FAILED = 'ORDER_REJECT_FAILED';
    public const INJECTION_STATE_RE_INJECTION_REQUESTED = 'RE_INJECTION_REQUESTED';
    public const INJECTION_STATE_RE_INJECTION_PENDING = 'RE_INJECTION_PENDING';
    public const INJECTION_EVENT_UNKNOWN = 'UNKNOWN';
    public const INJECTION_EVENT_ORDER_CREATE = 'ORDER_CREATE';
    public const INJECTION_EVENT_ORDER_ACCEPT = 'ORDER_ACCEPT';
    public const INJECTION_EVENT_ORDER_IMPORT = 'ORDER_IMPORT';
    public const INJECTION_EVENT_ORDER_RE_INJECT = 'ORDER_RE_INJECT';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getInjectionStateAllowableValues()
    {
        return [
            self::INJECTION_STATE_UNKNOWN,
            self::INJECTION_STATE_PENDING,
            self::INJECTION_STATE_SUCCEEDED,
            self::INJECTION_STATE_FAILED_ATTEMPT,
            self::INJECTION_STATE_MANUAL_INJECTION_SUCCEEDED,
            self::INJECTION_STATE_MANUAL_INJECTION_REQUIRED,
            self::INJECTION_STATE_SUCCEEDED_WITH_UNLINKED_ITEM,
            self::INJECTION_STATE_ORDER_CANCELED,
            self::INJECTION_STATE_ORDER_CANCEL_FAILED,
            self::INJECTION_STATE_ORDER_REJECTED,
            self::INJECTION_STATE_ORDER_REJECT_FAILED,
            self::INJECTION_STATE_RE_INJECTION_REQUESTED,
            self::INJECTION_STATE_RE_INJECTION_PENDING,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getInjectionEventAllowableValues()
    {
        return [
            self::INJECTION_EVENT_UNKNOWN,
            self::INJECTION_EVENT_ORDER_CREATE,
            self::INJECTION_EVENT_ORDER_ACCEPT,
            self::INJECTION_EVENT_ORDER_IMPORT,
            self::INJECTION_EVENT_ORDER_RE_INJECT,
        ];
    }

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('order', $data ?? [], null);
        $this->setIfExists('injection_state', $data ?? [], null);
        $this->setIfExists('order_cancel_details', $data ?? [], null);
        $this->setIfExists('injection_event', $data ?? [], null);
        $this->setIfExists('order_issues', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['order'] === null) {
            $invalidProperties[] = "'order' can't be null";
        }
        if ($this->container['injection_state'] === null) {
            $invalidProperties[] = "'injection_state' can't be null";
        }
        $allowedValues = $this->getInjectionStateAllowableValues();
        if (!is_null($this->container['injection_state']) && !in_array($this->container['injection_state'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'injection_state', must be one of '%s'",
                $this->container['injection_state'],
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['injection_event'] === null) {
            $invalidProperties[] = "'injection_event' can't be null";
        }
        $allowedValues = $this->getInjectionEventAllowableValues();
        if (!is_null($this->container['injection_event']) && !in_array($this->container['injection_event'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'injection_event', must be one of '%s'",
                $this->container['injection_event'],
                implode("', '", $allowedValues)
            );
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets order
     *
     * @return \OpenAPI\Client\Model\Order
     */
    public function getOrder()
    {
        return $this->container['order'];
    }

    /**
     * Sets order
     *
     * @param \OpenAPI\Client\Model\Order $order order
     *
     * @return self
     */
    public function setOrder($order)
    {
        if (is_null($order)) {
            throw new \InvalidArgumentException('non-nullable order cannot be null');
        }
        $this->container['order'] = $order;

        return $this;
    }

    /**
     * Gets injection_state
     *
     * @return string
     */
    public function getInjectionState()
    {
        return $this->container['injection_state'];
    }

    /**
     * Sets injection_state
     *
     * @param string $injection_state Current Manager injection state
     *
     * @return self
     */
    public function setInjectionState($injection_state)
    {
        if (is_null($injection_state)) {
            throw new \InvalidArgumentException('non-nullable injection_state cannot be null');
        }
        $allowedValues = $this->getInjectionStateAllowableValues();
        if (!in_array($injection_state, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'injection_state', must be one of '%s'",
                    $injection_state,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['injection_state'] = $injection_state;

        return $this;
    }

    /**
     * Gets order_cancel_details
     *
     * @return \OpenAPI\Client\Model\ManagerOrderCancelDetails|null
     */
    public function getOrderCancelDetails()
    {
        return $this->container['order_cancel_details'];
    }

    /**
     * Sets order_cancel_details
     *
     * @param \OpenAPI\Client\Model\ManagerOrderCancelDetails|null $order_cancel_details order_cancel_details
     *
     * @return self
     */
    public function setOrderCancelDetails($order_cancel_details)
    {
        if (is_null($order_cancel_details)) {
            throw new \InvalidArgumentException('non-nullable order_cancel_details cannot be null');
        }
        $this->container['order_cancel_details'] = $order_cancel_details;

        return $this;
    }

    /**
     * Gets injection_event
     *
     * @return string
     */
    public function getInjectionEvent()
    {
        return $this->container['injection_event'];
    }

    /**
     * Sets injection_event
     *
     * @param string $injection_event The order event that triggered order injection into manager
     *
     * @return self
     */
    public function setInjectionEvent($injection_event)
    {
        if (is_null($injection_event)) {
            throw new \InvalidArgumentException('non-nullable injection_event cannot be null');
        }
        $allowedValues = $this->getInjectionEventAllowableValues();
        if (!in_array($injection_event, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'injection_event', must be one of '%s'",
                    $injection_event,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['injection_event'] = $injection_event;

        return $this;
    }

    /**
     * Gets order_issues
     *
     * @return \OpenAPI\Client\Model\ManagerOrderIssues|null
     */
    public function getOrderIssues()
    {
        return $this->container['order_issues'];
    }

    /**
     * Sets order_issues
     *
     * @param \OpenAPI\Client\Model\ManagerOrderIssues|null $order_issues order_issues
     *
     * @return self
     */
    public function setOrderIssues($order_issues)
    {
        if (is_null($order_issues)) {
            throw new \InvalidArgumentException('non-nullable order_issues cannot be null');
        }
        $this->container['order_issues'] = $order_issues;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


