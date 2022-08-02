# # FulfillmentInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**pickup_time** | **\DateTime** | Estimated time (in UTC) that the courier or customer will pick up the order. | [optional]
**delivery_time** | **\DateTime** | Estimated time (in UTC) when the order is expected to be delivered. This should be filled in if FulfillmentMode is delivery. | [optional]
**fulfillment_mode** | **string** | How an order is expected to be fulfilled. | [optional] [default to 'DELIVERY']
**scheduling_type** | **string** | Describes whether this order should be cooked as soon as possible, or some time in the future. Please use the pickupTime and/or deliveryTime to indicate when. If no scheduling type is provided, we assume the order should be prepared as soon as possible. | [optional]
**courier_status** | **string** | The status of the courier. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
