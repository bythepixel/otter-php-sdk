# # Address

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**full_address** | **string** | Full, human comprehensible address. It is usually formatted in the order appropriate for your locale. | [optional]
**postal_code** | **string** | Postal code of the address. | [optional]
**city** | **string** | The city/town portion of the address. | [optional]
**state** | **string** | Highest administrative subdivision which is used for postal addresses of a country or region. For example, this can be a state, a province, or a prefecture. | [optional]
**country_code** | **string** | CLDR country code. See http://cldr.unicode.org/ | [optional]
**address_lines** | **string[]** | Address lines (e.g. street, PO Box, or company name). Deprecated for linesOfAddress. | [optional]
**location** | [**\OpenAPI\Client\Model\Location**](Location.md) |  | [optional]
**lines_of_address** | **string[]** | Address lines (e.g. street, PO Box, or company name). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
