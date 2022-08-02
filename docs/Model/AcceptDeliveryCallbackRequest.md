# # AcceptDeliveryCallbackRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**delivery_distance** | [**\OpenAPI\Client\Model\Distance**](Distance.md) |  | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**cost** | [**\OpenAPI\Client\Model\DeliveryCost**](DeliveryCost.md) |  | [optional]
**fulfillment_path** | [**\OpenAPI\Client\Model\FulfillmentPathEntity[]**](FulfillmentPathEntity.md) | List of entities involved in the fulfillment processing path. | [optional]
**estimated_delivery_time** | **\DateTime** | The expected delivery time. | [optional]
**estimated_pickup_time** | **\DateTime** | The expected pickup time. | [optional]
**confirmed_at** | **\DateTime** | The time that the request was accepted. | [optional]
**delivery_tracking_url** | **string** | URL to a web page that tracks the delivery. | [optional]
**provider_delivery_id** | **string** | The provider&#39;s internal identifier for the delivery used for tracking purposes. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
