<?php
/**
 * FulfillmentInfo
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
 * FulfillmentInfo Class Doc Comment
 *
 * @category Class
 * @description Information on order fulfillment.
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class FulfillmentInfo implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'FulfillmentInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'pickup_time' => '\DateTime',
        'delivery_time' => '\DateTime',
        'fulfillment_mode' => 'string',
        'scheduling_type' => 'string',
        'courier_status' => 'string',
        'table_identifier' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'pickup_time' => 'date-time',
        'delivery_time' => 'date-time',
        'fulfillment_mode' => null,
        'scheduling_type' => null,
        'courier_status' => null,
        'table_identifier' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'pickup_time' => true,
		'delivery_time' => true,
		'fulfillment_mode' => false,
		'scheduling_type' => true,
		'courier_status' => true,
		'table_identifier' => true
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
        'pickup_time' => 'pickupTime',
        'delivery_time' => 'deliveryTime',
        'fulfillment_mode' => 'fulfillmentMode',
        'scheduling_type' => 'schedulingType',
        'courier_status' => 'courierStatus',
        'table_identifier' => 'tableIdentifier'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'pickup_time' => 'setPickupTime',
        'delivery_time' => 'setDeliveryTime',
        'fulfillment_mode' => 'setFulfillmentMode',
        'scheduling_type' => 'setSchedulingType',
        'courier_status' => 'setCourierStatus',
        'table_identifier' => 'setTableIdentifier'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'pickup_time' => 'getPickupTime',
        'delivery_time' => 'getDeliveryTime',
        'fulfillment_mode' => 'getFulfillmentMode',
        'scheduling_type' => 'getSchedulingType',
        'courier_status' => 'getCourierStatus',
        'table_identifier' => 'getTableIdentifier'
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

    public const FULFILLMENT_MODE_DELIVERY = 'DELIVERY';
    public const FULFILLMENT_MODE_RESTAURANT_DELIVERY = 'RESTAURANT_DELIVERY';
    public const FULFILLMENT_MODE_PICKUP = 'PICKUP';
    public const FULFILLMENT_MODE_DINE_IN = 'DINE_IN';
    public const SCHEDULING_TYPE_ASAP = 'ASAP';
    public const SCHEDULING_TYPE_FIXED_TIME = 'FIXED_TIME';
    public const COURIER_STATUS_ASSIGNED = 'COURIER_ASSIGNED';
    public const COURIER_STATUS_ON_ROUTE_TO_PICKUP = 'COURIER_ON_ROUTE_TO_PICKUP';
    public const COURIER_STATUS_ARRIVED = 'COURIER_ARRIVED';
    public const COURIER_STATUS_PICKED_UP_FOOD = 'COURIER_PICKED_UP_FOOD';
    public const COURIER_STATUS_COMPLETED = 'COURIER_COMPLETED';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getFulfillmentModeAllowableValues()
    {
        return [
            self::FULFILLMENT_MODE_DELIVERY,
            self::FULFILLMENT_MODE_RESTAURANT_DELIVERY,
            self::FULFILLMENT_MODE_PICKUP,
            self::FULFILLMENT_MODE_DINE_IN,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getSchedulingTypeAllowableValues()
    {
        return [
            self::SCHEDULING_TYPE_ASAP,
            self::SCHEDULING_TYPE_FIXED_TIME,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getCourierStatusAllowableValues()
    {
        return [
            self::COURIER_STATUS_ASSIGNED,
            self::COURIER_STATUS_ON_ROUTE_TO_PICKUP,
            self::COURIER_STATUS_ARRIVED,
            self::COURIER_STATUS_PICKED_UP_FOOD,
            self::COURIER_STATUS_COMPLETED,
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
        $this->setIfExists('pickup_time', $data ?? [], null);
        $this->setIfExists('delivery_time', $data ?? [], null);
        $this->setIfExists('fulfillment_mode', $data ?? [], 'DELIVERY');
        $this->setIfExists('scheduling_type', $data ?? [], null);
        $this->setIfExists('courier_status', $data ?? [], null);
        $this->setIfExists('table_identifier', $data ?? [], null);
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

        $allowedValues = $this->getFulfillmentModeAllowableValues();
        if (!is_null($this->container['fulfillment_mode']) && !in_array($this->container['fulfillment_mode'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'fulfillment_mode', must be one of '%s'",
                $this->container['fulfillment_mode'],
                implode("', '", $allowedValues)
            );
        }

        $allowedValues = $this->getSchedulingTypeAllowableValues();
        if (!is_null($this->container['scheduling_type']) && !in_array($this->container['scheduling_type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'scheduling_type', must be one of '%s'",
                $this->container['scheduling_type'],
                implode("', '", $allowedValues)
            );
        }

        $allowedValues = $this->getCourierStatusAllowableValues();
        if (!is_null($this->container['courier_status']) && !in_array($this->container['courier_status'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'courier_status', must be one of '%s'",
                $this->container['courier_status'],
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
     * Gets pickup_time
     *
     * @return \DateTime|null
     */
    public function getPickupTime()
    {
        return $this->container['pickup_time'];
    }

    /**
     * Sets pickup_time
     *
     * @param \DateTime|null $pickup_time Estimated time (in UTC) that the courier or customer will pick up the order.
     *
     * @return self
     */
    public function setPickupTime($pickup_time)
    {
        if (is_null($pickup_time)) {
            array_push($this->openAPINullablesSetToNull, 'pickup_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('pickup_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['pickup_time'] = $pickup_time;

        return $this;
    }

    /**
     * Gets delivery_time
     *
     * @return \DateTime|null
     */
    public function getDeliveryTime()
    {
        return $this->container['delivery_time'];
    }

    /**
     * Sets delivery_time
     *
     * @param \DateTime|null $delivery_time Estimated time (in UTC) when the order is expected to be delivered. This should be filled in if FulfillmentMode is delivery.
     *
     * @return self
     */
    public function setDeliveryTime($delivery_time)
    {
        if (is_null($delivery_time)) {
            array_push($this->openAPINullablesSetToNull, 'delivery_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('delivery_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['delivery_time'] = $delivery_time;

        return $this;
    }

    /**
     * Gets fulfillment_mode
     *
     * @return string|null
     */
    public function getFulfillmentMode()
    {
        return $this->container['fulfillment_mode'];
    }

    /**
     * Sets fulfillment_mode
     *
     * @param string|null $fulfillment_mode How an order is expected to be fulfilled.
     *
     * @return self
     */
    public function setFulfillmentMode($fulfillment_mode)
    {
        if (is_null($fulfillment_mode)) {
            throw new \InvalidArgumentException('non-nullable fulfillment_mode cannot be null');
        }
        $allowedValues = $this->getFulfillmentModeAllowableValues();
        if (!in_array($fulfillment_mode, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'fulfillment_mode', must be one of '%s'",
                    $fulfillment_mode,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['fulfillment_mode'] = $fulfillment_mode;

        return $this;
    }

    /**
     * Gets scheduling_type
     *
     * @return string|null
     */
    public function getSchedulingType()
    {
        return $this->container['scheduling_type'];
    }

    /**
     * Sets scheduling_type
     *
     * @param string|null $scheduling_type Describes whether this order should be cooked as soon as possible, or some time in the future. Please use the pickupTime and/or deliveryTime to indicate when. If no scheduling type is provided, we assume the order should be prepared as soon as possible.
     *
     * @return self
     */
    public function setSchedulingType($scheduling_type)
    {
        if (is_null($scheduling_type)) {
            array_push($this->openAPINullablesSetToNull, 'scheduling_type');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('scheduling_type', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $allowedValues = $this->getSchedulingTypeAllowableValues();
        if (!is_null($scheduling_type) && !in_array($scheduling_type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'scheduling_type', must be one of '%s'",
                    $scheduling_type,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['scheduling_type'] = $scheduling_type;

        return $this;
    }

    /**
     * Gets courier_status
     *
     * @return string|null
     */
    public function getCourierStatus()
    {
        return $this->container['courier_status'];
    }

    /**
     * Sets courier_status
     *
     * @param string|null $courier_status The status of the courier.
     *
     * @return self
     */
    public function setCourierStatus($courier_status)
    {
        if (is_null($courier_status)) {
            array_push($this->openAPINullablesSetToNull, 'courier_status');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('courier_status', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $allowedValues = $this->getCourierStatusAllowableValues();
        if (!is_null($courier_status) && !in_array($courier_status, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'courier_status', must be one of '%s'",
                    $courier_status,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['courier_status'] = $courier_status;

        return $this;
    }

    /**
     * Gets table_identifier
     *
     * @return string|null
     */
    public function getTableIdentifier()
    {
        return $this->container['table_identifier'];
    }

    /**
     * Sets table_identifier
     *
     * @param string|null $table_identifier The table identification for dine-in orders.
     *
     * @return self
     */
    public function setTableIdentifier($table_identifier)
    {
        if (is_null($table_identifier)) {
            array_push($this->openAPINullablesSetToNull, 'table_identifier');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('table_identifier', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['table_identifier'] = $table_identifier;

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


