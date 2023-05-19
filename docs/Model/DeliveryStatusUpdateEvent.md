# # DeliveryStatusUpdateEvent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**provider** | **string** | Describes the provider of the delivery. | [optional]
**courier** | [**\OpenAPI\Client\Model\Courier**](Courier.md) |  | [optional]
**estimated_delivery_time** | **\DateTime** | The expected delivery time. | [optional]
**estimated_pickup_time** | **\DateTime** | The expected pickup time. | [optional]
**status** | [**\OpenAPI\Client\Model\DeliveryStatus**](DeliveryStatus.md) |  | [optional]
**delivery_status** | [**\OpenAPI\Client\Model\DeliveryStatus**](DeliveryStatus.md) |  | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**base_fee** | **float** |  | [optional]
**extra_fee** | **float** |  | [optional]
**total_fee** | **float** |  | [optional]
**distance** | [**\OpenAPI\Client\Model\Distance**](Distance.md) |  | [optional]
**updated_time** | **\DateTime** | The time that the delivery status was updated. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
