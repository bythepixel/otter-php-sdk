<?php
/**
 * RequestDeliveryQuoteEvent
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
 * RequestDeliveryQuoteEvent Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class RequestDeliveryQuoteEvent implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'RequestDeliveryQuoteEvent';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'delivery_reference_id' => 'string',
        'provider' => 'string',
        'preferred_pickup_duration' => 'int',
        'pickup_address' => '\OpenAPI\Client\Model\RequiredAddress',
        'dropoff_address' => '\OpenAPI\Client\Model\RequiredAddress',
        'destination_address' => '\OpenAPI\Client\Model\RequiredAddress',
        'pick_up_location_id' => 'string',
        'order_sub_total' => 'float',
        'currency_code' => 'string',
        'contains_alcoholic_item' => 'bool',
        'customer_payments' => '\OpenAPI\Client\Model\CustomerPayment[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'delivery_reference_id' => null,
        'provider' => null,
        'preferred_pickup_duration' => 'int32',
        'pickup_address' => null,
        'dropoff_address' => null,
        'destination_address' => null,
        'pick_up_location_id' => null,
        'order_sub_total' => null,
        'currency_code' => null,
        'contains_alcoholic_item' => null,
        'customer_payments' => null
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
        'delivery_reference_id' => 'deliveryReferenceId',
        'provider' => 'provider',
        'preferred_pickup_duration' => 'preferredPickupDuration',
        'pickup_address' => 'pickupAddress',
        'dropoff_address' => 'dropoffAddress',
        'destination_address' => 'destinationAddress',
        'pick_up_location_id' => 'pickUpLocationId',
        'order_sub_total' => 'orderSubTotal',
        'currency_code' => 'currencyCode',
        'contains_alcoholic_item' => 'containsAlcoholicItem',
        'customer_payments' => 'customerPayments'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'delivery_reference_id' => 'setDeliveryReferenceId',
        'provider' => 'setProvider',
        'preferred_pickup_duration' => 'setPreferredPickupDuration',
        'pickup_address' => 'setPickupAddress',
        'dropoff_address' => 'setDropoffAddress',
        'destination_address' => 'setDestinationAddress',
        'pick_up_location_id' => 'setPickUpLocationId',
        'order_sub_total' => 'setOrderSubTotal',
        'currency_code' => 'setCurrencyCode',
        'contains_alcoholic_item' => 'setContainsAlcoholicItem',
        'customer_payments' => 'setCustomerPayments'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'delivery_reference_id' => 'getDeliveryReferenceId',
        'provider' => 'getProvider',
        'preferred_pickup_duration' => 'getPreferredPickupDuration',
        'pickup_address' => 'getPickupAddress',
        'dropoff_address' => 'getDropoffAddress',
        'destination_address' => 'getDestinationAddress',
        'pick_up_location_id' => 'getPickUpLocationId',
        'order_sub_total' => 'getOrderSubTotal',
        'currency_code' => 'getCurrencyCode',
        'contains_alcoholic_item' => 'getContainsAlcoholicItem',
        'customer_payments' => 'getCustomerPayments'
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
        $this->container['delivery_reference_id'] = $data['delivery_reference_id'] ?? null;
        $this->container['provider'] = $data['provider'] ?? null;
        $this->container['preferred_pickup_duration'] = $data['preferred_pickup_duration'] ?? null;
        $this->container['pickup_address'] = $data['pickup_address'] ?? null;
        $this->container['dropoff_address'] = $data['dropoff_address'] ?? null;
        $this->container['destination_address'] = $data['destination_address'] ?? null;
        $this->container['pick_up_location_id'] = $data['pick_up_location_id'] ?? null;
        $this->container['order_sub_total'] = $data['order_sub_total'] ?? null;
        $this->container['currency_code'] = $data['currency_code'] ?? null;
        $this->container['contains_alcoholic_item'] = $data['contains_alcoholic_item'] ?? null;
        $this->container['customer_payments'] = $data['customer_payments'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

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
     * Gets delivery_reference_id
     *
     * @return string|null
     */
    public function getDeliveryReferenceId()
    {
        return $this->container['delivery_reference_id'];
    }

    /**
     * Sets delivery_reference_id
     *
     * @param string|null $delivery_reference_id Generated delivery reference id.
     *
     * @return self
     */
    public function setDeliveryReferenceId($delivery_reference_id)
    {
        $this->container['delivery_reference_id'] = $delivery_reference_id;

        return $this;
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
     * @param string|null $provider the pre-configured fulfillment provider slug in the onboarding process.
     *
     * @return self
     */
    public function setProvider($provider)
    {
        $this->container['provider'] = $provider;

        return $this;
    }

    /**
     * Gets preferred_pickup_duration
     *
     * @return int|null
     */
    public function getPreferredPickupDuration()
    {
        return $this->container['preferred_pickup_duration'];
    }

    /**
     * Sets preferred_pickup_duration
     *
     * @param int|null $preferred_pickup_duration Preferred time for courier to arrive to pick up order. Value expressed in minutes and is relative to time delivery request is made. If not provided, or if the value is 0, please treat it as an ASAP request.
     *
     * @return self
     */
    public function setPreferredPickupDuration($preferred_pickup_duration)
    {
        $this->container['preferred_pickup_duration'] = $preferred_pickup_duration;

        return $this;
    }

    /**
     * Gets pickup_address
     *
     * @return \OpenAPI\Client\Model\RequiredAddress|null
     */
    public function getPickupAddress()
    {
        return $this->container['pickup_address'];
    }

    /**
     * Sets pickup_address
     *
     * @param \OpenAPI\Client\Model\RequiredAddress|null $pickup_address pickup_address
     *
     * @return self
     */
    public function setPickupAddress($pickup_address)
    {
        $this->container['pickup_address'] = $pickup_address;

        return $this;
    }

    /**
     * Gets dropoff_address
     *
     * @return \OpenAPI\Client\Model\RequiredAddress|null
     */
    public function getDropoffAddress()
    {
        return $this->container['dropoff_address'];
    }

    /**
     * Sets dropoff_address
     *
     * @param \OpenAPI\Client\Model\RequiredAddress|null $dropoff_address dropoff_address
     *
     * @return self
     */
    public function setDropoffAddress($dropoff_address)
    {
        $this->container['dropoff_address'] = $dropoff_address;

        return $this;
    }

    /**
     * Gets destination_address
     *
     * @return \OpenAPI\Client\Model\RequiredAddress|null
     */
    public function getDestinationAddress()
    {
        return $this->container['destination_address'];
    }

    /**
     * Sets destination_address
     *
     * @param \OpenAPI\Client\Model\RequiredAddress|null $destination_address destination_address
     *
     * @return self
     */
    public function setDestinationAddress($destination_address)
    {
        $this->container['destination_address'] = $destination_address;

        return $this;
    }

    /**
     * Gets pick_up_location_id
     *
     * @return string|null
     */
    public function getPickUpLocationId()
    {
        return $this->container['pick_up_location_id'];
    }

    /**
     * Sets pick_up_location_id
     *
     * @param string|null $pick_up_location_id An identifier for the pick up location
     *
     * @return self
     */
    public function setPickUpLocationId($pick_up_location_id)
    {
        $this->container['pick_up_location_id'] = $pick_up_location_id;

        return $this;
    }

    /**
     * Gets order_sub_total
     *
     * @return float|null
     */
    public function getOrderSubTotal()
    {
        return $this->container['order_sub_total'];
    }

    /**
     * Sets order_sub_total
     *
     * @param float|null $order_sub_total The sum of all item and modifier pricing
     *
     * @return self
     */
    public function setOrderSubTotal($order_sub_total)
    {
        $this->container['order_sub_total'] = $order_sub_total;

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
            throw new \InvalidArgumentException('invalid length for $currency_code when calling RequestDeliveryQuoteEvent., must be smaller than or equal to 3.');
        }
        if (!is_null($currency_code) && (mb_strlen($currency_code) < 3)) {
            throw new \InvalidArgumentException('invalid length for $currency_code when calling RequestDeliveryQuoteEvent., must be bigger than or equal to 3.');
        }

        $this->container['currency_code'] = $currency_code;

        return $this;
    }

    /**
     * Gets contains_alcoholic_item
     *
     * @return bool|null
     */
    public function getContainsAlcoholicItem()
    {
        return $this->container['contains_alcoholic_item'];
    }

    /**
     * Sets contains_alcoholic_item
     *
     * @param bool|null $contains_alcoholic_item Whether or not the order contains an alcoholic item.
     *
     * @return self
     */
    public function setContainsAlcoholicItem($contains_alcoholic_item)
    {
        $this->container['contains_alcoholic_item'] = $contains_alcoholic_item;

        return $this;
    }

    /**
     * Gets customer_payments
     *
     * @return \OpenAPI\Client\Model\CustomerPayment[]|null
     */
    public function getCustomerPayments()
    {
        return $this->container['customer_payments'];
    }

    /**
     * Sets customer_payments
     *
     * @param \OpenAPI\Client\Model\CustomerPayment[]|null $customer_payments Processed and collectible payments from the customer.
     *
     * @return self
     */
    public function setCustomerPayments($customer_payments)
    {
        $this->container['customer_payments'] = $customer_payments;

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


