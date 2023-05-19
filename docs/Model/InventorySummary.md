# # InventorySummary

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | A unique identifier for the product. |
**gtin** | **string** | A 14 digit Global Trade Item Number (GTIN). For GTIN values that are shorter than 14 digits, value will be padded with leading zeroes. | [optional]
**name** | **string** | The name of the product. |
**sellable_quantity** | **int** | The total quantity of the product ready to be sold. Does not include pending or in-progress shipments. |
**unsellable_quantity** | **int** | The total quantity of the product that is in the facility but unable to be sold. This will include inventory that is damaged, expired or otherwise unsellable. | [optional]
**inbound_quantity** | **int** | The total quantity of the product inbound to the facility or waiting at the facility to be processed. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
