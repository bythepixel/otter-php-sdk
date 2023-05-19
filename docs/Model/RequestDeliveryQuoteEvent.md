# # RequestDeliveryQuoteEvent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**delivery_reference_id** | **string** | Generated delivery reference id. | [optional]
**provider** | **string** | the pre-configured fulfillment provider slug in the onboarding process. | [optional]
**preferred_pickup_duration** | **int** | Preferred time for courier to arrive to pick up order. Value expressed in minutes and is relative to time delivery request is made. If not provided, or if the value is 0, please treat it as an ASAP request. | [optional]
**pickup_address** | [**\OpenAPI\Client\Model\RequestDeliveryQuoteEventPickupAddress**](RequestDeliveryQuoteEventPickupAddress.md) |  | [optional]
**dropoff_address** | [**\OpenAPI\Client\Model\RequestDeliveryQuoteEventDropoffAddress**](RequestDeliveryQuoteEventDropoffAddress.md) |  | [optional]
**destination_address** | [**\OpenAPI\Client\Model\RequestDeliveryQuoteEventDestinationAddress**](RequestDeliveryQuoteEventDestinationAddress.md) |  | [optional]
**pick_up_location_id** | **string** | An identifier for the pick up location | [optional]
**order_sub_total** | **float** | The sum of all item and modifier pricing | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**contains_alcoholic_item** | **bool** | Whether or not the order contains an alcoholic item. | [optional]
**customer_payments** | [**\OpenAPI\Client\Model\CustomerPayment[]**](CustomerPayment.md) | Processed and collectible payments from the customer. | [optional]
**order_external_identifiers** | [**\OpenAPI\Client\Model\OrderExternalIdentifiers**](OrderExternalIdentifiers.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
