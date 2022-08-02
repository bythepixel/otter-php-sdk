# # Item

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**quantity** | **int** | The quantity of the item ordered by the customer. |
**sku_price** | **float** | The stored sku price of this item | [optional] [readonly]
**id** | **string** | The unique ID of the item. | [optional]
**name** | **string** | The name of the item as displayed to the customer. | [optional]
**note** | **string** | An optional item-level note provided by the customer. | [optional]
**category_id** | **string** | The unique ID of the category of this item. | [optional]
**category_name** | **string** | The name of the category of this item. | [optional]
**price** | **float** | The price of the sold item. | [optional]
**modifiers** | [**\OpenAPI\Client\Model\ItemModifier[]**](ItemModifier.md) | Modifiers to the base item. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
