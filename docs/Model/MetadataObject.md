# # MetadataObject

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**store_id** | **string** | The unique identifier of the store in the partner application. This ID, along with the &#x60;Application ID&#x60;, will be used to match the correct store when performing operations. It cannot be longer than 255 characters and must only contain printable ASCII characters. | [optional]
**application_id** | **string** | The plain-text Application ID, provided at partner onboarding, also available on Developer Portal. | [optional]
**resource_id** | **string** | Identifier of the resource that this event refers to, if needed. | [optional]
**payload** | **object** | Object containing details of the given event, if needed. | [optional]
**resource_href** | **string** | The full endpoint to fetch the details of the resource, if needed. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
