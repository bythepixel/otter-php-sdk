# # ItemUpdateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Identifier of this Item. |
**name** | **string** | Name of this Item |
**price** | [**\OpenAPI\Client\Model\Money**](Money.md) |  |
**status** | [**\OpenAPI\Client\Model\ItemStatus**](ItemStatus.md) |  |
**description** | **string** | Description of this Item |
**modifier_group_ids** | **string[]** | Identifiers of each ModifierGroup within this Item. | [optional]
**price_overrides** | [**\OpenAPI\Client\Model\ItemPriceOverride[]**](ItemPriceOverride.md) | Specify price overrides for different service slugs. | [optional]
**photo_urls** | **string[]** | List of photoUrls to associate with the Item. This is used only for POST/PUT requests. | [optional]
**sku_details** | [**\OpenAPI\Client\Model\SkuDetails**](SkuDetails.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
