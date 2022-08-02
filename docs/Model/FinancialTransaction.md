# # FinancialTransaction

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**order_identifiers** | [**\OpenAPI\Client\Model\OrderIdentifierFinance**](OrderIdentifierFinance.md) |  |
**id** | **string** | External financial transaction identifier. |
**pending** | **bool** | Whether the transaction can be updated in the future. |
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values in this order. |
**created_at** | **\DateTime** | The date (in UTC) when the financial transaction was created. |
**customer_id** | **string** | Customer identifier. | [optional]
**notes** | **string** | General notes about the financial transaction. | [optional]
**type** | **string** | Financial transaction operation type. |
**payout** | [**\OpenAPI\Client\Model\PayoutInfo**](PayoutInfo.md) |  | [optional]
**order_items** | [**\OpenAPI\Client\Model\OrderItemInformation[]**](OrderItemInformation.md) | Detailed financial per order item. | [optional]
**data** | [**\OpenAPI\Client\Model\FinancialData**](FinancialData.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
