# OpenAPI\Client\PingEndpointsApi

All URIs are relative to https://}.

Method | HTTP request | Description
------------- | ------------- | -------------
[**ping()**](PingEndpointsApi.md#ping) | **GET** /v1/ping | Ping the system


## `ping()`

```php
ping($x_application_id, $x_store_id, $x_echo_error): \OpenAPI\Client\Model\PongObject
```

Ping the system

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\PingEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$x_echo_error = ping test error message; // string

try {
    $result = $apiInstance->ping($x_application_id, $x_store_id, $x_echo_error);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PingEndpointsApi->ping: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **x_echo_error** | **string**|  | [optional]

### Return type

[**\OpenAPI\Client\Model\PongObject**](../Model/PongObject.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
