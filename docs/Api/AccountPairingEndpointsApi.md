# OpenAPI\Client\AccountPairingEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**updateStoreStatusEndpoint()**](AccountPairingEndpointsApi.md#updateStoreStatusEndpoint) | **PUT** /v1/stores/status | Update Store Status |
| [**upsertStorelinkEventResultEndpoint()**](AccountPairingEndpointsApi.md#upsertStorelinkEventResultEndpoint) | **POST** /v1/stores | Complete Store Onboarding |


## `updateStoreStatusEndpoint()`

```php
updateStoreStatusEndpoint($x_store_id, $update_storelink_status_request)
```

Update Store Status

`RATE LIMIT: 2 per minute`  The partner application should call this endpoint when needing to change the status of a store that already completed the onboarding process.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AccountPairingEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$update_storelink_status_request = new \OpenAPI\Client\Model\UpdateStorelinkStatusRequest(); // \OpenAPI\Client\Model\UpdateStorelinkStatusRequest

try {
    $apiInstance->updateStoreStatusEndpoint($x_store_id, $update_storelink_status_request);
} catch (Exception $e) {
    echo 'Exception when calling AccountPairingEndpointsApi->updateStoreStatusEndpoint: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **update_storelink_status_request** | [**\OpenAPI\Client\Model\UpdateStorelinkStatusRequest**](../Model/UpdateStorelinkStatusRequest.md)|  | |

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

## `upsertStorelinkEventResultEndpoint()`

```php
upsertStorelinkEventResultEndpoint($x_application_id, $x_event_id, $upsert_storelink_event_result_request)
```

Complete Store Onboarding

`RATE LIMIT: 2 per minute`  The asynchronous callback of the Upsert Store Webhook. The partner application will use this endpoint  to inform if the store data and credentials provided through the `Upsert Store Webhook` were enough to  create/update and validate the store. If informing success, the `Store ID` must be provided to  complete the store onboarding process. If informing failure, use the `Error Message` field to provide  details about the problem.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AccountPairingEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$upsert_storelink_event_result_request = new \OpenAPI\Client\Model\UpsertStorelinkEventResultRequest(); // \OpenAPI\Client\Model\UpsertStorelinkEventResultRequest

try {
    $apiInstance->upsertStorelinkEventResultEndpoint($x_application_id, $x_event_id, $upsert_storelink_event_result_request);
} catch (Exception $e) {
    echo 'Exception when calling AccountPairingEndpointsApi->upsertStorelinkEventResultEndpoint: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_application_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **upsert_storelink_event_result_request** | [**\OpenAPI\Client\Model\UpsertStorelinkEventResultRequest**](../Model/UpsertStorelinkEventResultRequest.md)|  | |

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
