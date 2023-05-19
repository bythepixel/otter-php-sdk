# # DeliveryQuote

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Delivery request ID. | [optional]
**status** | **string** | Quote status. | [optional]
**wait_time_options** | **int[]** | Possible wait time durations in minutes | [optional]
**distance** | [**\OpenAPI\Client\Model\Distance**](Distance.md) |  | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**base_fee** | **float** | Use the cost field instead. | [optional]
**extra_fee** | **float** | Use the cost field instead. | [optional]
**total_fee** | **float** | Use the cost field instead. | [optional]
**cost** | [**\OpenAPI\Client\Model\DeliveryCost**](DeliveryCost.md) |  | [optional]
**provider** | **string** | Delivery Service Provider Slug. | [optional]
**fulfillment_path** | [**\OpenAPI\Client\Model\FulfillmentPathEntity[]**](FulfillmentPathEntity.md) | List of entities involved in the fulfillment processing path. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
