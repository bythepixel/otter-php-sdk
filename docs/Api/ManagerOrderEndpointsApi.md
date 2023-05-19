# OpenAPI\Client\ManagerOrderEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getManagerOrder()**](ManagerOrderEndpointsApi.md#getManagerOrder) | **GET** /manager/order/v1/sources/{source}/orders/{orderId} | Fetch order with Manager Info |
| [**managerGetOrderFeed()**](ManagerOrderEndpointsApi.md#managerGetOrderFeed) | **GET** /manager/order/v1/orders | Fetch order feed for a store |
| [**markAsFulfilled()**](ManagerOrderEndpointsApi.md#markAsFulfilled) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/fulfill | Mark an order as fulfilled |
| [**markAsReadyToPickup()**](ManagerOrderEndpointsApi.md#markAsReadyToPickup) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/ready-to-pickup | Mark an order as ready to pickup |
| [**orderCreated()**](ManagerOrderEndpointsApi.md#orderCreated) | **POST** /manager/order/v1/orders/order-created | Notify the result of a Create Order event |
| [**requestOrderCancelation()**](ManagerOrderEndpointsApi.md#requestOrderCancelation) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/cancel | Request order cancelation |
| [**requestOrderConfirmation()**](ManagerOrderEndpointsApi.md#requestOrderConfirmation) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/confirm | Request order confirmation |
| [**requestOrderReInjection()**](ManagerOrderEndpointsApi.md#requestOrderReInjection) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/re-inject | Request order re-injection |


## `getManagerOrder()`

```php
getManagerOrder($x_store_id, $order_id, $source): \OpenAPI\Client\Model\OrderWithManagerInfo
```

Fetch order with Manager Info

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$source = ubereats; // string

try {
    $result = $apiInstance->getManagerOrder($x_store_id, $order_id, $source);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->getManagerOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **order_id** | **string**|  | |
| **source** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\OrderWithManagerInfo**](../Model/OrderWithManagerInfo.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `managerGetOrderFeed()`

```php
managerGetOrderFeed($x_store_id, $limit, $token, $min_date_time, $max_date_time): \OpenAPI\Client\Model\OrderFeed
```

Fetch order feed for a store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$limit = 5; // string
$token = CgwI09+kjQYQwOvF2AM=/(urlencoded:CgwI09%2BkjQYQwOvF2AM%3D); // string
$min_date_time = 2011-12-03T10:15:30-05:00; // string
$max_date_time = 2011-12-03T10:15:30-05:00; // string

try {
    $result = $apiInstance->managerGetOrderFeed($x_store_id, $limit, $token, $min_date_time, $max_date_time);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->managerGetOrderFeed: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **limit** | **string**|  | |
| **token** | **string**|  | [optional] |
| **min_date_time** | **string**|  | [optional] |
| **max_date_time** | **string**|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\OrderFeed**](../Model/OrderFeed.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `markAsFulfilled()`

```php
markAsFulfilled($x_store_id, $source, $order_id)
```

Mark an order as fulfilled

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$source = ubereats; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string

try {
    $apiInstance->markAsFulfilled($x_store_id, $source, $order_id);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->markAsFulfilled: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **source** | **string**|  | |
| **order_id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `markAsReadyToPickup()`

```php
markAsReadyToPickup($x_store_id, $source, $order_id)
```

Mark an order as ready to pickup

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$source = ubereats; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string

try {
    $apiInstance->markAsReadyToPickup($x_store_id, $source, $order_id);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->markAsReadyToPickup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **source** | **string**|  | |
| **order_id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `orderCreated()`

```php
orderCreated($x_store_id, $x_event_id)
```

Notify the result of a Create Order event

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->orderCreated($x_store_id, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->orderCreated: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `requestOrderCancelation()`

```php
requestOrderCancelation($x_store_id, $source, $order_id, $manager_cancel_order_request)
```

Request order cancelation

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$source = ubereats; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$manager_cancel_order_request = new \OpenAPI\Client\Model\ManagerCancelOrderRequest(); // \OpenAPI\Client\Model\ManagerCancelOrderRequest

try {
    $apiInstance->requestOrderCancelation($x_store_id, $source, $order_id, $manager_cancel_order_request);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->requestOrderCancelation: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **source** | **string**|  | |
| **order_id** | **string**|  | |
| **manager_cancel_order_request** | [**\OpenAPI\Client\Model\ManagerCancelOrderRequest**](../Model/ManagerCancelOrderRequest.md)|  | |

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

## `requestOrderConfirmation()`

```php
requestOrderConfirmation($x_store_id, $source, $order_id, $manager_confirm_order_request)
```

Request order confirmation

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$source = ubereats; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$manager_confirm_order_request = new \OpenAPI\Client\Model\ManagerConfirmOrderRequest(); // \OpenAPI\Client\Model\ManagerConfirmOrderRequest

try {
    $apiInstance->requestOrderConfirmation($x_store_id, $source, $order_id, $manager_confirm_order_request);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->requestOrderConfirmation: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **source** | **string**|  | |
| **order_id** | **string**|  | |
| **manager_confirm_order_request** | [**\OpenAPI\Client\Model\ManagerConfirmOrderRequest**](../Model/ManagerConfirmOrderRequest.md)|  | [optional] |

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

## `requestOrderReInjection()`

```php
requestOrderReInjection($x_store_id, $source, $order_id)
```

Request order re-injection

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerOrderEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$source = ubereats; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string

try {
    $apiInstance->requestOrderReInjection($x_store_id, $source, $order_id);
} catch (Exception $e) {
    echo 'Exception when calling ManagerOrderEndpointsApi->requestOrderReInjection: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **source** | **string**|  | |
| **order_id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
