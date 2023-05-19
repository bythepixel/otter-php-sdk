<?php
/**
 * DeliveryStatusUpdateRequest
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
 * DeliveryStatusUpdateRequest Class Doc Comment
 *
 * @category Class
 * @description Update delivery status request.
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class DeliveryStatusUpdateRequest implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'DeliveryStatusUpdateRequest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'delivery_status' => '\OpenAPI\Client\Model\DeliveryStatus',
        'estimated_delivery_time' => '\DateTime',
        'estimated_pickup_time' => '\DateTime',
        'courier' => '\OpenAPI\Client\Model\Person',
        'location' => '\OpenAPI\Client\Model\Location',
        'created_at' => '\DateTime',
        'vehicle_information' => '\OpenAPI\Client\Model\VehicleInformation',
        'currency_code' => 'string',
        'cost' => '\OpenAPI\Client\Model\DeliveryCost',
        'provider_delivery_id' => 'string',
        'dropoff_info' => '\OpenAPI\Client\Model\DropoffInfo',
        'delivery_tracking_url' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'delivery_status' => null,
        'estimated_delivery_time' => 'date-time',
        'estimated_pickup_time' => 'date-time',
        'courier' => null,
        'location' => null,
        'created_at' => 'date-time',
        'vehicle_information' => null,
        'currency_code' => null,
        'cost' => null,
        'provider_delivery_id' => null,
        'dropoff_info' => null,
        'delivery_tracking_url' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'delivery_status' => false,
		'estimated_delivery_time' => true,
		'estimated_pickup_time' => true,
		'courier' => true,
		'location' => true,
		'created_at' => false,
		'vehicle_information' => true,
		'currency_code' => true,
		'cost' => false,
		'provider_delivery_id' => true,
		'dropoff_info' => true,
		'delivery_tracking_url' => true
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
        'delivery_status' => 'deliveryStatus',
        'estimated_delivery_time' => 'estimatedDeliveryTime',
        'estimated_pickup_time' => 'estimatedPickupTime',
        'courier' => 'courier',
        'location' => 'location',
        'created_at' => 'createdAt',
        'vehicle_information' => 'vehicleInformation',
        'currency_code' => 'currencyCode',
        'cost' => 'cost',
        'provider_delivery_id' => 'providerDeliveryId',
        'dropoff_info' => 'dropoffInfo',
        'delivery_tracking_url' => 'deliveryTrackingUrl'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'delivery_status' => 'setDeliveryStatus',
        'estimated_delivery_time' => 'setEstimatedDeliveryTime',
        'estimated_pickup_time' => 'setEstimatedPickupTime',
        'courier' => 'setCourier',
        'location' => 'setLocation',
        'created_at' => 'setCreatedAt',
        'vehicle_information' => 'setVehicleInformation',
        'currency_code' => 'setCurrencyCode',
        'cost' => 'setCost',
        'provider_delivery_id' => 'setProviderDeliveryId',
        'dropoff_info' => 'setDropoffInfo',
        'delivery_tracking_url' => 'setDeliveryTrackingUrl'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'delivery_status' => 'getDeliveryStatus',
        'estimated_delivery_time' => 'getEstimatedDeliveryTime',
        'estimated_pickup_time' => 'getEstimatedPickupTime',
        'courier' => 'getCourier',
        'location' => 'getLocation',
        'created_at' => 'getCreatedAt',
        'vehicle_information' => 'getVehicleInformation',
        'currency_code' => 'getCurrencyCode',
        'cost' => 'getCost',
        'provider_delivery_id' => 'getProviderDeliveryId',
        'dropoff_info' => 'getDropoffInfo',
        'delivery_tracking_url' => 'getDeliveryTrackingUrl'
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
        $this->setIfExists('delivery_status', $data ?? [], null);
        $this->setIfExists('estimated_delivery_time', $data ?? [], null);
        $this->setIfExists('estimated_pickup_time', $data ?? [], null);
        $this->setIfExists('courier', $data ?? [], null);
        $this->setIfExists('location', $data ?? [], null);
        $this->setIfExists('created_at', $data ?? [], null);
        $this->setIfExists('vehicle_information', $data ?? [], null);
        $this->setIfExists('currency_code', $data ?? [], null);
        $this->setIfExists('cost', $data ?? [], null);
        $this->setIfExists('provider_delivery_id', $data ?? [], null);
        $this->setIfExists('dropoff_info', $data ?? [], null);
        $this->setIfExists('delivery_tracking_url', $data ?? [], null);
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
     * Gets delivery_status
     *
     * @return \OpenAPI\Client\Model\DeliveryStatus|null
     */
    public function getDeliveryStatus()
    {
        return $this->container['delivery_status'];
    }

    /**
     * Sets delivery_status
     *
     * @param \OpenAPI\Client\Model\DeliveryStatus|null $delivery_status delivery_status
     *
     * @return self
     */
    public function setDeliveryStatus($delivery_status)
    {

        if (is_null($delivery_status)) {
            throw new \InvalidArgumentException('non-nullable delivery_status cannot be null');
        }

        $this->container['delivery_status'] = $delivery_status;

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
     * @param \DateTime|null $estimated_delivery_time The expected delivery time.
     *
     * @return self
     */
    public function setEstimatedDeliveryTime($estimated_delivery_time)
    {

        if (is_null($estimated_delivery_time)) {
            array_push($this->openAPINullablesSetToNull, 'estimated_delivery_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('estimated_delivery_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

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
     * @param \DateTime|null $estimated_pickup_time The expected pickup time.
     *
     * @return self
     */
    public function setEstimatedPickupTime($estimated_pickup_time)
    {

        if (is_null($estimated_pickup_time)) {
            array_push($this->openAPINullablesSetToNull, 'estimated_pickup_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('estimated_pickup_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['estimated_pickup_time'] = $estimated_pickup_time;

        return $this;
    }

    /**
     * Gets courier
     *
     * @return \OpenAPI\Client\Model\Person|null
     */
    public function getCourier()
    {
        return $this->container['courier'];
    }

    /**
     * Sets courier
     *
     * @param \OpenAPI\Client\Model\Person|null $courier courier
     *
     * @return self
     */
    public function setCourier($courier)
    {

        if (is_null($courier)) {
            array_push($this->openAPINullablesSetToNull, 'courier');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('courier', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['courier'] = $courier;

        return $this;
    }

    /**
     * Gets location
     *
     * @return \OpenAPI\Client\Model\Location|null
     */
    public function getLocation()
    {
        return $this->container['location'];
    }

    /**
     * Sets location
     *
     * @param \OpenAPI\Client\Model\Location|null $location location
     *
     * @return self
     */
    public function setLocation($location)
    {

        if (is_null($location)) {
            array_push($this->openAPINullablesSetToNull, 'location');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('location', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['location'] = $location;

        return $this;
    }

    /**
     * Gets created_at
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->container['created_at'];
    }

    /**
     * Sets created_at
     *
     * @param \DateTime|null $created_at The time that the update was created.
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {

        if (is_null($created_at)) {
            throw new \InvalidArgumentException('non-nullable created_at cannot be null');
        }

        $this->container['created_at'] = $created_at;

        return $this;
    }

    /**
     * Gets vehicle_information
     *
     * @return \OpenAPI\Client\Model\VehicleInformation|null
     */
    public function getVehicleInformation()
    {
        return $this->container['vehicle_information'];
    }

    /**
     * Sets vehicle_information
     *
     * @param \OpenAPI\Client\Model\VehicleInformation|null $vehicle_information vehicle_information
     *
     * @return self
     */
    public function setVehicleInformation($vehicle_information)
    {

        if (is_null($vehicle_information)) {
            array_push($this->openAPINullablesSetToNull, 'vehicle_information');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('vehicle_information', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['vehicle_information'] = $vehicle_information;

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
            throw new \InvalidArgumentException('invalid length for $currency_code when calling DeliveryStatusUpdateRequest., must be smaller than or equal to 3.');
        }
        if (!is_null($currency_code) && (mb_strlen($currency_code) < 3)) {
            throw new \InvalidArgumentException('invalid length for $currency_code when calling DeliveryStatusUpdateRequest., must be bigger than or equal to 3.');
        }


        if (is_null($currency_code)) {
            array_push($this->openAPINullablesSetToNull, 'currency_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('currency_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['currency_code'] = $currency_code;

        return $this;
    }

    /**
     * Gets cost
     *
     * @return \OpenAPI\Client\Model\DeliveryCost|null
     */
    public function getCost()
    {
        return $this->container['cost'];
    }

    /**
     * Sets cost
     *
     * @param \OpenAPI\Client\Model\DeliveryCost|null $cost cost
     *
     * @return self
     */
    public function setCost($cost)
    {

        if (is_null($cost)) {
            throw new \InvalidArgumentException('non-nullable cost cannot be null');
        }

        $this->container['cost'] = $cost;

        return $this;
    }

    /**
     * Gets provider_delivery_id
     *
     * @return string|null
     */
    public function getProviderDeliveryId()
    {
        return $this->container['provider_delivery_id'];
    }

    /**
     * Sets provider_delivery_id
     *
     * @param string|null $provider_delivery_id The provider's internal identifier for the delivery used for tracking purposes.
     *
     * @return self
     */
    public function setProviderDeliveryId($provider_delivery_id)
    {

        if (is_null($provider_delivery_id)) {
            array_push($this->openAPINullablesSetToNull, 'provider_delivery_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('provider_delivery_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['provider_delivery_id'] = $provider_delivery_id;

        return $this;
    }

    /**
     * Gets dropoff_info
     *
     * @return \OpenAPI\Client\Model\DropoffInfo|null
     */
    public function getDropoffInfo()
    {
        return $this->container['dropoff_info'];
    }

    /**
     * Sets dropoff_info
     *
     * @param \OpenAPI\Client\Model\DropoffInfo|null $dropoff_info dropoff_info
     *
     * @return self
     */
    public function setDropoffInfo($dropoff_info)
    {

        if (is_null($dropoff_info)) {
            array_push($this->openAPINullablesSetToNull, 'dropoff_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('dropoff_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['dropoff_info'] = $dropoff_info;

        return $this;
    }

    /**
     * Gets delivery_tracking_url
     *
     * @return string|null
     */
    public function getDeliveryTrackingUrl()
    {
        return $this->container['delivery_tracking_url'];
    }

    /**
     * Sets delivery_tracking_url
     *
     * @param string|null $delivery_tracking_url Delivery tracking url.
     *
     * @return self
     */
    public function setDeliveryTrackingUrl($delivery_tracking_url)
    {

        if (is_null($delivery_tracking_url)) {
            array_push($this->openAPINullablesSetToNull, 'delivery_tracking_url');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('delivery_tracking_url', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['delivery_tracking_url'] = $delivery_tracking_url;

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


