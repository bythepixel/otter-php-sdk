# OpenAPI\Client\FinanceEndpointsApi

All URIs are relative to https://}.

Method | HTTP request | Description
------------- | ------------- | -------------
[**postFinancialTransactions()**](FinanceEndpointsApi.md#postFinancialTransactions) | **POST** /finance/v1/financial-transactions | Post financial transactions


## `postFinancialTransactions()`

```php
postFinancialTransactions($x_application_id, $x_store_id, $financial_transaction)
```

Post financial transactions

Post financial data related to a given order.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2.0
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\FinanceEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_application_id = 'x_application_id_example'; // string
$x_store_id = 'x_store_id_example'; // string
$financial_transaction = new \OpenAPI\Client\Model\FinancialTransaction(); // \OpenAPI\Client\Model\FinancialTransaction

try {
    $apiInstance->postFinancialTransactions($x_application_id, $x_store_id, $financial_transaction);
} catch (Exception $e) {
    echo 'Exception when calling FinanceEndpointsApi->postFinancialTransactions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_application_id** | **string**|  |
 **x_store_id** | **string**|  |
 **financial_transaction** | [**\OpenAPI\Client\Model\FinancialTransaction**](../Model/FinancialTransaction.md)|  |

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
