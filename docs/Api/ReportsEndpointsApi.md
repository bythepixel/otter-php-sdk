# OpenAPI\Client\ReportsEndpointsApi

All URIs are relative to https://}.

Method | HTTP request | Description
------------- | ------------- | -------------
[**generateReport()**](ReportsEndpointsApi.md#generateReport) | **POST** /v1/reports | Request a business report for a store


## `generateReport()`

```php
generateReport($x_application_id, $x_store_id, $generate_report_request): \OpenAPI\Client\Model\GenerateReportResponse
```

Request a business report for a store

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
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$generate_report_request = new \OpenAPI\Client\Model\GenerateReportRequest(); // \OpenAPI\Client\Model\GenerateReportRequest

try {
    $result = $apiInstance->generateReport($x_application_id, $x_store_id, $generate_report_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReportsEndpointsApi->generateReport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **generate_report_request** | [**\OpenAPI\Client\Model\GenerateReportRequest**](../Model/GenerateReportRequest.md)|  |

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
