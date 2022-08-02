# # Order

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**external_identifiers** | [**\OpenAPI\Client\Model\OrderExternalIdentifiers**](OrderExternalIdentifiers.md) |  |
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values in this order. |
**status** | **string** | The status of the order. |
**items** | [**\OpenAPI\Client\Model\Item[]**](Item.md) | Items ordered. | [optional]
**ordered_at** | **\DateTime** | The date (in UTC) when the order was placed by the customer. | [optional]
**customer** | [**\OpenAPI\Client\Model\Person**](Person.md) |  | [optional]
**customer_note** | **string** | An order-level note provided by the customer. | [optional]
**delivery_info** | [**\OpenAPI\Client\Model\DeliveryInfo**](DeliveryInfo.md) |  | [optional]
**order_total** | [**\OpenAPI\Client\Model\OrderTotal**](OrderTotal.md) |  | [optional]
**order_total_v2** | [**\OpenAPI\Client\Model\OrderTotalV2**](OrderTotalV2.md) |  | [optional]
**customer_payments** | [**\OpenAPI\Client\Model\CustomerPayment[]**](CustomerPayment.md) | Details about the payments made by the customer. | [optional]
**fulfillment_info** | [**\OpenAPI\Client\Model\FulfillmentInfo**](FulfillmentInfo.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
