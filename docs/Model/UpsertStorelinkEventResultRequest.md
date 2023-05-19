# # UpsertStorelinkEventResultRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**success** | **bool** | Indicates if the partner application successfully created and validated the credential provided through the &#x60;Upsert Store Webhook&#x60;. |
**store_id** | **string** | The unique identifier of the store in the partner application. This ID, along with the &#x60;Application ID&#x60;, will be used to match the correct store when performing operations. It cannot be longer than 255 characters and must only contain printable ASCII characters. | [optional]
**error_message** | [**\OpenAPI\Client\Model\UpsertStorelinkEventResultRequestErrorMessage**](UpsertStorelinkEventResultRequestErrorMessage.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
