<?php
/**
 * FinancialData
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
 * FinancialData Class Doc Comment
 *
 * @category Class
 * @description Customer total breakdown.
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class FinancialData implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'FinancialData';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'food_sales' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'fee_for_restaurant_provided_delivery' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'restaurant_funded_discount' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'tip_for_restaurant' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'adjustments' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'packing_fee' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'bag_fee' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'service_provider_discount' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'tip_for_service_provider_courier' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'fee_for_service_provider_delivery' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'small_order_fee' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'service_fee' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'other_fee' => '\OpenAPI\Client\Model\CompositeFinanceLine',
        'coupon_codes' => 'string[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'food_sales' => null,
        'fee_for_restaurant_provided_delivery' => null,
        'restaurant_funded_discount' => null,
        'tip_for_restaurant' => null,
        'adjustments' => null,
        'packing_fee' => null,
        'bag_fee' => null,
        'service_provider_discount' => null,
        'tip_for_service_provider_courier' => null,
        'fee_for_service_provider_delivery' => null,
        'small_order_fee' => null,
        'service_fee' => null,
        'other_fee' => null,
        'coupon_codes' => null
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
        'food_sales' => 'foodSales',
        'fee_for_restaurant_provided_delivery' => 'feeForRestaurantProvidedDelivery',
        'restaurant_funded_discount' => 'restaurantFundedDiscount',
        'tip_for_restaurant' => 'tipForRestaurant',
        'adjustments' => 'adjustments',
        'packing_fee' => 'packingFee',
        'bag_fee' => 'bagFee',
        'service_provider_discount' => 'serviceProviderDiscount',
        'tip_for_service_provider_courier' => 'tipForServiceProviderCourier',
        'fee_for_service_provider_delivery' => 'feeForServiceProviderDelivery',
        'small_order_fee' => 'smallOrderFee',
        'service_fee' => 'serviceFee',
        'other_fee' => 'otherFee',
        'coupon_codes' => 'couponCodes'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'food_sales' => 'setFoodSales',
        'fee_for_restaurant_provided_delivery' => 'setFeeForRestaurantProvidedDelivery',
        'restaurant_funded_discount' => 'setRestaurantFundedDiscount',
        'tip_for_restaurant' => 'setTipForRestaurant',
        'adjustments' => 'setAdjustments',
        'packing_fee' => 'setPackingFee',
        'bag_fee' => 'setBagFee',
        'service_provider_discount' => 'setServiceProviderDiscount',
        'tip_for_service_provider_courier' => 'setTipForServiceProviderCourier',
        'fee_for_service_provider_delivery' => 'setFeeForServiceProviderDelivery',
        'small_order_fee' => 'setSmallOrderFee',
        'service_fee' => 'setServiceFee',
        'other_fee' => 'setOtherFee',
        'coupon_codes' => 'setCouponCodes'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'food_sales' => 'getFoodSales',
        'fee_for_restaurant_provided_delivery' => 'getFeeForRestaurantProvidedDelivery',
        'restaurant_funded_discount' => 'getRestaurantFundedDiscount',
        'tip_for_restaurant' => 'getTipForRestaurant',
        'adjustments' => 'getAdjustments',
        'packing_fee' => 'getPackingFee',
        'bag_fee' => 'getBagFee',
        'service_provider_discount' => 'getServiceProviderDiscount',
        'tip_for_service_provider_courier' => 'getTipForServiceProviderCourier',
        'fee_for_service_provider_delivery' => 'getFeeForServiceProviderDelivery',
        'small_order_fee' => 'getSmallOrderFee',
        'service_fee' => 'getServiceFee',
        'other_fee' => 'getOtherFee',
        'coupon_codes' => 'getCouponCodes'
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
        $this->container['food_sales'] = $data['food_sales'] ?? null;
        $this->container['fee_for_restaurant_provided_delivery'] = $data['fee_for_restaurant_provided_delivery'] ?? null;
        $this->container['restaurant_funded_discount'] = $data['restaurant_funded_discount'] ?? null;
        $this->container['tip_for_restaurant'] = $data['tip_for_restaurant'] ?? null;
        $this->container['adjustments'] = $data['adjustments'] ?? null;
        $this->container['packing_fee'] = $data['packing_fee'] ?? null;
        $this->container['bag_fee'] = $data['bag_fee'] ?? null;
        $this->container['service_provider_discount'] = $data['service_provider_discount'] ?? null;
        $this->container['tip_for_service_provider_courier'] = $data['tip_for_service_provider_courier'] ?? null;
        $this->container['fee_for_service_provider_delivery'] = $data['fee_for_service_provider_delivery'] ?? null;
        $this->container['small_order_fee'] = $data['small_order_fee'] ?? null;
        $this->container['service_fee'] = $data['service_fee'] ?? null;
        $this->container['other_fee'] = $data['other_fee'] ?? null;
        $this->container['coupon_codes'] = $data['coupon_codes'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['food_sales'] === null) {
            $invalidProperties[] = "'food_sales' can't be null";
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
     * Gets food_sales
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine
     */
    public function getFoodSales()
    {
        return $this->container['food_sales'];
    }

    /**
     * Sets food_sales
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine $food_sales food_sales
     *
     * @return self
     */
    public function setFoodSales($food_sales)
    {
        $this->container['food_sales'] = $food_sales;

        return $this;
    }

    /**
     * Gets fee_for_restaurant_provided_delivery
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getFeeForRestaurantProvidedDelivery()
    {
        return $this->container['fee_for_restaurant_provided_delivery'];
    }

    /**
     * Sets fee_for_restaurant_provided_delivery
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $fee_for_restaurant_provided_delivery fee_for_restaurant_provided_delivery
     *
     * @return self
     */
    public function setFeeForRestaurantProvidedDelivery($fee_for_restaurant_provided_delivery)
    {
        $this->container['fee_for_restaurant_provided_delivery'] = $fee_for_restaurant_provided_delivery;

        return $this;
    }

    /**
     * Gets restaurant_funded_discount
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getRestaurantFundedDiscount()
    {
        return $this->container['restaurant_funded_discount'];
    }

    /**
     * Sets restaurant_funded_discount
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $restaurant_funded_discount restaurant_funded_discount
     *
     * @return self
     */
    public function setRestaurantFundedDiscount($restaurant_funded_discount)
    {
        $this->container['restaurant_funded_discount'] = $restaurant_funded_discount;

        return $this;
    }

    /**
     * Gets tip_for_restaurant
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getTipForRestaurant()
    {
        return $this->container['tip_for_restaurant'];
    }

    /**
     * Sets tip_for_restaurant
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $tip_for_restaurant tip_for_restaurant
     *
     * @return self
     */
    public function setTipForRestaurant($tip_for_restaurant)
    {
        $this->container['tip_for_restaurant'] = $tip_for_restaurant;

        return $this;
    }

    /**
     * Gets adjustments
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getAdjustments()
    {
        return $this->container['adjustments'];
    }

    /**
     * Sets adjustments
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $adjustments adjustments
     *
     * @return self
     */
    public function setAdjustments($adjustments)
    {
        $this->container['adjustments'] = $adjustments;

        return $this;
    }

    /**
     * Gets packing_fee
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getPackingFee()
    {
        return $this->container['packing_fee'];
    }

    /**
     * Sets packing_fee
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $packing_fee packing_fee
     *
     * @return self
     */
    public function setPackingFee($packing_fee)
    {
        $this->container['packing_fee'] = $packing_fee;

        return $this;
    }

    /**
     * Gets bag_fee
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getBagFee()
    {
        return $this->container['bag_fee'];
    }

    /**
     * Sets bag_fee
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $bag_fee bag_fee
     *
     * @return self
     */
    public function setBagFee($bag_fee)
    {
        $this->container['bag_fee'] = $bag_fee;

        return $this;
    }

    /**
     * Gets service_provider_discount
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getServiceProviderDiscount()
    {
        return $this->container['service_provider_discount'];
    }

    /**
     * Sets service_provider_discount
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $service_provider_discount service_provider_discount
     *
     * @return self
     */
    public function setServiceProviderDiscount($service_provider_discount)
    {
        $this->container['service_provider_discount'] = $service_provider_discount;

        return $this;
    }

    /**
     * Gets tip_for_service_provider_courier
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getTipForServiceProviderCourier()
    {
        return $this->container['tip_for_service_provider_courier'];
    }

    /**
     * Sets tip_for_service_provider_courier
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $tip_for_service_provider_courier tip_for_service_provider_courier
     *
     * @return self
     */
    public function setTipForServiceProviderCourier($tip_for_service_provider_courier)
    {
        $this->container['tip_for_service_provider_courier'] = $tip_for_service_provider_courier;

        return $this;
    }

    /**
     * Gets fee_for_service_provider_delivery
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getFeeForServiceProviderDelivery()
    {
        return $this->container['fee_for_service_provider_delivery'];
    }

    /**
     * Sets fee_for_service_provider_delivery
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $fee_for_service_provider_delivery fee_for_service_provider_delivery
     *
     * @return self
     */
    public function setFeeForServiceProviderDelivery($fee_for_service_provider_delivery)
    {
        $this->container['fee_for_service_provider_delivery'] = $fee_for_service_provider_delivery;

        return $this;
    }

    /**
     * Gets small_order_fee
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getSmallOrderFee()
    {
        return $this->container['small_order_fee'];
    }

    /**
     * Sets small_order_fee
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $small_order_fee small_order_fee
     *
     * @return self
     */
    public function setSmallOrderFee($small_order_fee)
    {
        $this->container['small_order_fee'] = $small_order_fee;

        return $this;
    }

    /**
     * Gets service_fee
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getServiceFee()
    {
        return $this->container['service_fee'];
    }

    /**
     * Sets service_fee
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $service_fee service_fee
     *
     * @return self
     */
    public function setServiceFee($service_fee)
    {
        $this->container['service_fee'] = $service_fee;

        return $this;
    }

    /**
     * Gets other_fee
     *
     * @return \OpenAPI\Client\Model\CompositeFinanceLine|null
     */
    public function getOtherFee()
    {
        return $this->container['other_fee'];
    }

    /**
     * Sets other_fee
     *
     * @param \OpenAPI\Client\Model\CompositeFinanceLine|null $other_fee other_fee
     *
     * @return self
     */
    public function setOtherFee($other_fee)
    {
        $this->container['other_fee'] = $other_fee;

        return $this;
    }

    /**
     * Gets coupon_codes
     *
     * @return string[]|null
     */
    public function getCouponCodes()
    {
        return $this->container['coupon_codes'];
    }

    /**
     * Sets coupon_codes
     *
     * @param string[]|null $coupon_codes coupon codes used.
     *
     * @return self
     */
    public function setCouponCodes($coupon_codes)
    {
        $this->container['coupon_codes'] = $coupon_codes;

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


