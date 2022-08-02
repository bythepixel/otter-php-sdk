# OpenAPI\Client\OrdersEndpointsApi

All URIs are relative to https://}.

Method | HTTP request | Description
------------- | ------------- | -------------
[**createOrder()**](OrdersEndpointsApi.md#createOrder) | **POST** /v1/orders | Create order
[**getOrderFeed()**](OrdersEndpointsApi.md#getOrderFeed) | **GET** /v1/orders/feed | DEPRECATED - Fetch order feed for a store
[**getPosOrder()**](OrdersEndpointsApi.md#getPosOrder) | **GET** /v1/orders/{orderId}/{source}/pos | DEPRECATED - Fetch order with POS Info
[**posUpdateOrder()**](OrdersEndpointsApi.md#posUpdateOrder) | **POST** /v1/orders/status | DEPRECATED - Update order status
[**updateOrder()**](OrdersEndpointsApi.md#updateOrder) | **PUT** /v1/orders/{orderId} | Update order
[**updateOrderCustomerPayment()**](OrdersEndpointsApi.md#updateOrderCustomerPayment) | **PUT** /v1/orders/{orderId}/payments | Update order customer payment
[**updateOrderDeliveryInfo()**](OrdersEndpointsApi.md#updateOrderDeliveryInfo) | **PUT** /v1/orders/{orderId}/delivery | Update order delivery information
[**updateOrderStatus()**](OrdersEndpointsApi.md#updateOrderStatus) | **POST** /v1/orders/{orderId}/status | Update order status


## `createOrder()`

```php
createOrder($x_application_id, $x_store_id, $order): \OpenAPI\Client\Model\OrderReference
```

Create order

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$order = new \OpenAPI\Client\Model\Order(); // \OpenAPI\Client\Model\Order

try {
    $result = $apiInstance->createOrder($x_application_id, $x_store_id, $order);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->createOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **order** | [**\OpenAPI\Client\Model\Order**](../Model/Order.md)|  |

### Return type

[**\OpenAPI\Client\Model\OrderReference**](../Model/OrderReference.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getOrderFeed()`

```php
getOrderFeed($x_application_id, $x_store_id, $limit, $token, $min_date_time, $max_date_time): \OpenAPI\Client\Model\OrderFeed
```

DEPRECATED - Fetch order feed for a store

DEPRECATED: use /manager/order/v1/orders.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$limit = 5; // string
$token = CgwI09+kjQYQwOvF2AM=/(urlencoded:CgwI09%2BkjQYQwOvF2AM%3D); // string
$min_date_time = 2011-12-03T10:15:30-05:00; // string
$max_date_time = 2011-12-03T10:15:30-05:00; // string

try {
    $result = $apiInstance->getOrderFeed($x_application_id, $x_store_id, $limit, $token, $min_date_time, $max_date_time);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->getOrderFeed: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **limit** | **string**|  |
 **token** | **string**|  | [optional]
 **min_date_time** | **string**|  | [optional]
 **max_date_time** | **string**|  | [optional]

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

## `getPosOrder()`

```php
getPosOrder($x_application_id, $x_store_id, $order_id, $source): \OpenAPI\Client\Model\OrderWithPosInfo
```

DEPRECATED - Fetch order with POS Info

DEPRECATED: use /manager/order/v1/sources/{source}/orders/{orderId}.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$source = ubereats; // string

try {
    $result = $apiInstance->getPosOrder($x_application_id, $x_store_id, $order_id, $source);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->getPosOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **order_id** | **string**|  |
 **source** | **string**|  |

### Return type

[**\OpenAPI\Client\Model\OrderWithPosInfo**](../Model/OrderWithPosInfo.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `posUpdateOrder()`

```php
posUpdateOrder($x_application_id, $x_store_id, $pos_order_status_update_request, $x_event_id)
```

DEPRECATED - Update order status

DEPRECATED: use /manager/order/v1/sources/{source}/orders/{orderId}/{confirm|cancel}.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$pos_order_status_update_request = new \OpenAPI\Client\Model\POSOrderStatusUpdateRequest(); // \OpenAPI\Client\Model\POSOrderStatusUpdateRequest
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->posUpdateOrder($x_application_id, $x_store_id, $pos_order_status_update_request, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->posUpdateOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **pos_order_status_update_request** | [**\OpenAPI\Client\Model\POSOrderStatusUpdateRequest**](../Model/POSOrderStatusUpdateRequest.md)|  |
 **x_event_id** | **string**|  | [optional]

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

## `updateOrder()`

```php
updateOrder($x_application_id, $x_store_id, $order_id, $order): \OpenAPI\Client\Model\OrderReference
```

Update order

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order = new \OpenAPI\Client\Model\Order(); // \OpenAPI\Client\Model\Order

try {
    $result = $apiInstance->updateOrder($x_application_id, $x_store_id, $order_id, $order);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **order_id** | **string**|  |
 **order** | [**\OpenAPI\Client\Model\Order**](../Model/Order.md)|  |

### Return type

[**\OpenAPI\Client\Model\OrderReference**](../Model/OrderReference.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateOrderCustomerPayment()`

```php
updateOrderCustomerPayment($x_application_id, $x_store_id, $order_id, $order_customer_payment_update_request)
```

Update order customer payment

`RATE LIMIT: 8 per minute`  Notice that this operation do not completely replace the existent customer payment, instead, it overwrites the field if the latest update is a non-null value. If the update value is null, the existent value will continue to be used.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order_customer_payment_update_request = new \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest(); // \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest

try {
    $apiInstance->updateOrderCustomerPayment($x_application_id, $x_store_id, $order_id, $order_customer_payment_update_request);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrderCustomerPayment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **order_id** | **string**|  |
 **order_customer_payment_update_request** | [**\OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest**](../Model/OrderCustomerPaymentUpdateRequest.md)|  |

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

## `updateOrderDeliveryInfo()`

```php
updateOrderDeliveryInfo($x_application_id, $x_store_id, $order_id, $order_delivery_info_update_request)
```

Update order delivery information

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order_delivery_info_update_request = new \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest(); // \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest

try {
    $apiInstance->updateOrderDeliveryInfo($x_application_id, $x_store_id, $order_id, $order_delivery_info_update_request);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrderDeliveryInfo: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **order_id** | **string**|  |
 **order_delivery_info_update_request** | [**\OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest**](../Model/OrderDeliveryInfoUpdateRequest.md)|  |

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

## `updateOrderStatus()`

```php
updateOrderStatus($x_application_id, $x_store_id, $order_id, $order_status_update_request, $x_event_id)
```

Update order status

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\OrdersEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order_status_update_request = new \OpenAPI\Client\Model\OrderStatusUpdateRequest(); // \OpenAPI\Client\Model\OrderStatusUpdateRequest
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->updateOrderStatus($x_application_id, $x_store_id, $order_id, $order_status_update_request, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrderStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **order_id** | **string**|  |
 **order_status_update_request** | [**\OpenAPI\Client\Model\OrderStatusUpdateRequest**](../Model/OrderStatusUpdateRequest.md)|  |
 **x_event_id** | **string**|  | [optional]

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
