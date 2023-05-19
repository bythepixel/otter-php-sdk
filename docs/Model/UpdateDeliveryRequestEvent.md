# # UpdateDeliveryRequestEvent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**delivery_reference_id** | **string** | Generated delivery reference id. | [optional]
**provider** | **string** | the pre-configured fulfillment provider slug in the onboarding process. | [optional]
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values. | [optional]
**customer_payments** | [**\OpenAPI\Client\Model\CustomerPayment[]**](CustomerPayment.md) | Processed and collectible payments from the customer. | [optional]
**customer_tip** | [**\OpenAPI\Client\Model\CustomerTip**](CustomerTip.md) |  | [optional]
**pick_up_info** | [**\OpenAPI\Client\Model\PickUpInfo**](PickUpInfo.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
