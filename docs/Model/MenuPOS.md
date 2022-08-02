# # MenuPOS

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Internal identifier for Menu. |
**name** | **string** | Name of the Menu. |
**category_ids** | **string[]** | Identifiers of the categories within this Menu. | [optional]
**fulfillment_modes** | **string[]** | The ways in which this menu may be fulfilled. If no values are specified, it is assumed that all fulfillment types are allowed. | [optional]
**description** | **string** | Description of the Menu. | [optional]
**hours** | [**\OpenAPI\Client\Model\Hours**](Hours.md) |  | [optional]
**additional_charges** | [**\OpenAPI\Client\Model\AdditionalCharge[]**](AdditionalCharge.md) | Additional charges to apply for this menu. All additional charges specified on a menu will only be applied once per order. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
