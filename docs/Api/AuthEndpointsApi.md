# OpenAPI\Client\AuthEndpointsApi

All URIs are relative to https://}, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**requestToken()**](AuthEndpointsApi.md#requestToken) | **POST** /v1/auth/token | Generate token |


## `requestToken()`

```php
requestToken($grant_type, $scope, $client_id, $client_secret): \OpenAPI\Client\Model\HydraToken
```

Generate token

Client credentials in the request-body and HTTP Basic Auth are supported.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$grant_type = 'grant_type_example'; // string | The OAuth2.0 grant types supported.
$scope = 'scope_example'; // string | The scope to request, multiple scopes are passed delimited by a space character.
$client_id = 'client_id_example'; // string | The ID of the client (also known as the Application ID).
$client_secret = 'client_secret_example'; // string | The secret of the client.

try {
    $result = $apiInstance->requestToken($grant_type, $scope, $client_id, $client_secret);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthEndpointsApi->requestToken: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **grant_type** | **string**| The OAuth2.0 grant types supported. | |
| **scope** | **string**| The scope to request, multiple scopes are passed delimited by a space character. | |
| **client_id** | **string**| The ID of the client (also known as the Application ID). | [optional] |
| **client_secret** | **string**| The secret of the client. | [optional] |

### Return type

[**\OpenAPI\Client\Model\HydraToken**](../Model/HydraToken.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/x-www-form-urlencoded`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
