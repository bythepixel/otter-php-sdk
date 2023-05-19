# # GenerateReportMultiRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**report_type** | **string** | Type of report to generate | [optional]
**start** | **\DateTime** | Report start date | [optional]
**end** | **\DateTime** | Report end date | [optional]
**external_store_ids** | **string[]** | List of external store IDs to filter the orders with. At least one value is required. Max is 5000. Fails the requests if one or more invalid external store ID is passed | [optional]
**external_service_slugs** | **string[]** | List of external service slugs to fetch orders from. Default to all services | [optional]
**language** | **string** | Language of the report. Ignored by ORDER_STORES report Optional. Falls back to English if empty. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
