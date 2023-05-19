<?php
/**
 * AcceptDeliveryEvent
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
 * AcceptDeliveryEvent Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class AcceptDeliveryEvent implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'AcceptDeliveryEvent';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'delivery_reference_id' => 'string',
        'provider' => 'string',
        'preferred_pickup_time' => '\DateTime',
        'pickup_order_id' => 'string',
        'pickup_note' => 'string',
        'pickup_address' => '\OpenAPI\Client\Model\RequestDeliveryQuoteEventPickupAddress',
        'dropoff_note' => 'string',
        'dropoff_address' => '\OpenAPI\Client\Model\RequestDeliveryQuoteEventDropoffAddress',
        'customer' => '\OpenAPI\Client\Model\RequiredPerson',
        'customer_payments' => '\OpenAPI\Client\Model\CustomerPayment[]',
        'currency_code' => 'string',
        'customer_tip' => '\OpenAPI\Client\Model\CustomerTip',
        'order_sub_total' => 'float',
        'pick_up_location_id' => 'string',
        'contains_alcoholic_item' => 'bool',
        'pick_up_instructions' => 'string',
        'store' => '\OpenAPI\Client\Model\Store',
        'order_items' => '\OpenAPI\Client\Model\Item2[]',
        'ofo_display_id' => 'string',
        'ofo_slug' => 'string',
        'pick_up_info' => '\OpenAPI\Client\Model\PickUpInfo',
        'order_external_identifiers' => '\OpenAPI\Client\Model\OrderExternalIdentifiers',
        'dropoff_instructions' => '\OpenAPI\Client\Model\DropoffInstructions',
        'delivery_fee' => '\OpenAPI\Client\Model\DeliveryFee'
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
        'preferred_pickup_time' => 'date-time',
        'pickup_order_id' => null,
        'pickup_note' => null,
        'pickup_address' => null,
        'dropoff_note' => null,
        'dropoff_address' => null,
        'customer' => null,
        'customer_payments' => null,
        'currency_code' => null,
        'customer_tip' => null,
        'order_sub_total' => null,
        'pick_up_location_id' => null,
        'contains_alcoholic_item' => null,
        'pick_up_instructions' => null,
        'store' => null,
        'order_items' => null,
        'ofo_display_id' => null,
        'ofo_slug' => null,
        'pick_up_info' => null,
        'order_external_identifiers' => null,
        'dropoff_instructions' => null,
        'delivery_fee' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'delivery_reference_id' => false,
		'provider' => false,
		'preferred_pickup_time' => false,
		'pickup_order_id' => false,
		'pickup_note' => true,
		'pickup_address' => false,
		'dropoff_note' => true,
		'dropoff_address' => false,
		'customer' => false,
		'customer_payments' => true,
		'currency_code' => true,
		'customer_tip' => true,
		'order_sub_total' => true,
		'pick_up_location_id' => true,
		'contains_alcoholic_item' => true,
		'pick_up_instructions' => true,
		'store' => true,
		'order_items' => true,
		'ofo_display_id' => true,
		'ofo_slug' => true,
		'pick_up_info' => true,
		'order_external_identifiers' => false,
		'dropoff_instructions' => true,
		'delivery_fee' => true
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
        'delivery_reference_id' => 'deliveryReferenceId',
        'provider' => 'provider',
        'preferred_pickup_time' => 'preferredPickupTime',
        'pickup_order_id' => 'pickupOrderId',
        'pickup_note' => 'pickupNote',
        'pickup_address' => 'pickupAddress',
        'dropoff_note' => 'dropoffNote',
        'dropoff_address' => 'dropoffAddress',
        'customer' => 'customer',
        'customer_payments' => 'customerPayments',
        'currency_code' => 'currencyCode',
        'customer_tip' => 'customerTip',
        'order_sub_total' => 'orderSubTotal',
        'pick_up_location_id' => 'pickUpLocationId',
        'contains_alcoholic_item' => 'containsAlcoholicItem',
        'pick_up_instructions' => 'pickUpInstructions',
        'store' => 'store',
        'order_items' => 'orderItems',
        'ofo_display_id' => 'ofoDisplayId',
        'ofo_slug' => 'ofoSlug',
        'pick_up_info' => 'pickUpInfo',
        'order_external_identifiers' => 'orderExternalIdentifiers',
        'dropoff_instructions' => 'dropoffInstructions',
        'delivery_fee' => 'deliveryFee'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'delivery_reference_id' => 'setDeliveryReferenceId',
        'provider' => 'setProvider',
        'preferred_pickup_time' => 'setPreferredPickupTime',
        'pickup_order_id' => 'setPickupOrderId',
        'pickup_note' => 'setPickupNote',
        'pickup_address' => 'setPickupAddress',
        'dropoff_note' => 'setDropoffNote',
        'dropoff_address' => 'setDropoffAddress',
        'customer' => 'setCustomer',
        'customer_payments' => 'setCustomerPayments',
        'currency_code' => 'setCurrencyCode',
        'customer_tip' => 'setCustomerTip',
        'order_sub_total' => 'setOrderSubTotal',
        'pick_up_location_id' => 'setPickUpLocationId',
        'contains_alcoholic_item' => 'setContainsAlcoholicItem',
        'pick_up_instructions' => 'setPickUpInstructions',
        'store' => 'setStore',
        'order_items' => 'setOrderItems',
        'ofo_display_id' => 'setOfoDisplayId',
        'ofo_slug' => 'setOfoSlug',
        'pick_up_info' => 'setPickUpInfo',
        'order_external_identifiers' => 'setOrderExternalIdentifiers',
        'dropoff_instructions' => 'setDropoffInstructions',
        'delivery_fee' => 'setDeliveryFee'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'delivery_reference_id' => 'getDeliveryReferenceId',
        'provider' => 'getProvider',
        'preferred_pickup_time' => 'getPreferredPickupTime',
        'pickup_order_id' => 'getPickupOrderId',
        'pickup_note' => 'getPickupNote',
        'pickup_address' => 'getPickupAddress',
        'dropoff_note' => 'getDropoffNote',
        'dropoff_address' => 'getDropoffAddress',
        'customer' => 'getCustomer',
        'customer_payments' => 'getCustomerPayments',
        'currency_code' => 'getCurrencyCode',
        'customer_tip' => 'getCustomerTip',
        'order_sub_total' => 'getOrderSubTotal',
        'pick_up_location_id' => 'getPickUpLocationId',
        'contains_alcoholic_item' => 'getContainsAlcoholicItem',
        'pick_up_instructions' => 'getPickUpInstructions',
        'store' => 'getStore',
        'order_items' => 'getOrderItems',
        'ofo_display_id' => 'getOfoDisplayId',
        'ofo_slug' => 'getOfoSlug',
        'pick_up_info' => 'getPickUpInfo',
        'order_external_identifiers' => 'getOrderExternalIdentifiers',
        'dropoff_instructions' => 'getDropoffInstructions',
        'delivery_fee' => 'getDeliveryFee'
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
        $this->setIfExists('delivery_reference_id', $data ?? [], null);
        $this->setIfExists('provider', $data ?? [], null);
        $this->setIfExists('preferred_pickup_time', $data ?? [], null);
        $this->setIfExists('pickup_order_id', $data ?? [], null);
        $this->setIfExists('pickup_note', $data ?? [], null);
        $this->setIfExists('pickup_address', $data ?? [], null);
        $this->setIfExists('dropoff_note', $data ?? [], null);
        $this->setIfExists('dropoff_address', $data ?? [], null);
        $this->setIfExists('customer', $data ?? [], null);
        $this->setIfExists('customer_payments', $data ?? [], null);
        $this->setIfExists('currency_code', $data ?? [], null);
        $this->setIfExists('customer_tip', $data ?? [], null);
        $this->setIfExists('order_sub_total', $data ?? [], null);
        $this->setIfExists('pick_up_location_id', $data ?? [], null);
        $this->setIfExists('contains_alcoholic_item', $data ?? [], null);
        $this->setIfExists('pick_up_instructions', $data ?? [], null);
        $this->setIfExists('store', $data ?? [], null);
        $this->setIfExists('order_items', $data ?? [], null);
        $this->setIfExists('ofo_display_id', $data ?? [], null);
        $this->setIfExists('ofo_slug', $data ?? [], null);
        $this->setIfExists('pick_up_info', $data ?? [], null);
        $this->setIfExists('order_external_identifiers', $data ?? [], null);
        $this->setIfExists('dropoff_instructions', $data ?? [], null);
        $this->setIfExists('delivery_fee', $data ?? [], null);
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

        if (is_null($delivery_reference_id)) {
            throw new \InvalidArgumentException('non-nullable delivery_reference_id cannot be null');
        }

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

        if (is_null($provider)) {
            throw new \InvalidArgumentException('non-nullable provider cannot be null');
        }

        $this->container['provider'] = $provider;

        return $this;
    }

    /**
     * Gets preferred_pickup_time
     *
     * @return \DateTime|null
     */
    public function getPreferredPickupTime()
    {
        return $this->container['preferred_pickup_time'];
    }

    /**
     * Sets preferred_pickup_time
     *
     * @param \DateTime|null $preferred_pickup_time Preferred time for courier to arrive to pick up order. If not provided or if the timestamp is in the past, treat it as an ASAP request.
     *
     * @return self
     */
    public function setPreferredPickupTime($preferred_pickup_time)
    {

        if (is_null($preferred_pickup_time)) {
            throw new \InvalidArgumentException('non-nullable preferred_pickup_time cannot be null');
        }

        $this->container['preferred_pickup_time'] = $preferred_pickup_time;

        return $this;
    }

    /**
     * Gets pickup_order_id
     *
     * @return string|null
     */
    public function getPickupOrderId()
    {
        return $this->container['pickup_order_id'];
    }

    /**
     * Sets pickup_order_id
     *
     * @param string|null $pickup_order_id An identifier used for picking up order from pickup address.
     *
     * @return self
     */
    public function setPickupOrderId($pickup_order_id)
    {

        if (is_null($pickup_order_id)) {
            throw new \InvalidArgumentException('non-nullable pickup_order_id cannot be null');
        }

        $this->container['pickup_order_id'] = $pickup_order_id;

        return $this;
    }

    /**
     * Gets pickup_note
     *
     * @return string|null
     * @deprecated
     */
    public function getPickupNote()
    {
        return $this->container['pickup_note'];
    }

    /**
     * Sets pickup_note
     *
     * @param string|null $pickup_note Additional information to instruct couriers how to pickup the order. Deprecated in favor of pickUpInstructions.
     *
     * @return self
     * @deprecated
     */
    public function setPickupNote($pickup_note)
    {

        if (is_null($pickup_note)) {
            array_push($this->openAPINullablesSetToNull, 'pickup_note');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('pickup_note', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['pickup_note'] = $pickup_note;

        return $this;
    }

    /**
     * Gets pickup_address
     *
     * @return \OpenAPI\Client\Model\RequestDeliveryQuoteEventPickupAddress|null
     */
    public function getPickupAddress()
    {
        return $this->container['pickup_address'];
    }

    /**
     * Sets pickup_address
     *
     * @param \OpenAPI\Client\Model\RequestDeliveryQuoteEventPickupAddress|null $pickup_address pickup_address
     *
     * @return self
     */
    public function setPickupAddress($pickup_address)
    {

        if (is_null($pickup_address)) {
            throw new \InvalidArgumentException('non-nullable pickup_address cannot be null');
        }

        $this->container['pickup_address'] = $pickup_address;

        return $this;
    }

    /**
     * Gets dropoff_note
     *
     * @return string|null
     */
    public function getDropoffNote()
    {
        return $this->container['dropoff_note'];
    }

    /**
     * Sets dropoff_note
     *
     * @param string|null $dropoff_note Additional information to instruct couriers how to dropoff the order.
     *
     * @return self
     */
    public function setDropoffNote($dropoff_note)
    {

        if (is_null($dropoff_note)) {
            array_push($this->openAPINullablesSetToNull, 'dropoff_note');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('dropoff_note', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['dropoff_note'] = $dropoff_note;

        return $this;
    }

    /**
     * Gets dropoff_address
     *
     * @return \OpenAPI\Client\Model\RequestDeliveryQuoteEventDropoffAddress|null
     */
    public function getDropoffAddress()
    {
        return $this->container['dropoff_address'];
    }

    /**
     * Sets dropoff_address
     *
     * @param \OpenAPI\Client\Model\RequestDeliveryQuoteEventDropoffAddress|null $dropoff_address dropoff_address
     *
     * @return self
     */
    public function setDropoffAddress($dropoff_address)
    {

        if (is_null($dropoff_address)) {
            throw new \InvalidArgumentException('non-nullable dropoff_address cannot be null');
        }

        $this->container['dropoff_address'] = $dropoff_address;

        return $this;
    }

    /**
     * Gets customer
     *
     * @return \OpenAPI\Client\Model\RequiredPerson|null
     */
    public function getCustomer()
    {
        return $this->container['customer'];
    }

    /**
     * Sets customer
     *
     * @param \OpenAPI\Client\Model\RequiredPerson|null $customer customer
     *
     * @return self
     */
    public function setCustomer($customer)
    {

        if (is_null($customer)) {
            throw new \InvalidArgumentException('non-nullable customer cannot be null');
        }

        $this->container['customer'] = $customer;

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

        if (is_null($customer_payments)) {
            array_push($this->openAPINullablesSetToNull, 'customer_payments');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('customer_payments', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['customer_payments'] = $customer_payments;

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
            throw new \InvalidArgumentException('invalid length for $currency_code when calling AcceptDeliveryEvent., must be smaller than or equal to 3.');
        }
        if (!is_null($currency_code) && (mb_strlen($currency_code) < 3)) {
            throw new \InvalidArgumentException('invalid length for $currency_code when calling AcceptDeliveryEvent., must be bigger than or equal to 3.');
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
     * Gets customer_tip
     *
     * @return \OpenAPI\Client\Model\CustomerTip|null
     */
    public function getCustomerTip()
    {
        return $this->container['customer_tip'];
    }

    /**
     * Sets customer_tip
     *
     * @param \OpenAPI\Client\Model\CustomerTip|null $customer_tip customer_tip
     *
     * @return self
     */
    public function setCustomerTip($customer_tip)
    {

        if (is_null($customer_tip)) {
            array_push($this->openAPINullablesSetToNull, 'customer_tip');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('customer_tip', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['customer_tip'] = $customer_tip;

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

        if (is_null($order_sub_total)) {
            array_push($this->openAPINullablesSetToNull, 'order_sub_total');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_sub_total', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['order_sub_total'] = $order_sub_total;

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

        if (is_null($pick_up_location_id)) {
            array_push($this->openAPINullablesSetToNull, 'pick_up_location_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('pick_up_location_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['pick_up_location_id'] = $pick_up_location_id;

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

        if (is_null($contains_alcoholic_item)) {
            array_push($this->openAPINullablesSetToNull, 'contains_alcoholic_item');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('contains_alcoholic_item', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['contains_alcoholic_item'] = $contains_alcoholic_item;

        return $this;
    }

    /**
     * Gets pick_up_instructions
     *
     * @return string|null
     */
    public function getPickUpInstructions()
    {
        return $this->container['pick_up_instructions'];
    }

    /**
     * Sets pick_up_instructions
     *
     * @param string|null $pick_up_instructions Additional information to instruct couriers how to pickup the order.
     *
     * @return self
     */
    public function setPickUpInstructions($pick_up_instructions)
    {

        if (is_null($pick_up_instructions)) {
            array_push($this->openAPINullablesSetToNull, 'pick_up_instructions');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('pick_up_instructions', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['pick_up_instructions'] = $pick_up_instructions;

        return $this;
    }

    /**
     * Gets store
     *
     * @return \OpenAPI\Client\Model\Store|null
     */
    public function getStore()
    {
        return $this->container['store'];
    }

    /**
     * Sets store
     *
     * @param \OpenAPI\Client\Model\Store|null $store store
     *
     * @return self
     */
    public function setStore($store)
    {

        if (is_null($store)) {
            array_push($this->openAPINullablesSetToNull, 'store');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('store', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['store'] = $store;

        return $this;
    }

    /**
     * Gets order_items
     *
     * @return \OpenAPI\Client\Model\Item2[]|null
     */
    public function getOrderItems()
    {
        return $this->container['order_items'];
    }

    /**
     * Sets order_items
     *
     * @param \OpenAPI\Client\Model\Item2[]|null $order_items Items and modifiers in the order.
     *
     * @return self
     */
    public function setOrderItems($order_items)
    {

        if (is_null($order_items)) {
            array_push($this->openAPINullablesSetToNull, 'order_items');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_items', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['order_items'] = $order_items;

        return $this;
    }

    /**
     * Gets ofo_display_id
     *
     * @return string|null
     */
    public function getOfoDisplayId()
    {
        return $this->container['ofo_display_id'];
    }

    /**
     * Sets ofo_display_id
     *
     * @param string|null $ofo_display_id An identifier used to reference the order in the order source.
     *
     * @return self
     */
    public function setOfoDisplayId($ofo_display_id)
    {

        if (is_null($ofo_display_id)) {
            array_push($this->openAPINullablesSetToNull, 'ofo_display_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('ofo_display_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['ofo_display_id'] = $ofo_display_id;

        return $this;
    }

    /**
     * Gets ofo_slug
     *
     * @return string|null
     */
    public function getOfoSlug()
    {
        return $this->container['ofo_slug'];
    }

    /**
     * Sets ofo_slug
     *
     * @param string|null $ofo_slug Slug to identify the OFO that is the source of order.
     *
     * @return self
     */
    public function setOfoSlug($ofo_slug)
    {

        if (is_null($ofo_slug)) {
            array_push($this->openAPINullablesSetToNull, 'ofo_slug');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('ofo_slug', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['ofo_slug'] = $ofo_slug;

        return $this;
    }

    /**
     * Gets pick_up_info
     *
     * @return \OpenAPI\Client\Model\PickUpInfo|null
     */
    public function getPickUpInfo()
    {
        return $this->container['pick_up_info'];
    }

    /**
     * Sets pick_up_info
     *
     * @param \OpenAPI\Client\Model\PickUpInfo|null $pick_up_info pick_up_info
     *
     * @return self
     */
    public function setPickUpInfo($pick_up_info)
    {

        if (is_null($pick_up_info)) {
            array_push($this->openAPINullablesSetToNull, 'pick_up_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('pick_up_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['pick_up_info'] = $pick_up_info;

        return $this;
    }

    /**
     * Gets order_external_identifiers
     *
     * @return \OpenAPI\Client\Model\OrderExternalIdentifiers|null
     */
    public function getOrderExternalIdentifiers()
    {
        return $this->container['order_external_identifiers'];
    }

    /**
     * Sets order_external_identifiers
     *
     * @param \OpenAPI\Client\Model\OrderExternalIdentifiers|null $order_external_identifiers order_external_identifiers
     *
     * @return self
     */
    public function setOrderExternalIdentifiers($order_external_identifiers)
    {

        if (is_null($order_external_identifiers)) {
            throw new \InvalidArgumentException('non-nullable order_external_identifiers cannot be null');
        }

        $this->container['order_external_identifiers'] = $order_external_identifiers;

        return $this;
    }

    /**
     * Gets dropoff_instructions
     *
     * @return \OpenAPI\Client\Model\DropoffInstructions|null
     */
    public function getDropoffInstructions()
    {
        return $this->container['dropoff_instructions'];
    }

    /**
     * Sets dropoff_instructions
     *
     * @param \OpenAPI\Client\Model\DropoffInstructions|null $dropoff_instructions dropoff_instructions
     *
     * @return self
     */
    public function setDropoffInstructions($dropoff_instructions)
    {

        if (is_null($dropoff_instructions)) {
            array_push($this->openAPINullablesSetToNull, 'dropoff_instructions');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('dropoff_instructions', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['dropoff_instructions'] = $dropoff_instructions;

        return $this;
    }

    /**
     * Gets delivery_fee
     *
     * @return \OpenAPI\Client\Model\DeliveryFee|null
     */
    public function getDeliveryFee()
    {
        return $this->container['delivery_fee'];
    }

    /**
     * Sets delivery_fee
     *
     * @param \OpenAPI\Client\Model\DeliveryFee|null $delivery_fee delivery_fee
     *
     * @return self
     */
    public function setDeliveryFee($delivery_fee)
    {

        if (is_null($delivery_fee)) {
            array_push($this->openAPINullablesSetToNull, 'delivery_fee');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('delivery_fee', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }

        $this->container['delivery_fee'] = $delivery_fee;

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


