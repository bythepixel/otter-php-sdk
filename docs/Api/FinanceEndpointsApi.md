# OpenAPI\Client\FinanceEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**postFinancialInvoice()**](FinanceEndpointsApi.md#postFinancialInvoice) | **POST** /finance/v1/financial-invoices | Post a financial invoice |
| [**postFinancialTransactions()**](FinanceEndpointsApi.md#postFinancialTransactions) | **POST** /finance/v1/financial-transactions | Post financial transactions |


## `postFinancialInvoice()`

```php
postFinancialInvoice($x_store_id, $financial_invoice)
```

Post a financial invoice

Post a financial invoice containing payout and financial data for orders in a given period of time.

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
$x_store_id = 'x_store_id_example'; // string
$financial_invoice = new \OpenAPI\Client\Model\FinancialInvoice(); // \OpenAPI\Client\Model\FinancialInvoice

try {
    $apiInstance->postFinancialInvoice($x_store_id, $financial_invoice);
} catch (Exception $e) {
    echo 'Exception when calling FinanceEndpointsApi->postFinancialInvoice: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **financial_invoice** | [**\OpenAPI\Client\Model\FinancialInvoice**](../Model/FinancialInvoice.md)|  | |

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

## `postFinancialTransactions()`

```php
postFinancialTransactions($x_store_id, $financial_transaction)
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
$x_store_id = 'x_store_id_example'; // string
$financial_transaction = new \OpenAPI\Client\Model\FinancialTransaction(); // \OpenAPI\Client\Model\FinancialTransaction

try {
    $apiInstance->postFinancialTransactions($x_store_id, $financial_transaction);
} catch (Exception $e) {
    echo 'Exception when calling FinanceEndpointsApi->postFinancialTransactions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_store_id** | **string**|  | |
| **financial_transaction** | [**\OpenAPI\Client\Model\FinancialTransaction**](../Model/FinancialTransaction.md)|  | |

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
