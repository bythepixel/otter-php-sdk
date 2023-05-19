# # FinancialInvoice

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**source_service** | **string** | Describes the source of the order, typically from a food ordering marketplace. | [optional]
**payout** | [**\OpenAPI\Client\Model\InvoicePayoutInfo**](InvoicePayoutInfo.md) |  |
**financial_transactions** | [**\OpenAPI\Client\Model\SimpleFinancialTransaction[]**](SimpleFinancialTransaction.md) | List of financial transactions related to this invoice. |
**currency_code** | **string** | The 3-letter currency code (ISO 4217) to use for all monetary values in this order. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
