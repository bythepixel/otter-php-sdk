# OpenAPI\Client\InventoryEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createShipment()**](InventoryEndpointsApi.md#createShipment) | **POST** /inventories/v1/shipments | Create shipment |
| [**listInventoryShipments()**](InventoryEndpointsApi.md#listInventoryShipments) | **GET** /inventories/v1/shipments | List shipments |
| [**listInventorySummaries()**](InventoryEndpointsApi.md#listInventorySummaries) | **GET** /inventories/v1/summaries | List inventory summaries |


## `createShipment()`

```php
createShipment($x_store_id, $create_shipment_request): \OpenAPI\Client\Model\CreateShipmentResponse
```

Create shipment

Create a new shipment

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\InventoryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$create_shipment_request = new \OpenAPI\Client\Model\CreateShipmentRequest(); // \OpenAPI\Client\Model\CreateShipmentRequest

try {
    $result = $apiInstance->createShipment($x_store_id, $create_shipment_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InventoryEndpointsApi->createShipment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **create_shipment_request** | [**\OpenAPI\Client\Model\CreateShipmentRequest**](../Model/CreateShipmentRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\CreateShipmentResponse**](../Model/CreateShipmentResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listInventoryShipments()`

```php
listInventoryShipments($x_store_id, $limit, $token): \OpenAPI\Client\Model\ListShipmentsResponse
```

List shipments

List shipments by the requested parameters.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\InventoryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$limit = 5; // string
$token = CgwI09+kjQYQwOvF2AM=/(urlencoded:CgwI09%2BkjQYQwOvF2AM%3D); // string

try {
    $result = $apiInstance->listInventoryShipments($x_store_id, $limit, $token);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InventoryEndpointsApi->listInventoryShipments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **limit** | **string**|  | [optional] |
| **token** | **string**|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\ListShipmentsResponse**](../Model/ListShipmentsResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listInventorySummaries()`

```php
listInventorySummaries($x_store_id, $limit, $token): \OpenAPI\Client\Model\InventorySummariesResponse
```

List inventory summaries

List inventory summaries by the requested parameters.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\InventoryEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$limit = 5; // string
$token = CgwI09+kjQYQwOvF2AM=/(urlencoded:CgwI09%2BkjQYQwOvF2AM%3D); // string

try {
    $result = $apiInstance->listInventorySummaries($x_store_id, $limit, $token);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InventoryEndpointsApi->listInventorySummaries: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **limit** | **string**|  | [optional] |
| **token** | **string**|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\InventorySummariesResponse**](../Model/InventorySummariesResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
