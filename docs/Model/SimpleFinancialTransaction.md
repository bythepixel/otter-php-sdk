# # SimpleFinancialTransaction

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**order_identifiers** | [**\OpenAPI\Client\Model\SimpleOrderIdentifierFinance**](SimpleOrderIdentifierFinance.md) |  |
**id** | **string** | External financial transaction identifier. |
**created_at** | **\DateTime** | The date (in UTC) when the financial transaction was created. |
**customer_id** | **string** | Customer identifier. | [optional]
**notes** | **string** | General notes about the financial transaction. | [optional]
**type** | **string** | Financial transaction operation type. |
**order_items** | [**\OpenAPI\Client\Model\OrderItemInformation[]**](OrderItemInformation.md) | Detailed financial per order item. | [optional]
**issues** | [**\OpenAPI\Client\Model\OrderIssue[]**](OrderIssue.md) | List of issues that might have happened with the order. | [optional]
**data** | [**\OpenAPI\Client\Model\FinancialData**](FinancialData.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)