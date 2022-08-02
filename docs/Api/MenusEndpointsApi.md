# OpenAPI\Client\MenusEndpointsApi

All URIs are relative to https://}.

Method | HTTP request | Description
------------- | ------------- | -------------
[**getAsyncJobStatus()**](MenusEndpointsApi.md#getAsyncJobStatus) | **GET** /v1/menus/jobs/{jobId} | Get the async menu job status
[**getMenu()**](MenusEndpointsApi.md#getMenu) | **GET** /v1/menus | Get the menus for a store
[**getMenuPublishTargets()**](MenusEndpointsApi.md#getMenuPublishTargets) | **GET** /v1/menus/pos/publish/targets | DEPRECATED - Get the MenuPublishTargets for a store
[**menuPublishCallback()**](MenusEndpointsApi.md#menuPublishCallback) | **POST** /v1/menus/publish | Notify the result of a Publish Menu event
[**menuSendCallback()**](MenusEndpointsApi.md#menuSendCallback) | **POST** /v1/menus/current | Notify the result of a Send Menu event
[**menuUpsertHours()**](MenusEndpointsApi.md#menuUpsertHours) | **POST** /v1/menus/hours | Notify the receival of a Upsert Hours Menu event
[**publishMenu()**](MenusEndpointsApi.md#publishMenu) | **POST** /v1/menus/pos/publish | DEPRECATED - Publish menus to targets for a store
[**suspendMenuEntities()**](MenusEndpointsApi.md#suspendMenuEntities) | **POST** /v1/menus/pos/entity/availability/suspend | DEPRECATED - Suspend menu entities targets for a store
[**unsuspendMenuEntities()**](MenusEndpointsApi.md#unsuspendMenuEntities) | **POST** /v1/menus/pos/entity/availability/unsuspend | DEPRECATED - Unsuspend menu entities targets for a store
[**updateMenuEntitiesAvailabilitiesCallback()**](MenusEndpointsApi.md#updateMenuEntitiesAvailabilitiesCallback) | **POST** /v1/menus/entity/availability/bulk | Notify the result of a Update Menu Entities Availabilities event
[**upsertMenu()**](MenusEndpointsApi.md#upsertMenu) | **POST** /v1/menus | Upsert menus for a store


## `getAsyncJobStatus()`

```php
getAsyncJobStatus($x_application_id, $x_store_id, $job_id): \OpenAPI\Client\Model\MenuAsynchronousJob
```

Get the async menu job status

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$job_id = 295f76b4-5725-4bf5-a8ab-97943dbdc3b4; // string

try {
    $result = $apiInstance->getAsyncJobStatus($x_application_id, $x_store_id, $job_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->getAsyncJobStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **job_id** | **string**|  |

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
getMenu($x_application_id, $x_store_id): \OpenAPI\Client\Model\Menus
```

Get the menus for a store

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string

try {
    $result = $apiInstance->getMenu($x_application_id, $x_store_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->getMenu: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |

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

## `getMenuPublishTargets()`

```php
getMenuPublishTargets($x_application_id, $x_store_id, $x_event_id): \OpenAPI\Client\Model\MenuPublishTargets
```

DEPRECATED - Get the MenuPublishTargets for a store

DEPRECATED: use /manager/menu/v1/menus/publish-targets.

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $result = $apiInstance->getMenuPublishTargets($x_application_id, $x_store_id, $x_event_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->getMenuPublishTargets: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **x_event_id** | **string**|  | [optional]

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

## `menuPublishCallback()`

```php
menuPublishCallback($x_application_id, $x_store_id, $x_event_id, $upsert_full_menu_event_callback)
```

Notify the result of a Publish Menu event

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$upsert_full_menu_event_callback = new \OpenAPI\Client\Model\UpsertFullMenuEventCallback(); // \OpenAPI\Client\Model\UpsertFullMenuEventCallback

try {
    $apiInstance->menuPublishCallback($x_application_id, $x_store_id, $x_event_id, $upsert_full_menu_event_callback);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->menuPublishCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **x_event_id** | **string**|  |
 **upsert_full_menu_event_callback** | [**\OpenAPI\Client\Model\UpsertFullMenuEventCallback**](../Model/UpsertFullMenuEventCallback.md)|  |

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
menuSendCallback($x_application_id, $x_store_id, $x_event_id, $send_menu_event_callback)
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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string
$send_menu_event_callback = new \OpenAPI\Client\Model\SendMenuEventCallback(); // \OpenAPI\Client\Model\SendMenuEventCallback

try {
    $apiInstance->menuSendCallback($x_application_id, $x_store_id, $x_event_id, $send_menu_event_callback);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->menuSendCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **x_event_id** | **string**|  |
 **send_menu_event_callback** | [**\OpenAPI\Client\Model\SendMenuEventCallback**](../Model/SendMenuEventCallback.md)|  |

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
menuUpsertHours($x_application_id, $x_store_id, $x_event_id)
```

Notify the receival of a Upsert Hours Menu event

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->menuUpsertHours($x_application_id, $x_store_id, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->menuUpsertHours: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **x_event_id** | **string**|  |

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

## `publishMenu()`

```php
publishMenu($x_application_id, $x_store_id, $menu_publish_request): \OpenAPI\Client\Model\MenuPublishResponse
```

DEPRECATED - Publish menus to targets for a store

DEPRECATED: use /manager/menu/v1/menus/publish.

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$menu_publish_request = new \OpenAPI\Client\Model\MenuPublishRequest(); // \OpenAPI\Client\Model\MenuPublishRequest

try {
    $result = $apiInstance->publishMenu($x_application_id, $x_store_id, $menu_publish_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->publishMenu: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **menu_publish_request** | [**\OpenAPI\Client\Model\MenuPublishRequest**](../Model/MenuPublishRequest.md)|  |

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

## `suspendMenuEntities()`

```php
suspendMenuEntities($x_application_id, $x_store_id, $suspend_items_request): \OpenAPI\Client\Model\MenuAsynchronousJob
```

DEPRECATED - Suspend menu entities targets for a store

DEPRECATED: use /manager/menu/v1/menus/entities/availability/suspend.

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$suspend_items_request = new \OpenAPI\Client\Model\SuspendItemsRequest(); // \OpenAPI\Client\Model\SuspendItemsRequest

try {
    $result = $apiInstance->suspendMenuEntities($x_application_id, $x_store_id, $suspend_items_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->suspendMenuEntities: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **suspend_items_request** | [**\OpenAPI\Client\Model\SuspendItemsRequest**](../Model/SuspendItemsRequest.md)|  |

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

## `unsuspendMenuEntities()`

```php
unsuspendMenuEntities($x_application_id, $x_store_id, $unsuspend_items_request): \OpenAPI\Client\Model\MenuAsynchronousJob
```

DEPRECATED - Unsuspend menu entities targets for a store

DEPRECATED: use /manager/menu/v1/menus/entities/availability/unsuspend.

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$unsuspend_items_request = new \OpenAPI\Client\Model\UnsuspendItemsRequest(); // \OpenAPI\Client\Model\UnsuspendItemsRequest

try {
    $result = $apiInstance->unsuspendMenuEntities($x_application_id, $x_store_id, $unsuspend_items_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->unsuspendMenuEntities: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **unsuspend_items_request** | [**\OpenAPI\Client\Model\UnsuspendItemsRequest**](../Model/UnsuspendItemsRequest.md)|  |

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

## `updateMenuEntitiesAvailabilitiesCallback()`

```php
updateMenuEntitiesAvailabilitiesCallback($x_application_id, $x_store_id, $x_event_id)
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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$x_event_id = cf0ce51b-d74e-40d3-b177-1925ab4edc0c; // string

try {
    $apiInstance->updateMenuEntitiesAvailabilitiesCallback($x_application_id, $x_store_id, $x_event_id);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->updateMenuEntitiesAvailabilitiesCallback: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **x_event_id** | **string**|  |

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
upsertMenu($x_application_id, $x_store_id, $menus_upsert_request): \OpenAPI\Client\Model\MenuAsynchronousJob
```

Upsert menus for a store

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$menus_upsert_request = new \OpenAPI\Client\Model\MenusUpsertRequest(); // \OpenAPI\Client\Model\MenusUpsertRequest

try {
    $result = $apiInstance->upsertMenu($x_application_id, $x_store_id, $menus_upsert_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenusEndpointsApi->upsertMenu: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **menus_upsert_request** | [**\OpenAPI\Client\Model\MenusUpsertRequest**](../Model/MenusUpsertRequest.md)|  |

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
