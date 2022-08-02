<?php
/**
 * POSFeedDelivery
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
 * # Overview  The API endpoints are developed around [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) principles secure via the OAuth2.0 protocol.  Beyond the entry points, the API also provides a line of communication into your system via [webhooks](https://en.wikipedia.org/wiki/Webhook).  For testing purposes, we offer a staging environment. Also, more detailed information about the business rules and workflows can be found on the [**Documentation Section**](/docs/)  ## Versioning Each API is versioned individually, but we follow these rules: - Non breaking changes (eg: adding new fields) are added in the current version without previous communication - Breaking changes (fields removal, semantic changed or schema update) have the version incremented - Users will be notified about new versions and will be given time to migrate (the time will be set on a case by case) - Once users migrate to the new version, we will deprecate the old ones - Once there is a new version for an API, we won't accept new integrations targeting old versions  ## API General Definitions The APIs use resource-oriented URLs communicating, primarily, via JSON and leveraging the HTTP headers, [response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status), and verbs.  To exemplify how the API is to be consumed, consider a fake GET resource endpoint invocation below:  ``` curl --request GET 'https://{{public-api-url}}/v1/resource/123' \\ --header 'Authorization: Bearer 34fdabeeafds=' --header 'X-Store-Id: 321' --header 'X-Application-Id: e22f94b3-967c-4e26-bf39-9e364066b68b' ```  |      Header      | Description | | ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | |`Authorization`   | Standard HTTP header is used to associate the request with the originating invoker. The content of this header is a `Bearer` token generated from you client_secret, defined in the [API Auth](#/section/Guides/API-Auth) guide.| |`X-Application-Id`| The plain-text `Application Id`, provided at onboarding. | |`X-Store-Id`      | The ID of the store in your system this call acts on behalf of. |  _All resource endpoints expect the `Authorization` and `X-Application-Id` header, the remaining headers are explicitly stated in the individual endpoint documentation section._  With these headers, the system will:  - Validate the client token, making sure the call is originating from a trusted source.  - Validate that the Application has the permission to access the `v1/resource/{id}` resource via the Application's pre-configured scopes.  - Translate your X-Store-Id to our internal store ID (e.g. `AAA`).  - Validate and retrieve resource `AAA`, that is associated to your Application via store id `321`.  POST/PUT methods will look similar to the GET calls, but they'll take in a body in the HTTP request (default to the application/json content-type).  ``` curl --location --request POST 'https://{{public-api-url}}/v1/resource' \\ --header 'Authorization: Bearer 34fdabeeafds=' --header 'X-Store-Id: 321' --header 'X-Application-Id: e22f94b3-967c-4e26-bf39-9e364066b68b\" --data '{\"foo\": \"bar\"}' ```  ## API Authentication/Authorization  <SecurityDefinitions />  The **Authorization API** is based on the [OAuth2.0 protocol](https://tools.ietf.org/html/rfc6749), using the [client credentials grant](https://tools.ietf.org/html/rfc6749#section-4.4). Resources expect a valid token sent as a `Bearer` token in the HTTP `Authorization` header.  To generate the token, use the `Application ID` and `Client Secret` (provided during onboarding) to the [Token Auth endpoint](#operation/requestToken) endpoint. The result of this invocation is a token that is valid for a pre-determined time or until it is manually revoked.  The response of the following endpoints will return a token that will be sent as a `Bearer` value of the `Authorization` HTTP header, along with meta information such as expiry-date.  _Note that the referred `client_id` is the `Application ID` because though we chose adhere to the OAuth2.0 standard for the auth APIs._  ### Request Examples  #### URL Encoded Form  The API exposes a token generation endpoint expects your *client_id* and *client_secret* to be formatted as *application/x-www-form-urlencoded* content type. ``` curl --location --request POST 'https://{{public-api-url}}/v1/auth/token' \\ --header 'Content-Type: application/x-www-form-urlencoded' \\ --data-urlencode 'scope=ping' \\ --data-urlencode 'grant_type=client_credentials' \\ --data-urlencode 'client_id=[APPLICATION_ID]' \\ --data-urlencode 'client_secret=[CLIENT_SECRET]' ```  #### HTTP Basic Auth  Alternatively, the API also accepts a `Basic` Authorization header with the Base64 encoding of the `client_id` (`Application ID`) and `client_secret` joined by a single colon `:`.  ``` BASE64_ENCODED_CREDENTIALS = base64_encode(client_id + \":\" + client_secret) ```  ``` curl --location --request POST 'https://{{public-api-url}}/v1/auth/token' \\ --header 'Authorization: Basic [BASE64_ENCODED_CREDENTIALS]' \\ --header 'Content-Type: application/x-www-form-urlencoded' \\ --data-urlencode 'scope=ping' \\ --data-urlencode 'grant_type=client_credentials' ```  ## Webhook  The Public API is able to send notifications to your system via HTTP POST requests.  Every webhook is signed using HMAC-SHA256 that is present in the header `X-HMAC-SHA256`, and you can also authenticate the requests using Basic Auth, Bearer Token or HMAC-SHA1 (legacy). Please, refer to [**Webhook Authentication Guide**](/docs/guides-webhook-authentication/) for more details.  _Please work with your Account Representative to setup your Application's Webhook configurations._  ``` Example Base-URL = https://{{your-server-url}}/webhook ```  ### Notification Schema  | **Name**                | **Type** | **Description**                                                      | | ------------------------| ---------| -------------------------------------------------------------------- | | eventId                 | string   | Unique id of the event.                                              | | eventTime               | string   | The time the event occurred.                                         | | eventType               | string   | The type of event (e.g. create_order).                               | | metadata.storeId        | string   | Id of the store for which the event is being published.              | | metadata.applicationId  | string   | Id of the application for which the event is being published.        | | metadata.resourceId     | string   | The external identifier of the resource that this event refers to.   | | metadata.resourceHref   | string   | The endpoint to fetch the details of the resource.                   | | metadata.payload        | object   | The event object which will be detailed in each Webhook description. |  ### Notification Request Example  ``` curl --location --request POST 'https://{{your-server-url}}/webhook' \\ --header 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36' \\ --header 'Authorization: MAC <hash signature>' \\ --header 'Content-Type: application/json' \\ --data-raw '{    \"eventId\": \"123456\",    \"eventTime\": \"2020-10-10T20:06:02:123Z\",    \"eventType\": \"orders.new_order\",    \"metadata\": {       \"storeId\": \"755fd19a-7562-487a-b615-171a9f89d669\",       \"applicationId\": \"e22f94b3-967c-4e26-bf39-9e364066b68b\",       \"resourceHref\": \"https://{{public-api-url}}/v1/orders/bf9f1d81-f213-496e-a026-91b6af44996c\",       \"resourceId\": \"bf9f1d81-f213-496e-a026-91b6af44996c\",       \"payload\": {}    } } ```  ## Expected Response  The partner application should return an HTTP 200 response code with an empty response body to acknowledge receipt of the webhook event. ## Rate Limiting Please, refer to [**Rate Limiting Guide**](/docs/guides-rate-limiting/) for more details.
 *
 * The version of the OpenAPI document: v1
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.0.1
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
 * POSFeedDelivery Class Doc Comment
 *
 * @category Class
 * @description Delivery information.
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class POSFeedDelivery implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'POSFeedDelivery';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'provider' => 'string',
        'courier' => '\OpenAPI\Client\Model\Courier',
        'estimated_delivery_time' => '\DateTime',
        'estimated_pickup_time' => '\DateTime',
        'status' => '\OpenAPI\Client\Model\DeliveryStatus',
        'delivery_status' => 'string',
        'currency_code' => 'string',
        'base_fee' => 'double',
        'extra_fee' => 'double',
        'total_fee' => 'double',
        'distance' => '\OpenAPI\Client\Model\Distance',
        'processed_time' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'provider' => null,
        'courier' => null,
        'estimated_delivery_time' => 'date-time',
        'estimated_pickup_time' => 'date-time',
        'status' => null,
        'delivery_status' => null,
        'currency_code' => null,
        'base_fee' => 'double',
        'extra_fee' => 'double',
        'total_fee' => 'double',
        'distance' => null,
        'processed_time' => 'date-time'
    ];

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
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'provider' => 'provider',
        'courier' => 'courier',
        'estimated_delivery_time' => 'estimatedDeliveryTime',
        'estimated_pickup_time' => 'estimatedPickupTime',
        'status' => 'status',
        'delivery_status' => 'deliveryStatus',
        'currency_code' => 'currencyCode',
        'base_fee' => 'baseFee',
        'extra_fee' => 'extraFee',
        'total_fee' => 'totalFee',
        'distance' => 'distance',
        'processed_time' => 'processedTime'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'provider' => 'setProvider',
        'courier' => 'setCourier',
        'estimated_delivery_time' => 'setEstimatedDeliveryTime',
        'estimated_pickup_time' => 'setEstimatedPickupTime',
        'status' => 'setStatus',
        'delivery_status' => 'setDeliveryStatus',
        'currency_code' => 'setCurrencyCode',
        'base_fee' => 'setBaseFee',
        'extra_fee' => 'setExtraFee',
        'total_fee' => 'setTotalFee',
        'distance' => 'setDistance',
        'processed_time' => 'setProcessedTime'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'provider' => 'getProvider',
        'courier' => 'getCourier',
        'estimated_delivery_time' => 'getEstimatedDeliveryTime',
        'estimated_pickup_time' => 'getEstimatedPickupTime',
        'status' => 'getStatus',
        'delivery_status' => 'getDeliveryStatus',
        'currency_code' => 'getCurrencyCode',
        'base_fee' => 'getBaseFee',
        'extra_fee' => 'getExtraFee',
        'total_fee' => 'getTotalFee',
        'distance' => 'getDistance',
        'processed_time' => 'getProcessedTime'
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

    public const DELIVERY_STATUS_REQUESTED = 'REQUESTED';
    public const DELIVERY_STATUS_ALLOCATED = 'ALLOCATED';
    public const DELIVERY_STATUS_PICKED_UP = 'PICKED_UP';
    public const DELIVERY_STATUS_COMPLETED = 'COMPLETED';
    public const DELIVERY_STATUS_CANCELED = 'CANCELED';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getDeliveryStatusAllowableValues()
    {
        return [
            self::DELIVERY_STATUS_REQUESTED,
            self::DELIVERY_STATUS_ALLOCATED,
            self::DELIVERY_STATUS_PICKED_UP,
            self::DELIVERY_STATUS_COMPLETED,
            self::DELIVERY_STATUS_CANCELED,
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
        $this->container['provider'] = $data['provider'] ?? null;
        $this->container['courier'] = $data['courier'] ?? null;
        $this->container['estimated_delivery_time'] = $data['estimated_delivery_time'] ?? null;
        $this->container['estimated_pickup_time'] = $data['estimated_pickup_time'] ?? null;
        $this->container['status'] = $data['status'] ?? null;
        $this->container['delivery_status'] = $data['delivery_status'] ?? null;
        $this->container['currency_code'] = $data['currency_code'] ?? null;
        $this->container['base_fee'] = $data['base_fee'] ?? null;
        $this->container['extra_fee'] = $data['extra_fee'] ?? null;
        $this->container['total_fee'] = $data['total_fee'] ?? null;
        $this->container['distance'] = $data['distance'] ?? null;
        $this->container['processed_time'] = $data['processed_time'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getDeliveryStatusAllowableValues();
        if (!is_null($this->container['delivery_status']) && !in_array($this->container['delivery_status'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'delivery_status', must be one of '%s'",
                $this->container['delivery_status'],
                implode("', '", $allowedValues)
            );
        }

        if (!is_null($this->container['currency_code']) && (mb_strlen($this->container['currency_code']) > 3)) {
            $invalidProperties[] = "invalid value for 'currency_code', the character length must be smaller than or equal to 3.";
        }

        if (!is_null($this->container['currency_code']) && (mb_strlen($this->container['currency_code']) < 3)) {
            $invalidProperties[] = "invalid value for 'currency_code', the character length must be bigger than or equal to 3.";
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
     * Gets provider
     *
     * @return string|null
     */
    public function getProvider()
    {
        return $this->container['provider'];
    }

    /**
     * Sets provider
     *
     * @param string|null $provider Delivery Service Provider Slug.
     *
     * @return self
     */
    public function setProvider($provider)
    {
        $this->container['provider'] = $provider;

        return $this;
    }

    /**
     * Gets courier
     *
     * @return \OpenAPI\Client\Model\Courier|null
     */
    public function getCourier()
    {
        return $this->container['courier'];
    }

    /**
     * Sets courier
     *
     * @param \OpenAPI\Client\Model\Courier|null $courier courier
     *
     * @return self
     */
    public function setCourier($courier)
    {
        $this->container['courier'] = $courier;

        return $this;
    }

    /**
     * Gets estimated_delivery_time
     *
     * @return \DateTime|null
     */
    public function getEstimatedDeliveryTime()
    {
        return $this->container['estimated_delivery_time'];
    }

    /**
     * Sets estimated_delivery_time
     *
     * @param \DateTime|null $estimated_delivery_time Estimated delivery time
     *
     * @return self
     */
    public function setEstimatedDeliveryTime($estimated_delivery_time)
    {
        $this->container['estimated_delivery_time'] = $estimated_delivery_time;

        return $this;
    }

    /**
     * Gets estimated_pickup_time
     *
     * @return \DateTime|null
     */
    public function getEstimatedPickupTime()
    {
        return $this->container['estimated_pickup_time'];
    }

    /**
     * Sets estimated_pickup_time
     *
     * @param \DateTime|null $estimated_pickup_time Estimated pickup time
     *
     * @return self
     */
    public function setEstimatedPickupTime($estimated_pickup_time)
    {
        $this->container['estimated_pickup_time'] = $estimated_pickup_time;

        return $this;
    }

    /**
     * Gets status
     *
     * @return \OpenAPI\Client\Model\DeliveryStatus|null
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param \OpenAPI\Client\Model\DeliveryStatus|null $status status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets delivery_status
     *
     * @return string|null
     * @deprecated
     */
    public function getDeliveryStatus()
    {
        return $this->container['delivery_status'];
    }

    /**
     * Sets delivery_status
     *
     * @param string|null $delivery_status Use the status field instead.
     *
     * @return self
     * @deprecated
     */
    public function setDeliveryStatus($delivery_status)
    {
        $allowedValues = $this->getDeliveryStatusAllowableValues();
        if (!is_null($delivery_status) && !in_array($delivery_status, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'delivery_status', must be one of '%s'",
                    $delivery_status,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['delivery_status'] = $delivery_status;

        return $this;
    }

    /**
     * Gets currency_code
     *
     * @return string|null
     */
    public function getCurrencyCode()
    {
        return $this->container['currency_code'];
    }

    /**
     * Sets currency_code
     *
     * @param string|null $currency_code The 3-letter currency code (ISO 4217) to use for all monetary values.
     *
     * @return self
     */
    public function setCurrencyCode($currency_code)
    {
        if (!is_null($currency_code) && (mb_strlen($currency_code) > 3)) {
            throw new \InvalidArgumentException('invalid length for $currency_code when calling POSFeedDelivery., must be smaller than or equal to 3.');
        }
        if (!is_null($currency_code) && (mb_strlen($currency_code) < 3)) {
            throw new \InvalidArgumentException('invalid length for $currency_code when calling POSFeedDelivery., must be bigger than or equal to 3.');
        }

        $this->container['currency_code'] = $currency_code;

        return $this;
    }

    /**
     * Gets base_fee
     *
     * @return double|null
     */
    public function getBaseFee()
    {
        return $this->container['base_fee'];
    }

    /**
     * Sets base_fee
     *
     * @param double|null $base_fee Base delivery cost value.
     *
     * @return self
     */
    public function setBaseFee($base_fee)
    {
        $this->container['base_fee'] = $base_fee;

        return $this;
    }

    /**
     * Gets extra_fee
     *
     * @return double|null
     */
    public function getExtraFee()
    {
        return $this->container['extra_fee'];
    }

    /**
     * Sets extra_fee
     *
     * @param double|null $extra_fee Extra delivery cost value.
     *
     * @return self
     */
    public function setExtraFee($extra_fee)
    {
        $this->container['extra_fee'] = $extra_fee;

        return $this;
    }

    /**
     * Gets total_fee
     *
     * @return double|null
     */
    public function getTotalFee()
    {
        return $this->container['total_fee'];
    }

    /**
     * Sets total_fee
     *
     * @param double|null $total_fee Total delivery cost value.
     *
     * @return self
     */
    public function setTotalFee($total_fee)
    {
        $this->container['total_fee'] = $total_fee;

        return $this;
    }

    /**
     * Gets distance
     *
     * @return \OpenAPI\Client\Model\Distance|null
     */
    public function getDistance()
    {
        return $this->container['distance'];
    }

    /**
     * Sets distance
     *
     * @param \OpenAPI\Client\Model\Distance|null $distance distance
     *
     * @return self
     */
    public function setDistance($distance)
    {
        $this->container['distance'] = $distance;

        return $this;
    }

    /**
     * Gets processed_time
     *
     * @return \DateTime|null
     */
    public function getProcessedTime()
    {
        return $this->container['processed_time'];
    }

    /**
     * Sets processed_time
     *
     * @param \DateTime|null $processed_time Time that the delivery was accepted and confirmed.
     *
     * @return self
     */
    public function setProcessedTime($processed_time)
    {
        $this->container['processed_time'] = $processed_time;

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


