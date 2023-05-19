# OpenAPI\Client\DeliveryEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**acceptDeliveryCallback()**](DeliveryEndpointsApi.md#acceptDeliveryCallback) | **POST** /v1/delivery/{deliveryReferenceId}/accept | Notify the result of an accept delivery event |
| [**cancelDeliveryCallback()**](DeliveryEndpointsApi.md#cancelDeliveryCallback) | **POST** /v1/delivery/{deliveryReferenceId}/cancel | Notify the result of a cancel delivery event |
| [**deliveryCallbackError()**](DeliveryEndpointsApi.md#deliveryCallbackError) | **POST** /v1/delivery/callback/error | Publish delivery callback error |
| [**requestDeliveryQuoteCallback()**](DeliveryEndpointsApi.md#requestDeliveryQuoteCallback) | **POST** /v1/delivery/{deliveryReferenceId}/quotes | Notify the result of a request delivery quote event |
| [**updateDeliveryRequestCallback()**](DeliveryEndpointsApi.md#updateDeliveryRequestCallback) | **POST** /v1/delivery/{deliveryReferenceId}/update | Notify the result of an update delivery request event |
| [**updateDeliveryStatus()**](DeliveryEndpointsApi.md#updateDeliveryStatus) | **PUT** /v1/delivery/{deliveryReferenceId}/status | Update delivery status |


## `acceptDeliveryCallback()`

```php
acceptDeliveryCallback($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request)
```

Notify the result of an accept delivery event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DeliveryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$delivery_reference_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$accept_delivery_callback_request = new \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest(); // \OpenAPI\Client\Model\AcceptDeliveryCallbackRequest

try {
    $apiInstance->acceptDeliveryCallback($x_store_id, $x_event_id, $delivery_reference_id, $accept_delivery_callback_request);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryEndpointsApi->acceptDeliveryCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **delivery_reference_id** | **string**|  | |
| **accept_delivery_callback_request** | [**\OpenAPI\Client\Model\AcceptDeliveryCallbackRequest**](../Model/AcceptDeliveryCallbackRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `cancelDeliveryCallback()`

```php
cancelDeliveryCallback($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request)
```

Notify the result of a cancel delivery event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DeliveryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$delivery_reference_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$cancel_delivery_callback_request = new \OpenAPI\Client\Model\CancelDeliveryCallbackRequest(); // \OpenAPI\Client\Model\CancelDeliveryCallbackRequest

try {
    $apiInstance->cancelDeliveryCallback($x_store_id, $x_event_id, $delivery_reference_id, $cancel_delivery_callback_request);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryEndpointsApi->cancelDeliveryCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **delivery_reference_id** | **string**|  | |
| **cancel_delivery_callback_request** | [**\OpenAPI\Client\Model\CancelDeliveryCallbackRequest**](../Model/CancelDeliveryCallbackRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deliveryCallbackError()`

```php
deliveryCallbackError($x_store_id, $x_event_id, $event_callback_error)
```

Publish delivery callback error

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DeliveryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$event_callback_error = new \OpenAPI\Client\Model\EventCallbackError(); // \OpenAPI\Client\Model\EventCallbackError

try {
    $apiInstance->deliveryCallbackError($x_store_id, $x_event_id, $event_callback_error);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryEndpointsApi->deliveryCallbackError: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **event_callback_error** | [**\OpenAPI\Client\Model\EventCallbackError**](../Model/EventCallbackError.md)|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `requestDeliveryQuoteCallback()`

```php
requestDeliveryQuoteCallback($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request)
```

Notify the result of a request delivery quote event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DeliveryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$delivery_reference_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$request_delivery_quote_callback_request = new \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest(); // \OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest

try {
    $apiInstance->requestDeliveryQuoteCallback($x_store_id, $x_event_id, $delivery_reference_id, $request_delivery_quote_callback_request);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryEndpointsApi->requestDeliveryQuoteCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **delivery_reference_id** | **string**|  | |
| **request_delivery_quote_callback_request** | [**\OpenAPI\Client\Model\RequestDeliveryQuoteCallbackRequest**](../Model/RequestDeliveryQuoteCallbackRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateDeliveryRequestCallback()`

```php
updateDeliveryRequestCallback($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request)
```

Notify the result of an update delivery request event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DeliveryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$delivery_reference_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$update_delivery_request_callback_request = new \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest(); // \OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest

try {
    $apiInstance->updateDeliveryRequestCallback($x_store_id, $x_event_id, $delivery_reference_id, $update_delivery_request_callback_request);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryEndpointsApi->updateDeliveryRequestCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **delivery_reference_id** | **string**|  | |
| **update_delivery_request_callback_request** | [**\OpenAPI\Client\Model\UpdateDeliveryRequestCallbackRequest**](../Model/UpdateDeliveryRequestCallbackRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateDeliveryStatus()`

```php
updateDeliveryStatus($delivery_reference_id, $delivery_status_update_request)
```

Update delivery status

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DeliveryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$delivery_reference_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$delivery_status_update_request = new \OpenAPI\Client\Model\DeliveryStatusUpdateRequest(); // \OpenAPI\Client\Model\DeliveryStatusUpdateRequest

try {
    $apiInstance->updateDeliveryStatus($delivery_reference_id, $delivery_status_update_request);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryEndpointsApi->updateDeliveryStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **delivery_reference_id** | **string**|  | |
| **delivery_status_update_request** | [**\OpenAPI\Client\Model\DeliveryStatusUpdateRequest**](../Model/DeliveryStatusUpdateRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
