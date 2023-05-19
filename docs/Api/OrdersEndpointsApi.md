# OpenAPI\Client\OrdersEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createOrder()**](OrdersEndpointsApi.md#createOrder) | **POST** /v1/orders | Create order |
| [**updateOrder()**](OrdersEndpointsApi.md#updateOrder) | **PUT** /v1/orders/{orderId} | Update order |
| [**updateOrderCustomerPayment()**](OrdersEndpointsApi.md#updateOrderCustomerPayment) | **PUT** /v1/orders/{orderId}/payments | Update order customer payment |
| [**updateOrderDeliveryInfo()**](OrdersEndpointsApi.md#updateOrderDeliveryInfo) | **PUT** /v1/orders/{orderId}/delivery | Update order delivery information |
| [**updateOrderStatus()**](OrdersEndpointsApi.md#updateOrderStatus) | **POST** /v1/orders/{orderId}/status | Update order status |
| [**uploadPastOrders()**](OrdersEndpointsApi.md#uploadPastOrders) | **POST** /v1/orders/past-orders | Upload past orders |


## `createOrder()`

```php
createOrder($x_store_id, $order): \OpenAPI\Client\Model\OrderReference
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
$x_store_id = 'x_store_id_example'; // string
$order = new \OpenAPI\Client\Model\Order(); // \OpenAPI\Client\Model\Order

try {
    $result = $apiInstance->createOrder($x_store_id, $order);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->createOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **order** | [**\OpenAPI\Client\Model\Order**](../Model/Order.md)|  | |

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

## `updateOrder()`

```php
updateOrder($x_store_id, $order_id, $order): \OpenAPI\Client\Model\OrderReference
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
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order = new \OpenAPI\Client\Model\Order(); // \OpenAPI\Client\Model\Order

try {
    $result = $apiInstance->updateOrder($x_store_id, $order_id, $order);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrder: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **order_id** | **string**|  | |
| **order** | [**\OpenAPI\Client\Model\Order**](../Model/Order.md)|  | |

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
updateOrderCustomerPayment($x_store_id, $order_id, $order_customer_payment_update_request)
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
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order_customer_payment_update_request = new \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest(); // \OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest

try {
    $apiInstance->updateOrderCustomerPayment($x_store_id, $order_id, $order_customer_payment_update_request);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrderCustomerPayment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **order_id** | **string**|  | |
| **order_customer_payment_update_request** | [**\OpenAPI\Client\Model\OrderCustomerPaymentUpdateRequest**](../Model/OrderCustomerPaymentUpdateRequest.md)|  | |

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
updateOrderDeliveryInfo($x_store_id, $order_id, $order_delivery_info_update_request)
```

Update order delivery information

`RATE LIMIT: 8 per minute`

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
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order_delivery_info_update_request = new \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest(); // \OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest

try {
    $apiInstance->updateOrderDeliveryInfo($x_store_id, $order_id, $order_delivery_info_update_request);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrderDeliveryInfo: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **order_id** | **string**|  | |
| **order_delivery_info_update_request** | [**\OpenAPI\Client\Model\OrderDeliveryInfoUpdateRequest**](../Model/OrderDeliveryInfoUpdateRequest.md)|  | |

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
updateOrderStatus($x_store_id, $order_id, $order_status_update_request, $x_event_id)
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
$x_store_id = 'x_store_id_example'; // string
$order_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string
$order_status_update_request = new \OpenAPI\Client\Model\OrderStatusUpdateRequest(); // \OpenAPI\Client\Model\OrderStatusUpdateRequest
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->updateOrderStatus($x_store_id, $order_id, $order_status_update_request, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->updateOrderStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **order_id** | **string**|  | |
| **order_status_update_request** | [**\OpenAPI\Client\Model\OrderStatusUpdateRequest**](../Model/OrderStatusUpdateRequest.md)|  | |
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

## `uploadPastOrders()`

```php
uploadPastOrders($x_store_id, $upload_past_orders_request): \OpenAPI\Client\Model\UploadPastOrdersResponse
```

Upload past orders

`RATE LIMIT: 32 per minute`; orders must have a status of FULFILLED, REJECTED, or CANCELED

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
$x_store_id = 'x_store_id_example'; // string
$upload_past_orders_request = new \OpenAPI\Client\Model\UploadPastOrdersRequest(); // \OpenAPI\Client\Model\UploadPastOrdersRequest

try {
    $result = $apiInstance->uploadPastOrders($x_store_id, $upload_past_orders_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersEndpointsApi->uploadPastOrders: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **upload_past_orders_request** | [**\OpenAPI\Client\Model\UploadPastOrdersRequest**](../Model/UploadPastOrdersRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\UploadPastOrdersResponse**](../Model/UploadPastOrdersResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
