# # RequestDeliveryQuoteCallbackRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**min_pickup_duration** | **int** | Minimum time required for courier to arrive at pickup location in minutes It is an estimation. | [optional]
**max_pickup_duration** | **int** | Maximum time that the courier&#39;s arrival at pick up location can be delayed. If not provided, it will default to 60 minutes or minPickUpDuration, whichever is greater. This value is an estimation and expressed in minutes. | [optional]
**delivery_distance** | [**\OpenAPI\Client\Model\Distance**](Distance.md) |  | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**cost** | [**\OpenAPI\Client\Model\DeliveryCost**](DeliveryCost.md) |  | [optional]
**provider** | **string** | Delivery Service Provider Slug. | [optional]
**fulfillment_path** | [**\OpenAPI\Client\Model\FulfillmentPathEntity[]**](FulfillmentPathEntity.md) | List of entities involved in the fulfillment processing path. | [optional]
**created_at** | **\DateTime** | The time that the quote was created. | [optional]
**account_balance** | **float** | The remaining account balance of the requester for the delivery provider. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
