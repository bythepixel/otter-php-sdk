# # POSFeedDelivery

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**provider** | **string** | Delivery Service Provider Slug. | [optional]
**courier** | [**\OpenAPI\Client\Model\Courier**](Courier.md) |  | [optional]
**estimated_delivery_time** | **\DateTime** | Estimated delivery time | [optional]
**estimated_pickup_time** | **\DateTime** | Estimated pickup time | [optional]
**status** | [**\OpenAPI\Client\Model\DeliveryStatus**](DeliveryStatus.md) |  | [optional]
**delivery_status** | **string** | Use the status field instead. | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**base_fee** | **float** | Base delivery cost value. | [optional]
**extra_fee** | **float** | Extra delivery cost value. | [optional]
**total_fee** | **float** | Total delivery cost value. | [optional]
**distance** | [**\OpenAPI\Client\Model\Distance**](Distance.md) |  | [optional]
**processed_time** | **\DateTime** | Time that the delivery was accepted and confirmed. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
