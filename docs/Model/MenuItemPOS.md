# # MenuItemPOS

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Internal identifier of this Item. |
**name** | **string** | Name of this Item |
**photo_ids** | **string[]** | A list of Photo references associated with the Item. |
**price** | [**\OpenAPI\Client\Model\Money**](Money.md) |  |
**status** | [**\OpenAPI\Client\Model\ItemStatus**](ItemStatus.md) |  |
**description** | **string** | Description of this Item | [optional]
**modifier_group_ids** | **string[]** | Identifiers of each ModifierGroup within this Item. | [optional]
**price_overrides** | [**\OpenAPI\Client\Model\ItemPriceOverride[]**](ItemPriceOverride.md) | Specify price overrides for different service slugs. | [optional]
**sku_details** | [**\OpenAPI\Client\Model\SkuDetails**](SkuDetails.md) |  | [optional]
**additional_charges** | [**\OpenAPI\Client\Model\AdditionalCharge[]**](AdditionalCharge.md) | Additional charges to apply for this item. Additional charges will be applied for every instance of this item within an order. | [optional]
**tax** | [**\OpenAPI\Client\Model\ItemTax**](ItemTax.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
