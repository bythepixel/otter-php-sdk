# # UpsertFullMenuEventCallback

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**requested_to_created_entity_ids** | **array<string,string>** | A map for entities created by the Upsert containing the IDs of the requested entities mapped to the IDs of entities created by the request. Our system will use the IDs returned in this map to send updates to these entities in future requests. **NOTE -** A empty map can be used on requestedToCreatedEntityIds to use the same menu IDs that were previously defined. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
