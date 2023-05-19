# OpenAPI\Client\ReportsEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**generateReportMulti()**](ReportsEndpointsApi.md#generateReportMulti) | **POST** /v1/reports/generate | Request a business report for multiple stores |
| [**getReportStatus()**](ReportsEndpointsApi.md#getReportStatus) | **GET** /v1/reports/{jobId} | Request status of the report using jobId |


## `generateReportMulti()`

```php
generateReportMulti($generate_report_multi_request): \OpenAPI\Client\Model\GenerateReportResponse
```

Request a business report for multiple stores

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ReportsEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$generate_report_multi_request = new \OpenAPI\Client\Model\GenerateReportMultiRequest(); // \OpenAPI\Client\Model\GenerateReportMultiRequest

try {
    $result = $apiInstance->generateReportMulti($generate_report_multi_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReportsEndpointsApi->generateReportMulti: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **generate_report_multi_request** | [**\OpenAPI\Client\Model\GenerateReportMultiRequest**](../Model/GenerateReportMultiRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\GenerateReportResponse**](../Model/GenerateReportResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getReportStatus()`

```php
getReportStatus($job_id): \OpenAPI\Client\Model\GetReportStatusResponse
```

Request status of the report using jobId

`RATE LIMIT: 2 per minute`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ReportsEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$job_id = 'job_id_example'; // string

try {
    $result = $apiInstance->getReportStatus($job_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReportsEndpointsApi->getReportStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **job_id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\GetReportStatusResponse**](../Model/GetReportStatusResponse.md)

### Authorization

[OAuth2.0](../../README.md#OAuth2.0)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
