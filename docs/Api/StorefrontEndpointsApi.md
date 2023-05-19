# OpenAPI\Client\StorefrontEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**postPauseStoreEventResult()**](StorefrontEndpointsApi.md#postPauseStoreEventResult) | **POST** /v1/storefront/pause | Notify the result of a pause request event |
| [**postStoreAvailabilityChange()**](StorefrontEndpointsApi.md#postStoreAvailabilityChange) | **POST** /v1/storefront/availability | Notify about store availability change |
| [**postStoreHoursConfigurationChange()**](StorefrontEndpointsApi.md#postStoreHoursConfigurationChange) | **POST** /v1/storefront/hours | Notify about store hours configuration change |
| [**postUnpauseStoreEventResult()**](StorefrontEndpointsApi.md#postUnpauseStoreEventResult) | **POST** /v1/storefront/unpause | Notify the result of an unpause request event |


## `postPauseStoreEventResult()`

```php
postPauseStoreEventResult($x_store_id, $x_event_id, $pause_store_event_result)
```

Notify the result of a pause request event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\StorefrontEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$pause_store_event_result = new \OpenAPI\Client\Model\PauseStoreEventResult(); // \OpenAPI\Client\Model\PauseStoreEventResult

try {
    $apiInstance->postPauseStoreEventResult($x_store_id, $x_event_id, $pause_store_event_result);
} catch (Exception $e) {
    echo 'Exception when calling StorefrontEndpointsApi->postPauseStoreEventResult: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **pause_store_event_result** | [**\OpenAPI\Client\Model\PauseStoreEventResult**](../Model/PauseStoreEventResult.md)|  | |

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

## `postStoreAvailabilityChange()`

```php
postStoreAvailabilityChange($x_store_id, $store_availability_event_result, $x_event_id)
```

Notify about store availability change

`RATE LIMIT: 16 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\StorefrontEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$store_availability_event_result = new \OpenAPI\Client\Model\StoreAvailabilityEventResult(); // \OpenAPI\Client\Model\StoreAvailabilityEventResult
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->postStoreAvailabilityChange($x_store_id, $store_availability_event_result, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling StorefrontEndpointsApi->postStoreAvailabilityChange: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **store_availability_event_result** | [**\OpenAPI\Client\Model\StoreAvailabilityEventResult**](../Model/StoreAvailabilityEventResult.md)|  | |
| **x_event_id** | **string**|  | [optional] |

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

## `postStoreHoursConfigurationChange()`

```php
postStoreHoursConfigurationChange($x_store_id, $store_hours_configuration_event_result, $x_event_id)
```

Notify about store hours configuration change

`RATE LIMIT: 16 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\StorefrontEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$store_hours_configuration_event_result = new \OpenAPI\Client\Model\StoreHoursConfigurationEventResult(); // \OpenAPI\Client\Model\StoreHoursConfigurationEventResult
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->postStoreHoursConfigurationChange($x_store_id, $store_hours_configuration_event_result, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling StorefrontEndpointsApi->postStoreHoursConfigurationChange: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **store_hours_configuration_event_result** | [**\OpenAPI\Client\Model\StoreHoursConfigurationEventResult**](../Model/StoreHoursConfigurationEventResult.md)|  | |
| **x_event_id** | **string**|  | [optional] |

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

## `postUnpauseStoreEventResult()`

```php
postUnpauseStoreEventResult($x_store_id, $x_event_id, $unpause_store_event_result)
```

Notify the result of an unpause request event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\StorefrontEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$unpause_store_event_result = new \OpenAPI\Client\Model\UnpauseStoreEventResult(); // \OpenAPI\Client\Model\UnpauseStoreEventResult

try {
    $apiInstance->postUnpauseStoreEventResult($x_store_id, $x_event_id, $unpause_store_event_result);
} catch (Exception $e) {
    echo 'Exception when calling StorefrontEndpointsApi->postUnpauseStoreEventResult: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **unpause_store_event_result** | [**\OpenAPI\Client\Model\UnpauseStoreEventResult**](../Model/UnpauseStoreEventResult.md)|  | |

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
