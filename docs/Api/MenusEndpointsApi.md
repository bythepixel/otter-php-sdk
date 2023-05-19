# OpenAPI\Client\MenusEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**menuPublishCallback()**](MenusEndpointsApi.md#menuPublishCallback) | **POST** /v1/menus/publish | Notify the result of a Publish Menu event |
| [**menuSendCallback()**](MenusEndpointsApi.md#menuSendCallback) | **POST** /v1/menus/current | Notify the result of a Send Menu event |
| [**menuUpsertHours()**](MenusEndpointsApi.md#menuUpsertHours) | **POST** /v1/menus/hours | Notify the receival of a Upsert Hours Menu event |
| [**updateMenuEntitiesAvailabilitiesCallback()**](MenusEndpointsApi.md#updateMenuEntitiesAvailabilitiesCallback) | **POST** /v1/menus/entity/availability/bulk | Notify the result of a Update Menu Entities Availabilities event |
| [**upsertMenu()**](MenusEndpointsApi.md#upsertMenu) | **POST** /v1/menus | Upsert menus for a store |


## `menuPublishCallback()`

```php
menuPublishCallback($x_store_id, $x_event_id, $upsert_full_menu_event_callback)
```

Notify the result of a Publish Menu event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MenusEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$upsert_full_menu_event_callback = new \OpenAPI\Client\Model\UpsertFullMenuEventCallback(); // \OpenAPI\Client\Model\UpsertFullMenuEventCallback

try {
    $apiInstance->menuPublishCallback($x_store_id, $x_event_id, $upsert_full_menu_event_callback);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->menuPublishCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **upsert_full_menu_event_callback** | [**\OpenAPI\Client\Model\UpsertFullMenuEventCallback**](../Model/UpsertFullMenuEventCallback.md)|  | |

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

## `menuSendCallback()`

```php
menuSendCallback($x_store_id, $x_event_id, $send_menu_event_callback)
```

Notify the result of a Send Menu event

`RATE LIMIT: 4 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MenusEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$send_menu_event_callback = new \OpenAPI\Client\Model\SendMenuEventCallback(); // \OpenAPI\Client\Model\SendMenuEventCallback

try {
    $apiInstance->menuSendCallback($x_store_id, $x_event_id, $send_menu_event_callback);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->menuSendCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **x_event_id** | **string**|  | |
| **send_menu_event_callback** | [**\OpenAPI\Client\Model\SendMenuEventCallback**](../Model/SendMenuEventCallback.md)|  | |

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

## `menuUpsertHours()`

```php
menuUpsertHours($x_store_id, $x_event_id)
```

Notify the receival of a Upsert Hours Menu event

`RATE LIMIT: 8 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MenusEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->menuUpsertHours($x_store_id, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->menuUpsertHours: ', $e->getMessage(), PHP_EOL;
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

## `updateMenuEntitiesAvailabilitiesCallback()`

```php
updateMenuEntitiesAvailabilitiesCallback($x_store_id, $x_event_id)
```

Notify the result of a Update Menu Entities Availabilities event

`RATE LIMIT: 32 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MenusEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->updateMenuEntitiesAvailabilitiesCallback($x_store_id, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->updateMenuEntitiesAvailabilitiesCallback: ', $e->getMessage(), PHP_EOL;
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

## `upsertMenu()`

```php
upsertMenu($x_store_id, $menus_upsert_request): \OpenAPI\Client\Model\MenuAsynchronousJob
```

Upsert menus for a store

`RATE LIMIT: 2 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MenusEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_store_id = 'x_store_id_example'; // string
$menus_upsert_request = new \OpenAPI\Client\Model\MenusUpsertRequest(); // \OpenAPI\Client\Model\MenusUpsertRequest

try {
    $result = $apiInstance->upsertMenu($x_store_id, $menus_upsert_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->upsertMenu: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **menus_upsert_request** | [**\OpenAPI\Client\Model\MenusUpsertRequest**](../Model/MenusUpsertRequest.md)|  | |

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
