<?php
/**
 * CustomerPayment
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
 * CustomerPayment Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class CustomerPayment implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'CustomerPayment';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'value' => 'float',
        'processing_status' => 'string',
        'payment_method' => 'string',
        'payment_authorizer' => 'string',
        'card_info' => '\OpenAPI\Client\Model\CardInfo'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'value' => null,
        'processing_status' => null,
        'payment_method' => null,
        'payment_authorizer' => null,
        'card_info' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'value' => false,
		'processing_status' => false,
		'payment_method' => false,
		'payment_authorizer' => true,
		'card_info' => true
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
        'value' => 'value',
        'processing_status' => 'processingStatus',
        'payment_method' => 'paymentMethod',
        'payment_authorizer' => 'paymentAuthorizer',
        'card_info' => 'cardInfo'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'value' => 'setValue',
        'processing_status' => 'setProcessingStatus',
        'payment_method' => 'setPaymentMethod',
        'payment_authorizer' => 'setPaymentAuthorizer',
        'card_info' => 'setCardInfo'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'value' => 'getValue',
        'processing_status' => 'getProcessingStatus',
        'payment_method' => 'getPaymentMethod',
        'payment_authorizer' => 'getPaymentAuthorizer',
        'card_info' => 'getCardInfo'
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

    public const PROCESSING_STATUS_COLLECTABLE = 'COLLECTABLE';
    public const PROCESSING_STATUS_PROCESSED = 'PROCESSED';
    public const PAYMENT_METHOD_CASH = 'CASH';
    public const PAYMENT_METHOD_CARD = 'CARD';
    public const PAYMENT_METHOD_UNKNOWN = 'UNKNOWN';
    public const PAYMENT_METHOD_OTHER = 'OTHER';
    public const PAYMENT_METHOD_CHEQUE = 'CHEQUE';
    public const PAYMENT_AUTHORIZER_UNKNOWN_TYPE = 'UNKNOWN_TYPE';
    public const PAYMENT_AUTHORIZER_OTHER_TYPE = 'OTHER_TYPE';
    public const PAYMENT_AUTHORIZER_MASTERCARD = 'MASTERCARD';
    public const PAYMENT_AUTHORIZER_MASTERCARD_MAESTRO = 'MASTERCARD_MAESTRO';
    public const PAYMENT_AUTHORIZER_MASTERCARD_DEBIT = 'MASTERCARD_DEBIT';
    public const PAYMENT_AUTHORIZER_VISA = 'VISA';
    public const PAYMENT_AUTHORIZER_VISA_DEBIT = 'VISA_DEBIT';
    public const PAYMENT_AUTHORIZER_AMEX = 'AMEX';
    public const PAYMENT_AUTHORIZER_VISA_ELECTORN = 'VISA_ELECTORN';
    public const PAYMENT_AUTHORIZER_DINERS = 'DINERS';
    public const PAYMENT_AUTHORIZER_ELO = 'ELO';
    public const PAYMENT_AUTHORIZER_ELO_DEBIT = 'ELO_DEBIT';
    public const PAYMENT_AUTHORIZER_HIPERCARD = 'HIPERCARD';
    public const PAYMENT_AUTHORIZER_BANRICOMPRAS = 'BANRICOMPRAS';
    public const PAYMENT_AUTHORIZER_BANRICOMPRAS_DEBIT = 'BANRICOMPRAS_DEBIT';
    public const PAYMENT_AUTHORIZER_NUGO = 'NUGO';
    public const PAYMENT_AUTHORIZER_GOODCARD = 'GOODCARD';
    public const PAYMENT_AUTHORIZER_VERDECARD = 'VERDECARD';
    public const PAYMENT_AUTHORIZER_CARNET = 'CARNET';
    public const PAYMENT_AUTHORIZER_CHEF_CARD = 'CHEF_CARD';
    public const PAYMENT_AUTHORIZER_GER_CC_CREDITO = 'GER_CC_CREDITO';
    public const PAYMENT_AUTHORIZER_TERMINAL_BANCARIA = 'TERMINAL_BANCARIA';
    public const PAYMENT_AUTHORIZER_DEBIT = 'DEBIT';
    public const PAYMENT_AUTHORIZER_QR_CODE = 'QR_CODE';
    public const PAYMENT_AUTHORIZER_RAPPI_PAY = 'RAPPI_PAY';
    public const PAYMENT_AUTHORIZER_DISCOVER = 'DISCOVER';
    public const PAYMENT_AUTHORIZER_VALE_GREEN_CARD_PAPEL = 'VALE_GREEN_CARD_PAPEL';
    public const PAYMENT_AUTHORIZER_VALE_GREEN_CARD_CARD = 'VALE_GREEN_CARD_CARD';
    public const PAYMENT_AUTHORIZER_VALE_REFEISUL = 'VALE_REFEISUL';
    public const PAYMENT_AUTHORIZER_VALE_VEROCARD = 'VALE_VEROCARD';
    public const PAYMENT_AUTHORIZER_VALE_VR_SMART = 'VALE_VR_SMART';
    public const PAYMENT_AUTHORIZER_VALE_SODEXO = 'VALE_SODEXO';
    public const PAYMENT_AUTHORIZER_VALE_TICKET_RESTAURANTE = 'VALE_TICKET_RESTAURANTE';
    public const PAYMENT_AUTHORIZER_VALE_ALELO = 'VALE_ALELO';
    public const PAYMENT_AUTHORIZER_VALE_BEN_VIS = 'VALE_BEN_VIS';
    public const PAYMENT_AUTHORIZER_VALE_COOPER_CARD = 'VALE_COOPER_CARD';
    public const PAYMENT_AUTHORIZER_NUTRICARD_REFEICAO_E_ALIMENTACAO = 'NUTRICARD_REFEICAO_E_ALIMENTACAO';
    public const PAYMENT_AUTHORIZER_APPLE_PAY_MASTERCARD = 'APPLE_PAY_MASTERCARD';
    public const PAYMENT_AUTHORIZER_APPLE_PAY_VISA = 'APPLE_PAY_VISA';
    public const PAYMENT_AUTHORIZER_APPLE_PAY_AMEX = 'APPLE_PAY_AMEX';
    public const PAYMENT_AUTHORIZER_GOOGLE_PAY_ELO = 'GOOGLE_PAY_ELO';
    public const PAYMENT_AUTHORIZER_GOOGLE_PAY_MASTERCARD = 'GOOGLE_PAY_MASTERCARD';
    public const PAYMENT_AUTHORIZER_GOOGLE_PAY_VISA = 'GOOGLE_PAY_VISA';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY = 'MOVILE_PAY';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY_AMEX = 'MOVILE_PAY_AMEX';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY_DINERS = 'MOVILE_PAY_DINERS';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY_ELO = 'MOVILE_PAY_ELO';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY_HIPERCARD = 'MOVILE_PAY_HIPERCARD';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY_MASTERCARD = 'MOVILE_PAY_MASTERCARD';
    public const PAYMENT_AUTHORIZER_MOVILE_PAY_VISA = 'MOVILE_PAY_VISA';
    public const PAYMENT_AUTHORIZER_IFOOD_CORP = 'IFOOD_CORP';
    public const PAYMENT_AUTHORIZER_LOOP_CLUB = 'LOOP_CLUB';
    public const PAYMENT_AUTHORIZER_PAYPAL = 'PAYPAL';
    public const PAYMENT_AUTHORIZER_PSE = 'PSE';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getProcessingStatusAllowableValues()
    {
        return [
            self::PROCESSING_STATUS_COLLECTABLE,
            self::PROCESSING_STATUS_PROCESSED,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getPaymentMethodAllowableValues()
    {
        return [
            self::PAYMENT_METHOD_CASH,
            self::PAYMENT_METHOD_CARD,
            self::PAYMENT_METHOD_UNKNOWN,
            self::PAYMENT_METHOD_OTHER,
            self::PAYMENT_METHOD_CHEQUE,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getPaymentAuthorizerAllowableValues()
    {
        return [
            self::PAYMENT_AUTHORIZER_UNKNOWN_TYPE,
            self::PAYMENT_AUTHORIZER_OTHER_TYPE,
            self::PAYMENT_AUTHORIZER_MASTERCARD,
            self::PAYMENT_AUTHORIZER_MASTERCARD_MAESTRO,
            self::PAYMENT_AUTHORIZER_MASTERCARD_DEBIT,
            self::PAYMENT_AUTHORIZER_VISA,
            self::PAYMENT_AUTHORIZER_VISA_DEBIT,
            self::PAYMENT_AUTHORIZER_AMEX,
            self::PAYMENT_AUTHORIZER_VISA_ELECTORN,
            self::PAYMENT_AUTHORIZER_DINERS,
            self::PAYMENT_AUTHORIZER_ELO,
            self::PAYMENT_AUTHORIZER_ELO_DEBIT,
            self::PAYMENT_AUTHORIZER_HIPERCARD,
            self::PAYMENT_AUTHORIZER_BANRICOMPRAS,
            self::PAYMENT_AUTHORIZER_BANRICOMPRAS_DEBIT,
            self::PAYMENT_AUTHORIZER_NUGO,
            self::PAYMENT_AUTHORIZER_GOODCARD,
            self::PAYMENT_AUTHORIZER_VERDECARD,
            self::PAYMENT_AUTHORIZER_CARNET,
            self::PAYMENT_AUTHORIZER_CHEF_CARD,
            self::PAYMENT_AUTHORIZER_GER_CC_CREDITO,
            self::PAYMENT_AUTHORIZER_TERMINAL_BANCARIA,
            self::PAYMENT_AUTHORIZER_DEBIT,
            self::PAYMENT_AUTHORIZER_QR_CODE,
            self::PAYMENT_AUTHORIZER_RAPPI_PAY,
            self::PAYMENT_AUTHORIZER_DISCOVER,
            self::PAYMENT_AUTHORIZER_VALE_GREEN_CARD_PAPEL,
            self::PAYMENT_AUTHORIZER_VALE_GREEN_CARD_CARD,
            self::PAYMENT_AUTHORIZER_VALE_REFEISUL,
            self::PAYMENT_AUTHORIZER_VALE_VEROCARD,
            self::PAYMENT_AUTHORIZER_VALE_VR_SMART,
            self::PAYMENT_AUTHORIZER_VALE_SODEXO,
            self::PAYMENT_AUTHORIZER_VALE_TICKET_RESTAURANTE,
            self::PAYMENT_AUTHORIZER_VALE_ALELO,
            self::PAYMENT_AUTHORIZER_VALE_BEN_VIS,
            self::PAYMENT_AUTHORIZER_VALE_COOPER_CARD,
            self::PAYMENT_AUTHORIZER_NUTRICARD_REFEICAO_E_ALIMENTACAO,
            self::PAYMENT_AUTHORIZER_APPLE_PAY_MASTERCARD,
            self::PAYMENT_AUTHORIZER_APPLE_PAY_VISA,
            self::PAYMENT_AUTHORIZER_APPLE_PAY_AMEX,
            self::PAYMENT_AUTHORIZER_GOOGLE_PAY_ELO,
            self::PAYMENT_AUTHORIZER_GOOGLE_PAY_MASTERCARD,
            self::PAYMENT_AUTHORIZER_GOOGLE_PAY_VISA,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY_AMEX,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY_DINERS,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY_ELO,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY_HIPERCARD,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY_MASTERCARD,
            self::PAYMENT_AUTHORIZER_MOVILE_PAY_VISA,
            self::PAYMENT_AUTHORIZER_IFOOD_CORP,
            self::PAYMENT_AUTHORIZER_LOOP_CLUB,
            self::PAYMENT_AUTHORIZER_PAYPAL,
            self::PAYMENT_AUTHORIZER_PSE,
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
        $this->setIfExists('value', $data ?? [], null);
        $this->setIfExists('processing_status', $data ?? [], null);
        $this->setIfExists('payment_method', $data ?? [], null);
        $this->setIfExists('payment_authorizer', $data ?? [], null);
        $this->setIfExists('card_info', $data ?? [], null);
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

        if ($this->container['value'] === null) {
            $invalidProperties[] = "'value' can't be null";
        }
        if ($this->container['processing_status'] === null) {
            $invalidProperties[] = "'processing_status' can't be null";
        }
        $allowedValues = $this->getProcessingStatusAllowableValues();
        if (!is_null($this->container['processing_status']) && !in_array($this->container['processing_status'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'processing_status', must be one of '%s'",
                $this->container['processing_status'],
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['payment_method'] === null) {
            $invalidProperties[] = "'payment_method' can't be null";
        }
        $allowedValues = $this->getPaymentMethodAllowableValues();
        if (!is_null($this->container['payment_method']) && !in_array($this->container['payment_method'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'payment_method', must be one of '%s'",
                $this->container['payment_method'],
                implode("', '", $allowedValues)
            );
        }

        $allowedValues = $this->getPaymentAuthorizerAllowableValues();
        if (!is_null($this->container['payment_authorizer']) && !in_array($this->container['payment_authorizer'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'payment_authorizer', must be one of '%s'",
                $this->container['payment_authorizer'],
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
     * Gets value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->container['value'];
    }

    /**
     * Sets value
     *
     * @param float $value The portion of the overall amount that needs to be paid.
     *
     * @return self
     */
    public function setValue($value)
    {
        if (is_null($value)) {
            throw new \InvalidArgumentException('non-nullable value cannot be null');
        }
        $this->container['value'] = $value;

        return $this;
    }

    /**
     * Gets processing_status
     *
     * @return string
     */
    public function getProcessingStatus()
    {
        return $this->container['processing_status'];
    }

    /**
     * Sets processing_status
     *
     * @param string $processing_status The processing status of the payment.
     *
     * @return self
     */
    public function setProcessingStatus($processing_status)
    {
        if (is_null($processing_status)) {
            throw new \InvalidArgumentException('non-nullable processing_status cannot be null');
        }
        $allowedValues = $this->getProcessingStatusAllowableValues();
        if (!in_array($processing_status, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'processing_status', must be one of '%s'",
                    $processing_status,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['processing_status'] = $processing_status;

        return $this;
    }

    /**
     * Gets payment_method
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->container['payment_method'];
    }

    /**
     * Sets payment_method
     *
     * @param string $payment_method The method of payment.
     *
     * @return self
     */
    public function setPaymentMethod($payment_method)
    {
        if (is_null($payment_method)) {
            throw new \InvalidArgumentException('non-nullable payment_method cannot be null');
        }
        $allowedValues = $this->getPaymentMethodAllowableValues();
        if (!in_array($payment_method, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'payment_method', must be one of '%s'",
                    $payment_method,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['payment_method'] = $payment_method;

        return $this;
    }

    /**
     * Gets payment_authorizer
     *
     * @return string|null
     * @deprecated
     */
    public function getPaymentAuthorizer()
    {
        return $this->container['payment_authorizer'];
    }

    /**
     * Sets payment_authorizer
     *
     * @param string|null $payment_authorizer A payment system type responsible for a card transaction (containing information for payment network and payment type).
     *
     * @return self
     * @deprecated
     */
    public function setPaymentAuthorizer($payment_authorizer)
    {
        if (is_null($payment_authorizer)) {
            array_push($this->openAPINullablesSetToNull, 'payment_authorizer');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('payment_authorizer', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $allowedValues = $this->getPaymentAuthorizerAllowableValues();
        if (!is_null($payment_authorizer) && !in_array($payment_authorizer, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'payment_authorizer', must be one of '%s'",
                    $payment_authorizer,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['payment_authorizer'] = $payment_authorizer;

        return $this;
    }

    /**
     * Gets card_info
     *
     * @return \OpenAPI\Client\Model\CardInfo|null
     */
    public function getCardInfo()
    {
        return $this->container['card_info'];
    }

    /**
     * Sets card_info
     *
     * @param \OpenAPI\Client\Model\CardInfo|null $card_info card_info
     *
     * @return self
     */
    public function setCardInfo($card_info)
    {
        if (is_null($card_info)) {
            array_push($this->openAPINullablesSetToNull, 'card_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('card_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['card_info'] = $card_info;

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


