<?php
/**
 * HydraToken
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
 * HydraToken Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class HydraToken implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'HydraToken';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'access_token' => 'string',
        'expires_in' => 'int',
        'scope' => 'string',
        'token_type' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'access_token' => null,
        'expires_in' => 'int64',
        'scope' => null,
        'token_type' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'access_token' => false,
		'expires_in' => false,
		'scope' => false,
		'token_type' => false
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
        'access_token' => 'access_token',
        'expires_in' => 'expires_in',
        'scope' => 'scope',
        'token_type' => 'token_type'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'access_token' => 'setAccessToken',
        'expires_in' => 'setExpiresIn',
        'scope' => 'setScope',
        'token_type' => 'setTokenType'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'access_token' => 'getAccessToken',
        'expires_in' => 'getExpiresIn',
        'scope' => 'getScope',
        'token_type' => 'getTokenType'
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
        $this->setIfExists('access_token', $data ?? [], null);
        $this->setIfExists('expires_in', $data ?? [], null);
        $this->setIfExists('scope', $data ?? [], null);
        $this->setIfExists('token_type', $data ?? [], null);
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
     * Gets access_token
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->container['access_token'];
    }

    /**
     * Sets access_token
     *
     * @param string|null $access_token The auth token used when consuming the API endpoints.
     *
     * @return self
     */
    public function setAccessToken($access_token)
    {

        if (is_null($access_token)) {
            throw new \InvalidArgumentException('non-nullable access_token cannot be null');
        }

        $this->container['access_token'] = $access_token;

        return $this;
    }

    /**
     * Gets expires_in
     *
     * @return int|null
     */
    public function getExpiresIn()
    {
        return $this->container['expires_in'];
    }

    /**
     * Sets expires_in
     *
     * @param int|null $expires_in The token expiration time in seconds.
     *
     * @return self
     */
    public function setExpiresIn($expires_in)
    {

        if (is_null($expires_in)) {
            throw new \InvalidArgumentException('non-nullable expires_in cannot be null');
        }

        $this->container['expires_in'] = $expires_in;

        return $this;
    }

    /**
     * Gets scope
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->container['scope'];
    }

    /**
     * Sets scope
     *
     * @param string|null $scope The scopes available for the token.
     *
     * @return self
     */
    public function setScope($scope)
    {

        if (is_null($scope)) {
            throw new \InvalidArgumentException('non-nullable scope cannot be null');
        }

        $this->container['scope'] = $scope;

        return $this;
    }

    /**
     * Gets token_type
     *
     * @return string|null
     */
    public function getTokenType()
    {
        return $this->container['token_type'];
    }

    /**
     * Sets token_type
     *
     * @param string|null $token_type The token type is always \"bearer\".
     *
     * @return self
     */
    public function setTokenType($token_type)
    {

        if (is_null($token_type)) {
            throw new \InvalidArgumentException('non-nullable token_type cannot be null');
        }

        $this->container['token_type'] = $token_type;

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


