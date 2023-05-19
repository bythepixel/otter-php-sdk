# # DeliveryStatusUpdateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**delivery_status** | [**\OpenAPI\Client\Model\DeliveryStatus**](DeliveryStatus.md) |  | [optional]
**estimated_delivery_time** | **\DateTime** | The expected delivery time. | [optional]
**estimated_pickup_time** | **\DateTime** | The expected pickup time. | [optional]
**courier** | [**\OpenAPI\Client\Model\Person**](Person.md) |  | [optional]
**location** | [**\OpenAPI\Client\Model\Location**](Location.md) |  | [optional]
**created_at** | **\DateTime** | The time that the update was created. | [optional]
**vehicle_information** | [**\OpenAPI\Client\Model\VehicleInformation**](VehicleInformation.md) |  | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**cost** | [**\OpenAPI\Client\Model\DeliveryCost**](DeliveryCost.md) |  | [optional]
**provider_delivery_id** | **string** | The provider&#39;s internal identifier for the delivery used for tracking purposes. | [optional]
**dropoff_info** | [**\OpenAPI\Client\Model\DropoffInfo**](DropoffInfo.md) |  | [optional]
**delivery_tracking_url** | **string** | Delivery tracking url. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
