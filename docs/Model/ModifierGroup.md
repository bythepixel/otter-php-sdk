# # ModifierGroup

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | The identifier that exists in the third party system. During a menu publish event, uuidV4 ids will be generated for new entities that do not yet exist in the internal menu. |
**name** | **string** | Name of ModifierGroup. |
**minimum_selections** | **int** | Minimum number of selections customers can make in this ModifierGroup. 0 means no min limits. | [optional]
**maximum_selections** | **int** | Maximum number of selections customers can make in this ModifierGroup. 0 means no max limits. | [optional]
**max_per_modifier_selection_quantity** | **int** | Maximum number of selections customers can make for each modifier item in this ModifierGroup. 0 means there is no limit to how many times they can select a single modifier item. If not specified, a value of 1 will be used as the default value. | [optional] [default to 1]
**item_ids** | **string[]** | Identifiers of each Item within this ModifierGroup. | [optional]
**description** | **string** | The description for this modifier group. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
