# # ModifierGroupUpdateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Identifier for ModifierGroup. |
**name** | **string** | Name of ModifierGroup. |
**minimum_selections** | **int** | Minimum number of selections customers can make in this ModifierGroup. 0 means no min limits. | [optional]
**maximum_selections** | **int** | Maximum number of selections customers can make in this ModifierGroup. 0 means no max limits. | [optional]
**max_per_modifier_selection_quantity** | **int** | Maximum number of selections customers can make for each modifier item in this ModifierGroup. 0 means there is no limit to how many times they can select a single modifier item. If not specified, a value of 1 will be used as the default value. | [optional]
**item_ids** | **string[]** | Identifiers of each Item within this ModifierGroup. | [optional]
**description** | **string** | Description for this ModifierGroup. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
