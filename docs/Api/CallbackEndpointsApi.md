# OpenAPI\Client\CallbackEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**publishError()**](CallbackEndpointsApi.md#publishError) | **POST** /v1/callback/error | Publish callback error |


## `publishError()`

```php
publishError($x_store_id, $x_event_id, $event_callback_error)
```

Publish callback error

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CallbackEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$event_callback_error = new \OpenAPI\Client\Model\EventCallbackError(); // \OpenAPI\Client\Model\EventCallbackError

try {
    $apiInstance->publishError($x_store_id, $x_event_id, $event_callback_error);
} catch (Exception $e) {
    echo 'Exception when calling CallbackEndpointsApi->publishError: ', $e->getMessage(), PHP_EOL;
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
