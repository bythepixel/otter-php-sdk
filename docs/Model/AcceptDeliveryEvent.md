# # AcceptDeliveryEvent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**delivery_reference_id** | **string** | Generated delivery reference id. | [optional]
**provider** | **string** | the pre-configured fulfillment provider slug in the onboarding process. | [optional]
**preferred_pickup_time** | **\DateTime** | Preferred time for courier to arrive to pick up order. If not provided or if the timestamp is in the past, treat it as an ASAP request. | [optional]
**pickup_order_id** | **string** | An identifier used for picking up order from pickup address. | [optional]
**pickup_note** | **string** | Additional information to instruct couriers how to pickup the order. Deprecated in favor of pickUpInstructions. | [optional]
**pickup_address** | [**\OpenAPI\Client\Model\RequestDeliveryQuoteEventPickupAddress**](RequestDeliveryQuoteEventPickupAddress.md) |  | [optional]
**dropoff_note** | **string** | Additional information to instruct couriers how to dropoff the order. | [optional]
**dropoff_address** | [**\OpenAPI\Client\Model\RequestDeliveryQuoteEventDropoffAddress**](RequestDeliveryQuoteEventDropoffAddress.md) |  | [optional]
**customer** | [**\OpenAPI\Client\Model\RequiredPerson**](RequiredPerson.md) |  | [optional]
**customer_payments** | [**\OpenAPI\Client\Model\CustomerPayment[]**](CustomerPayment.md) | Processed and collectible payments from the customer. | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**customer_tip** | [**\OpenAPI\Client\Model\CustomerTip**](CustomerTip.md) |  | [optional]
**order_sub_total** | **float** | The sum of all item and modifier pricing | [optional]
**pick_up_location_id** | **string** | An identifier for the pick up location | [optional]
**contains_alcoholic_item** | **bool** | Whether or not the order contains an alcoholic item. | [optional]
**pick_up_instructions** | **string** | Additional information to instruct couriers how to pickup the order. | [optional]
**store** | [**\OpenAPI\Client\Model\Store**](Store.md) |  | [optional]
**order_items** | [**\OpenAPI\Client\Model\Item2[]**](Item2.md) | Items and modifiers in the order. | [optional]
**ofo_display_id** | **string** | An identifier used to reference the order in the order source. | [optional]
**ofo_slug** | **string** | Slug to identify the OFO that is the source of order. | [optional]
**pick_up_info** | [**\OpenAPI\Client\Model\PickUpInfo**](PickUpInfo.md) |  | [optional]
**order_external_identifiers** | [**\OpenAPI\Client\Model\OrderExternalIdentifiers**](OrderExternalIdentifiers.md) |  | [optional]
**dropoff_instructions** | [**\OpenAPI\Client\Model\DropoffInstructions**](DropoffInstructions.md) |  | [optional]
**delivery_fee** | [**\OpenAPI\Client\Model\DeliveryFee**](DeliveryFee.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
