<?php
/**
 * OrderTotalV2CustomerTotal
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
 * OpenAPI Generator version: 6.2.1
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
 * OrderTotalV2CustomerTotal Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class OrderTotalV2CustomerTotal implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'OrderTotalV2_customerTotal';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'food_sales' => '\OpenAPI\Client\Model\FinancialDataFoodSales',
        'fee_for_restaurant_provided_delivery' => '\OpenAPI\Client\Model\FinancialDataFeeForRestaurantProvidedDelivery',
        'restaurant_funded_discount' => '\OpenAPI\Client\Model\FinancialDataRestaurantFundedDiscount',
        'tip_for_restaurant' => '\OpenAPI\Client\Model\FinancialDataTipForRestaurant',
        'adjustments' => '\OpenAPI\Client\Model\FinancialDataAdjustments',
        'packing_fee' => '\OpenAPI\Client\Model\FinancialDataPackingFee',
        'bag_fee' => '\OpenAPI\Client\Model\FinancialDataBagFee',
        'service_provider_discount' => '\OpenAPI\Client\Model\FinancialDataServiceProviderDiscount',
        'tip_for_service_provider_courier' => '\OpenAPI\Client\Model\FinancialDataTipForServiceProviderCourier',
        'fee_for_service_provider_delivery' => '\OpenAPI\Client\Model\FinancialDataFeeForServiceProviderDelivery',
        'small_order_fee' => '\OpenAPI\Client\Model\FinancialDataSmallOrderFee',
        'service_fee' => '\OpenAPI\Client\Model\FinancialDataServiceFee',
        'other_fee' => '\OpenAPI\Client\Model\FinancialDataOtherFee',
        'net_payout' => '\OpenAPI\Client\Model\FinancialDataNetPayout',
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
        'net_payout' => null,
        'coupon_codes' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'food_sales' => false,
		'fee_for_restaurant_provided_delivery' => true,
		'restaurant_funded_discount' => true,
		'tip_for_restaurant' => true,
		'adjustments' => true,
		'packing_fee' => true,
		'bag_fee' => true,
		'service_provider_discount' => true,
		'tip_for_service_provider_courier' => true,
		'fee_for_service_provider_delivery' => true,
		'small_order_fee' => true,
		'service_fee' => true,
		'other_fee' => true,
		'net_payout' => true,
		'coupon_codes' => true
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
        'net_payout' => 'netPayout',
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
        'net_payout' => 'setNetPayout',
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
        'net_payout' => 'getNetPayout',
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
        $this->setIfExists('food_sales', $data ?? [], null);
        $this->setIfExists('fee_for_restaurant_provided_delivery', $data ?? [], null);
        $this->setIfExists('restaurant_funded_discount', $data ?? [], null);
        $this->setIfExists('tip_for_restaurant', $data ?? [], null);
        $this->setIfExists('adjustments', $data ?? [], null);
        $this->setIfExists('packing_fee', $data ?? [], null);
        $this->setIfExists('bag_fee', $data ?? [], null);
        $this->setIfExists('service_provider_discount', $data ?? [], null);
        $this->setIfExists('tip_for_service_provider_courier', $data ?? [], null);
        $this->setIfExists('fee_for_service_provider_delivery', $data ?? [], null);
        $this->setIfExists('small_order_fee', $data ?? [], null);
        $this->setIfExists('service_fee', $data ?? [], null);
        $this->setIfExists('other_fee', $data ?? [], null);
        $this->setIfExists('net_payout', $data ?? [], null);
        $this->setIfExists('coupon_codes', $data ?? [], null);
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
     * @return \OpenAPI\Client\Model\FinancialDataFoodSales
     */
    public function getFoodSales()
    {
        return $this->container['food_sales'];
    }

    /**
     * Sets food_sales
     *
     * @param \OpenAPI\Client\Model\FinancialDataFoodSales $food_sales food_sales
     *
     * @return self
     */
    public function setFoodSales($food_sales)
    {

        if (is_null($food_sales)) {
            throw new \InvalidArgumentException('non-nullable food_sales cannot be null');
        }

        $this->container['food_sales'] = $food_sales;

        return $this;
    }

    /**
     * Gets fee_for_restaurant_provided_delivery
     *
     * @return \OpenAPI\Client\Model\FinancialDataFeeForRestaurantProvidedDelivery|null
     */
    public function getFeeForRestaurantProvidedDelivery()
    {
        return $this->container['fee_for_restaurant_provided_delivery'];
    }

    /**
     * Sets fee_for_restaurant_provided_delivery
     *
     * @param \OpenAPI\Client\Model\FinancialDataFeeForRestaurantProvidedDelivery|null $fee_for_restaurant_provided_delivery fee_for_restaurant_provided_delivery
     *
     * @return self
     */
    public function setFeeForRestaurantProvidedDelivery($fee_for_restaurant_provided_delivery)
    {

        if (is_null($fee_for_restaurant_provided_delivery)) {
            array_push($this->openAPINullablesSetToNull, 'fee_for_restaurant_provided_delivery');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('fee_for_restaurant_provided_delivery', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['fee_for_restaurant_provided_delivery'] = $fee_for_restaurant_provided_delivery;

        return $this;
    }

    /**
     * Gets restaurant_funded_discount
     *
     * @return \OpenAPI\Client\Model\FinancialDataRestaurantFundedDiscount|null
     */
    public function getRestaurantFundedDiscount()
    {
        return $this->container['restaurant_funded_discount'];
    }

    /**
     * Sets restaurant_funded_discount
     *
     * @param \OpenAPI\Client\Model\FinancialDataRestaurantFundedDiscount|null $restaurant_funded_discount restaurant_funded_discount
     *
     * @return self
     */
    public function setRestaurantFundedDiscount($restaurant_funded_discount)
    {

        if (is_null($restaurant_funded_discount)) {
            array_push($this->openAPINullablesSetToNull, 'restaurant_funded_discount');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('restaurant_funded_discount', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['restaurant_funded_discount'] = $restaurant_funded_discount;

        return $this;
    }

    /**
     * Gets tip_for_restaurant
     *
     * @return \OpenAPI\Client\Model\FinancialDataTipForRestaurant|null
     */
    public function getTipForRestaurant()
    {
        return $this->container['tip_for_restaurant'];
    }

    /**
     * Sets tip_for_restaurant
     *
     * @param \OpenAPI\Client\Model\FinancialDataTipForRestaurant|null $tip_for_restaurant tip_for_restaurant
     *
     * @return self
     */
    public function setTipForRestaurant($tip_for_restaurant)
    {

        if (is_null($tip_for_restaurant)) {
            array_push($this->openAPINullablesSetToNull, 'tip_for_restaurant');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('tip_for_restaurant', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['tip_for_restaurant'] = $tip_for_restaurant;

        return $this;
    }

    /**
     * Gets adjustments
     *
     * @return \OpenAPI\Client\Model\FinancialDataAdjustments|null
     */
    public function getAdjustments()
    {
        return $this->container['adjustments'];
    }

    /**
     * Sets adjustments
     *
     * @param \OpenAPI\Client\Model\FinancialDataAdjustments|null $adjustments adjustments
     *
     * @return self
     */
    public function setAdjustments($adjustments)
    {

        if (is_null($adjustments)) {
            array_push($this->openAPINullablesSetToNull, 'adjustments');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('adjustments', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['adjustments'] = $adjustments;

        return $this;
    }

    /**
     * Gets packing_fee
     *
     * @return \OpenAPI\Client\Model\FinancialDataPackingFee|null
     */
    public function getPackingFee()
    {
        return $this->container['packing_fee'];
    }

    /**
     * Sets packing_fee
     *
     * @param \OpenAPI\Client\Model\FinancialDataPackingFee|null $packing_fee packing_fee
     *
     * @return self
     */
    public function setPackingFee($packing_fee)
    {

        if (is_null($packing_fee)) {
            array_push($this->openAPINullablesSetToNull, 'packing_fee');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('packing_fee', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['packing_fee'] = $packing_fee;

        return $this;
    }

    /**
     * Gets bag_fee
     *
     * @return \OpenAPI\Client\Model\FinancialDataBagFee|null
     */
    public function getBagFee()
    {
        return $this->container['bag_fee'];
    }

    /**
     * Sets bag_fee
     *
     * @param \OpenAPI\Client\Model\FinancialDataBagFee|null $bag_fee bag_fee
     *
     * @return self
     */
    public function setBagFee($bag_fee)
    {

        if (is_null($bag_fee)) {
            array_push($this->openAPINullablesSetToNull, 'bag_fee');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('bag_fee', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['bag_fee'] = $bag_fee;

        return $this;
    }

    /**
     * Gets service_provider_discount
     *
     * @return \OpenAPI\Client\Model\FinancialDataServiceProviderDiscount|null
     */
    public function getServiceProviderDiscount()
    {
        return $this->container['service_provider_discount'];
    }

    /**
     * Sets service_provider_discount
     *
     * @param \OpenAPI\Client\Model\FinancialDataServiceProviderDiscount|null $service_provider_discount service_provider_discount
     *
     * @return self
     */
    public function setServiceProviderDiscount($service_provider_discount)
    {

        if (is_null($service_provider_discount)) {
            array_push($this->openAPINullablesSetToNull, 'service_provider_discount');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('service_provider_discount', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['service_provider_discount'] = $service_provider_discount;

        return $this;
    }

    /**
     * Gets tip_for_service_provider_courier
     *
     * @return \OpenAPI\Client\Model\FinancialDataTipForServiceProviderCourier|null
     */
    public function getTipForServiceProviderCourier()
    {
        return $this->container['tip_for_service_provider_courier'];
    }

    /**
     * Sets tip_for_service_provider_courier
     *
     * @param \OpenAPI\Client\Model\FinancialDataTipForServiceProviderCourier|null $tip_for_service_provider_courier tip_for_service_provider_courier
     *
     * @return self
     */
    public function setTipForServiceProviderCourier($tip_for_service_provider_courier)
    {

        if (is_null($tip_for_service_provider_courier)) {
            array_push($this->openAPINullablesSetToNull, 'tip_for_service_provider_courier');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('tip_for_service_provider_courier', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['tip_for_service_provider_courier'] = $tip_for_service_provider_courier;

        return $this;
    }

    /**
     * Gets fee_for_service_provider_delivery
     *
     * @return \OpenAPI\Client\Model\FinancialDataFeeForServiceProviderDelivery|null
     */
    public function getFeeForServiceProviderDelivery()
    {
        return $this->container['fee_for_service_provider_delivery'];
    }

    /**
     * Sets fee_for_service_provider_delivery
     *
     * @param \OpenAPI\Client\Model\FinancialDataFeeForServiceProviderDelivery|null $fee_for_service_provider_delivery fee_for_service_provider_delivery
     *
     * @return self
     */
    public function setFeeForServiceProviderDelivery($fee_for_service_provider_delivery)
    {

        if (is_null($fee_for_service_provider_delivery)) {
            array_push($this->openAPINullablesSetToNull, 'fee_for_service_provider_delivery');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('fee_for_service_provider_delivery', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['fee_for_service_provider_delivery'] = $fee_for_service_provider_delivery;

        return $this;
    }

    /**
     * Gets small_order_fee
     *
     * @return \OpenAPI\Client\Model\FinancialDataSmallOrderFee|null
     */
    public function getSmallOrderFee()
    {
        return $this->container['small_order_fee'];
    }

    /**
     * Sets small_order_fee
     *
     * @param \OpenAPI\Client\Model\FinancialDataSmallOrderFee|null $small_order_fee small_order_fee
     *
     * @return self
     */
    public function setSmallOrderFee($small_order_fee)
    {

        if (is_null($small_order_fee)) {
            array_push($this->openAPINullablesSetToNull, 'small_order_fee');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('small_order_fee', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['small_order_fee'] = $small_order_fee;

        return $this;
    }

    /**
     * Gets service_fee
     *
     * @return \OpenAPI\Client\Model\FinancialDataServiceFee|null
     */
    public function getServiceFee()
    {
        return $this->container['service_fee'];
    }

    /**
     * Sets service_fee
     *
     * @param \OpenAPI\Client\Model\FinancialDataServiceFee|null $service_fee service_fee
     *
     * @return self
     */
    public function setServiceFee($service_fee)
    {

        if (is_null($service_fee)) {
            array_push($this->openAPINullablesSetToNull, 'service_fee');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('service_fee', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['service_fee'] = $service_fee;

        return $this;
    }

    /**
     * Gets other_fee
     *
     * @return \OpenAPI\Client\Model\FinancialDataOtherFee|null
     */
    public function getOtherFee()
    {
        return $this->container['other_fee'];
    }

    /**
     * Sets other_fee
     *
     * @param \OpenAPI\Client\Model\FinancialDataOtherFee|null $other_fee other_fee
     *
     * @return self
     */
    public function setOtherFee($other_fee)
    {

        if (is_null($other_fee)) {
            array_push($this->openAPINullablesSetToNull, 'other_fee');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('other_fee', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['other_fee'] = $other_fee;

        return $this;
    }

    /**
     * Gets net_payout
     *
     * @return \OpenAPI\Client\Model\FinancialDataNetPayout|null
     */
    public function getNetPayout()
    {
        return $this->container['net_payout'];
    }

    /**
     * Sets net_payout
     *
     * @param \OpenAPI\Client\Model\FinancialDataNetPayout|null $net_payout net_payout
     *
     * @return self
     */
    public function setNetPayout($net_payout)
    {

        if (is_null($net_payout)) {
            array_push($this->openAPINullablesSetToNull, 'net_payout');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('net_payout', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['net_payout'] = $net_payout;

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
     * @param string[]|null $coupon_codes Any codes entered by the customer at order checkout.
     *
     * @return self
     */
    public function setCouponCodes($coupon_codes)
    {

        if (is_null($coupon_codes)) {
            array_push($this->openAPINullablesSetToNull, 'coupon_codes');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('coupon_codes', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

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


