# OpenAPI\Client\ManagerMenuEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAsyncJobStatus()**](ManagerMenuEndpointsApi.md#getAsyncJobStatus) | **GET** /v1/menus/jobs/{jobId} | Get the async menu job status |
| [**getMenu()**](ManagerMenuEndpointsApi.md#getMenu) | **GET** /v1/menus | Get the menus for a store |
| [**managerGetMenuPublishTargets()**](ManagerMenuEndpointsApi.md#managerGetMenuPublishTargets) | **GET** /manager/menu/v1/menus/publish-targets | Get the publish-targets for a store |
| [**managerPublishMenu()**](ManagerMenuEndpointsApi.md#managerPublishMenu) | **POST** /manager/menu/v1/menus/publish | Publish menus to targets for a store |
| [**managerSuspendMenuEntities()**](ManagerMenuEndpointsApi.md#managerSuspendMenuEntities) | **POST** /manager/menu/v1/menus/entities/availability/suspend | Suspend menu entities targets for a store |
| [**managerUnsuspendMenuEntities()**](ManagerMenuEndpointsApi.md#managerUnsuspendMenuEntities) | **POST** /manager/menu/v1/menus/entities/availability/unsuspend | Unsuspend menu entities targets for a store |


## `getAsyncJobStatus()`

```php
getAsyncJobStatus($x_store_id, $job_id): \OpenAPI\Client\Model\MenuAsynchronousJob
```

Get the async menu job status

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerMenuEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$job_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string

try {
    $result = $apiInstance->getAsyncJobStatus($x_store_id, $job_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerMenuEndpointsApi->getAsyncJobStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **job_id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\MenuAsynchronousJob**](../Model/MenuAsynchronousJob.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMenu()`

```php
getMenu($x_store_id): \OpenAPI\Client\Model\Menus
```

Get the menus for a store

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerMenuEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string

try {
    $result = $apiInstance->getMenu($x_store_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerMenuEndpointsApi->getMenu: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\Menus**](../Model/Menus.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `managerGetMenuPublishTargets()`

```php
managerGetMenuPublishTargets($x_store_id): \OpenAPI\Client\Model\MenuPublishTargets
```

Get the publish-targets for a store

`RATE LIMIT: 2 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerMenuEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string

try {
    $result = $apiInstance->managerGetMenuPublishTargets($x_store_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerMenuEndpointsApi->managerGetMenuPublishTargets: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\MenuPublishTargets**](../Model/MenuPublishTargets.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `managerPublishMenu()`

```php
managerPublishMenu($x_store_id, $menu_publish_request): \OpenAPI\Client\Model\MenuPublishResponse
```

Publish menus to targets for a store

`RATE LIMIT: 2 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerMenuEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$menu_publish_request = new \OpenAPI\Client\Model\MenuPublishRequest(); // \OpenAPI\Client\Model\MenuPublishRequest

try {
    $result = $apiInstance->managerPublishMenu($x_store_id, $menu_publish_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerMenuEndpointsApi->managerPublishMenu: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **menu_publish_request** | [**\OpenAPI\Client\Model\MenuPublishRequest**](../Model/MenuPublishRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\MenuPublishResponse**](../Model/MenuPublishResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `managerSuspendMenuEntities()`

```php
managerSuspendMenuEntities($x_store_id, $suspend_items_request): \OpenAPI\Client\Model\MenuAsynchronousJob
```

Suspend menu entities targets for a store

`RATE LIMIT: 2 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerMenuEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$suspend_items_request = new \OpenAPI\Client\Model\SuspendItemsRequest(); // \OpenAPI\Client\Model\SuspendItemsRequest

try {
    $result = $apiInstance->managerSuspendMenuEntities($x_store_id, $suspend_items_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerMenuEndpointsApi->managerSuspendMenuEntities: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **suspend_items_request** | [**\OpenAPI\Client\Model\SuspendItemsRequest**](../Model/SuspendItemsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\MenuAsynchronousJob**](../Model/MenuAsynchronousJob.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `managerUnsuspendMenuEntities()`

```php
managerUnsuspendMenuEntities($x_store_id, $unsuspend_items_request): \OpenAPI\Client\Model\MenuAsynchronousJob
```

Unsuspend menu entities targets for a store

`RATE LIMIT: 2 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ManagerMenuEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$unsuspend_items_request = new \OpenAPI\Client\Model\UnsuspendItemsRequest(); // \OpenAPI\Client\Model\UnsuspendItemsRequest

try {
    $result = $apiInstance->managerUnsuspendMenuEntities($x_store_id, $unsuspend_items_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ManagerMenuEndpointsApi->managerUnsuspendMenuEntities: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **unsuspend_items_request** | [**\OpenAPI\Client\Model\UnsuspendItemsRequest**](../Model/UnsuspendItemsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\MenuAsynchronousJob**](../Model/MenuAsynchronousJob.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
