# OpenAPIClient-php

# Overview

The API endpoints are developed around [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) principles secure via the OAuth2.0 protocol.

Beyond the entry points, the API also provides a line of communication into your system via [webhooks](https://en.wikipedia.org/wiki/Webhook).

For testing purposes, we offer a staging environment. Also, more detailed information about the business rules and workflows can be found on the [**Documentation Section**](/docs/)

## Versioning
Each API is versioned individually, but we follow these rules:
- Non breaking changes (eg: adding new fields) are added in the current version without previous communication
- Breaking changes (fields removal, semantic changed or schema update) have the version incremented
- Users will be notified about new versions and will be given time to migrate (the time will be set on a case by case)
- Once users migrate to the new version, we will deprecate the old ones
- Once there is a new version for an API, we won't accept new integrations targeting old versions

## API General Definitions
The APIs use resource-oriented URLs communicating, primarily, via JSON and leveraging the HTTP headers, [response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status), and verbs.

To exemplify how the API is to be consumed, consider a fake GET resource endpoint invocation below:

```
curl --request GET 'https://{{public-api-url}}/v1/resource/123' \\
--header 'Authorization: Bearer 34fdabeeafds=' --header 'X-Store-Id: 321' --header 'X-Application-Id: e22f94b3-967c-4e26-bf39-9e364066b68b'
```

|      Header      | Description |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|`Authorization`   | Standard HTTP header is used to associate the request with the originating invoker. The content of this header is a `Bearer` token generated from you client_secret, defined in the [API Auth](#/section/Guides/API-Auth) guide.|
|`X-Application-Id`| The plain-text `Application Id`, provided at onboarding. |
|`X-Store-Id`      | The ID of the store in your system this call acts on behalf of. |

_All resource endpoints expect the `Authorization` and `X-Application-Id` header, the remaining headers are explicitly stated in the individual endpoint documentation section._

With these headers, the system will:
 - Validate the client token, making sure the call is originating from a trusted source.
 - Validate that the Application has the permission to access the `v1/resource/{id}` resource via the Application's pre-configured scopes.
 - Translate your X-Store-Id to our internal store ID (e.g. `AAA`).
 - Validate and retrieve resource `AAA`, that is associated to your Application via store id `321`.

POST/PUT methods will look similar to the GET calls, but they'll take in a body in the HTTP request (default to the application/json content-type).

```
curl --location --request POST 'https://{{public-api-url}}/v1/resource' \\
--header 'Authorization: Bearer 34fdabeeafds=' --header 'X-Store-Id: 321' --header 'X-Application-Id: e22f94b3-967c-4e26-bf39-9e364066b68b\"
--data '{\"foo\": \"bar\"}'
```

## API Authentication/Authorization

<SecurityDefinitions />

The **Authorization API** is based on the [OAuth2.0 protocol](https://tools.ietf.org/html/rfc6749), using the [client credentials grant](https://tools.ietf.org/html/rfc6749#section-4.4). Resources expect a valid token sent as a `Bearer` token in the HTTP `Authorization` header.

To generate the token, use the `Application ID` and `Client Secret` (provided during onboarding) to the [Token Auth endpoint](#operation/requestToken) endpoint. The result of this invocation is a token that is valid for a pre-determined time or until it is manually revoked.

The response of the following endpoints will return a token that will be sent as a `Bearer` value of the `Authorization` HTTP header, along with meta information such as expiry-date.

_Note that the referred `client_id` is the `Application ID` because though we chose adhere to the OAuth2.0 standard for the auth APIs._

### Request Examples

#### URL Encoded Form

The API exposes a token generation endpoint expects your *client_id* and *client_secret* to be formatted as *application/x-www-form-urlencoded* content type.
```
curl --location --request POST 'https://{{public-api-url}}/v1/auth/token' \\
--header 'Content-Type: application/x-www-form-urlencoded' \\
--data-urlencode 'scope=ping' \\
--data-urlencode 'grant_type=client_credentials' \\
--data-urlencode 'client_id=[APPLICATION_ID]' \\
--data-urlencode 'client_secret=[CLIENT_SECRET]'
```

#### HTTP Basic Auth

Alternatively, the API also accepts a `Basic` Authorization header with the Base64 encoding of the `client_id` (`Application ID`) and `client_secret` joined by a single colon `:`.

```
BASE64_ENCODED_CREDENTIALS = base64_encode(client_id + \":\" + client_secret)
```

```
curl --location --request POST 'https://{{public-api-url}}/v1/auth/token' \\
--header 'Authorization: Basic [BASE64_ENCODED_CREDENTIALS]' \\
--header 'Content-Type: application/x-www-form-urlencoded' \\
--data-urlencode 'scope=ping' \\
--data-urlencode 'grant_type=client_credentials'
```

## Webhook

The Public API is able to send notifications to your system via HTTP POST requests.

Every webhook is signed using HMAC-SHA256 that is present in the header `X-HMAC-SHA256`, and you can also authenticate the requests using Basic Auth, Bearer Token or HMAC-SHA1 (legacy). Please, refer to [**Webhook Authentication Guide**](/docs/guides-webhook-authentication/) for more details.

_Please work with your Account Representative to setup your Application's Webhook configurations._

```
Example Base-URL = https://{{your-server-url}}/webhook
```

### Notification Schema

| **Name**                | **Type** | **Description**                                                      |
| ------------------------| ---------| -------------------------------------------------------------------- |
| eventId                 | string   | Unique id of the event.                                              |
| eventTime               | string   | The time the event occurred.                                         |
| eventType               | string   | The type of event (e.g. create_order).                               |
| metadata.storeId        | string   | Id of the store for which the event is being published.              |
| metadata.applicationId  | string   | Id of the application for which the event is being published.        |
| metadata.resourceId     | string   | The external identifier of the resource that this event refers to.   |
| metadata.resourceHref   | string   | The endpoint to fetch the details of the resource.                   |
| metadata.payload        | object   | The event object which will be detailed in each Webhook description. |

### Notification Request Example

```
curl --location --request POST 'https://{{your-server-url}}/webhook' \\
--header 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36' \\
--header 'Authorization: MAC <hash signature>' \\
--header 'Content-Type: application/json' \\
--data-raw '{
   \"eventId\": \"123456\",
   \"eventTime\": \"2020-10-10T20:06:02:123Z\",
   \"eventType\": \"orders.new_order\",
   \"metadata\": {
      \"storeId\": \"755fd19a-7562-487a-b615-171a9f89d669\",
      \"applicationId\": \"e22f94b3-967c-4e26-bf39-9e364066b68b\",
      \"resourceHref\": \"https://{{public-api-url}}/v1/orders/bf9f1d81-f213-496e-a026-91b6af44996c\",
      \"resourceId\": \"bf9f1d81-f213-496e-a026-91b6af44996c\",
      \"payload\": {}
   }
}
```

## Expected Response

The partner application should return an HTTP 200 response code with an empty response body to acknowledge receipt of the webhook event.
## Rate Limiting
Please, refer to [**Rate Limiting Guide**](/docs/guides-rate-limiting/) for more details.


## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\AuthEndpointsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$grant_type = 'grant_type_example'; // string | The OAuth2.0 grant types supported.
$scope = 'scope_example'; // string | The scope to request, multiple scopes are passed delimited by a space character.
$client_id = 'client_id_example'; // string | The ID of the client (also known as the Application ID).
$client_secret = 'client_secret_example'; // string | The secret of the client.

try {
    $result = $apiInstance->requestToken($grant_type, $scope, $client_id, $client_secret);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthEndpointsApi->requestToken: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://}*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AuthEndpointsApi* | [**requestToken**](docs/Api/AuthEndpointsApi.md#requesttoken) | **POST** /v1/auth/token | Generate token
*CallbackEndpointsApi* | [**publishError**](docs/Api/CallbackEndpointsApi.md#publisherror) | **POST** /v1/callback/error | Publish callback error
*DeliveryEndpointsApi* | [**acceptDeliveryCallback**](docs/Api/DeliveryEndpointsApi.md#acceptdeliverycallback) | **POST** /v1/delivery/{deliveryReferenceId}/accept | Notify the result of an accept delivery event
*DeliveryEndpointsApi* | [**cancelDeliveryCallback**](docs/Api/DeliveryEndpointsApi.md#canceldeliverycallback) | **POST** /v1/delivery/{deliveryReferenceId}/cancel | Notify the result of a cancel delivery event
*DeliveryEndpointsApi* | [**deliveryCallbackError**](docs/Api/DeliveryEndpointsApi.md#deliverycallbackerror) | **POST** /v1/delivery/callback/error | Publish delivery callback error
*DeliveryEndpointsApi* | [**requestDeliveryQuoteCallback**](docs/Api/DeliveryEndpointsApi.md#requestdeliveryquotecallback) | **POST** /v1/delivery/{deliveryReferenceId}/quotes | Notify the result of a request delivery quote event
*DeliveryEndpointsApi* | [**updateDeliveryStatus**](docs/Api/DeliveryEndpointsApi.md#updatedeliverystatus) | **PUT** /v1/delivery/{deliveryReferenceId}/status | Update delivery status
*FinanceEndpointsApi* | [**postFinancialTransactions**](docs/Api/FinanceEndpointsApi.md#postfinancialtransactions) | **POST** /finance/v1/financial-transactions | Post financial transactions
*ManagerMenuEndpointsApi* | [**managerGetMenuPublishTargets**](docs/Api/ManagerMenuEndpointsApi.md#managergetmenupublishtargets) | **GET** /manager/menu/v1/menus/publish-targets | Get the publish-targets for a store
*ManagerMenuEndpointsApi* | [**managerPublishMenu**](docs/Api/ManagerMenuEndpointsApi.md#managerpublishmenu) | **POST** /manager/menu/v1/menus/publish | Publish menus to targets for a store
*ManagerMenuEndpointsApi* | [**managerSuspendMenuEntities**](docs/Api/ManagerMenuEndpointsApi.md#managersuspendmenuentities) | **POST** /manager/menu/v1/menus/entities/availability/suspend | Suspend menu entities targets for a store
*ManagerMenuEndpointsApi* | [**managerUnsuspendMenuEntities**](docs/Api/ManagerMenuEndpointsApi.md#managerunsuspendmenuentities) | **POST** /manager/menu/v1/menus/entities/availability/unsuspend | Unsuspend menu entities targets for a store
*ManagerOrderEndpointsApi* | [**getManagerOrder**](docs/Api/ManagerOrderEndpointsApi.md#getmanagerorder) | **GET** /manager/order/v1/sources/{source}/orders/{orderId} | Fetch order with Manager Info
*ManagerOrderEndpointsApi* | [**managerGetOrderFeed**](docs/Api/ManagerOrderEndpointsApi.md#managergetorderfeed) | **GET** /manager/order/v1/orders | Fetch order feed for a store
*ManagerOrderEndpointsApi* | [**markAsFulfilled**](docs/Api/ManagerOrderEndpointsApi.md#markasfulfilled) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/fulfill | Mark an order as fulfilled.
*ManagerOrderEndpointsApi* | [**markAsReadyToPickup**](docs/Api/ManagerOrderEndpointsApi.md#markasreadytopickup) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/ready-to-pickup | Mark an order as ready to pickup
*ManagerOrderEndpointsApi* | [**requestOrderCancelation**](docs/Api/ManagerOrderEndpointsApi.md#requestordercancelation) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/cancel | Request order cancelation
*ManagerOrderEndpointsApi* | [**requestOrderConfirmation**](docs/Api/ManagerOrderEndpointsApi.md#requestorderconfirmation) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/confirm | Request order confirmation
*ManagerOrderEndpointsApi* | [**requestOrderReInjection**](docs/Api/ManagerOrderEndpointsApi.md#requestorderreinjection) | **POST** /manager/order/v1/sources/{source}/orders/{orderId}/re-inject | Request order re-injection
*MenusEndpointsApi* | [**getAsyncJobStatus**](docs/Api/MenusEndpointsApi.md#getasyncjobstatus) | **GET** /v1/menus/jobs/{jobId} | Get the async menu job status
*MenusEndpointsApi* | [**getMenu**](docs/Api/MenusEndpointsApi.md#getmenu) | **GET** /v1/menus | Get the menus for a store
*MenusEndpointsApi* | [**getMenuPublishTargets**](docs/Api/MenusEndpointsApi.md#getmenupublishtargets) | **GET** /v1/menus/pos/publish/targets | DEPRECATED - Get the MenuPublishTargets for a store
*MenusEndpointsApi* | [**menuPublishCallback**](docs/Api/MenusEndpointsApi.md#menupublishcallback) | **POST** /v1/menus/publish | Notify the result of a Publish Menu event
*MenusEndpointsApi* | [**menuSendCallback**](docs/Api/MenusEndpointsApi.md#menusendcallback) | **POST** /v1/menus/current | Notify the result of a Send Menu event
*MenusEndpointsApi* | [**menuUpsertHours**](docs/Api/MenusEndpointsApi.md#menuupserthours) | **POST** /v1/menus/hours | Notify the receival of a Upsert Hours Menu event
*MenusEndpointsApi* | [**publishMenu**](docs/Api/MenusEndpointsApi.md#publishmenu) | **POST** /v1/menus/pos/publish | DEPRECATED - Publish menus to targets for a store
*MenusEndpointsApi* | [**suspendMenuEntities**](docs/Api/MenusEndpointsApi.md#suspendmenuentities) | **POST** /v1/menus/pos/entity/availability/suspend | DEPRECATED - Suspend menu entities targets for a store
*MenusEndpointsApi* | [**unsuspendMenuEntities**](docs/Api/MenusEndpointsApi.md#unsuspendmenuentities) | **POST** /v1/menus/pos/entity/availability/unsuspend | DEPRECATED - Unsuspend menu entities targets for a store
*MenusEndpointsApi* | [**updateMenuEntitiesAvailabilitiesCallback**](docs/Api/MenusEndpointsApi.md#updatemenuentitiesavailabilitiescallback) | **POST** /v1/menus/entity/availability/bulk | Notify the result of a Update Menu Entities Availabilities event
*MenusEndpointsApi* | [**upsertMenu**](docs/Api/MenusEndpointsApi.md#upsertmenu) | **POST** /v1/menus | Upsert menus for a store
*OrdersEndpointsApi* | [**createOrder**](docs/Api/OrdersEndpointsApi.md#createorder) | **POST** /v1/orders | Create order
*OrdersEndpointsApi* | [**getOrderFeed**](docs/Api/OrdersEndpointsApi.md#getorderfeed) | **GET** /v1/orders/feed | DEPRECATED - Fetch order feed for a store
*OrdersEndpointsApi* | [**getPosOrder**](docs/Api/OrdersEndpointsApi.md#getposorder) | **GET** /v1/orders/{orderId}/{source}/pos | DEPRECATED - Fetch order with POS Info
*OrdersEndpointsApi* | [**posUpdateOrder**](docs/Api/OrdersEndpointsApi.md#posupdateorder) | **POST** /v1/orders/status | DEPRECATED - Update order status
*OrdersEndpointsApi* | [**updateOrder**](docs/Api/OrdersEndpointsApi.md#updateorder) | **PUT** /v1/orders/{orderId} | Update order
*OrdersEndpointsApi* | [**updateOrderCustomerPayment**](docs/Api/OrdersEndpointsApi.md#updateordercustomerpayment) | **PUT** /v1/orders/{orderId}/payments | Update order customer payment
*OrdersEndpointsApi* | [**updateOrderDeliveryInfo**](docs/Api/OrdersEndpointsApi.md#updateorderdeliveryinfo) | **PUT** /v1/orders/{orderId}/delivery | Update order delivery information
*OrdersEndpointsApi* | [**updateOrderStatus**](docs/Api/OrdersEndpointsApi.md#updateorderstatus) | **POST** /v1/orders/{orderId}/status | Update order status
*PingEndpointsApi* | [**ping**](docs/Api/PingEndpointsApi.md#ping) | **GET** /v1/ping | Ping the system
*ReportsEndpointsApi* | [**generateReport**](docs/Api/ReportsEndpointsApi.md#generatereport) | **POST** /v1/reports | Request a business report for a store
*StorefrontEndpointsApi* | [**postPauseStoreEventResult**](docs/Api/StorefrontEndpointsApi.md#postpausestoreeventresult) | **POST** /v1/storefront/pause | Notify the result of a pause request event
*StorefrontEndpointsApi* | [**postStoreAvailabilityChange**](docs/Api/StorefrontEndpointsApi.md#poststoreavailabilitychange) | **POST** /v1/storefront/availability | Notify about store availability change
*StorefrontEndpointsApi* | [**postStoreHoursConfigurationChange**](docs/Api/StorefrontEndpointsApi.md#poststorehoursconfigurationchange) | **POST** /v1/storefront/hours | Notify about store hours configuration change
*StorefrontEndpointsApi* | [**postUnpauseStoreEventResult**](docs/Api/StorefrontEndpointsApi.md#postunpausestoreeventresult) | **POST** /v1/storefront/unpause | Notify the result of an unpause request event
*StoresEndpointsApi* | [**updateStoreStatusEndpoint**](docs/Api/StoresEndpointsApi.md#updatestorestatusendpoint) | **PUT** /v1/stores/status | Update Store Status
*StoresEndpointsApi* | [**upsertStorelinkEventResultEndpoint**](docs/Api/StoresEndpointsApi.md#upsertstorelinkeventresultendpoint) | **POST** /v1/stores | Complete Store Onboarding

## Models

- [AcceptDeliveryCallbackRequest](docs/Model/AcceptDeliveryCallbackRequest.md)
- [AcceptDeliveryEvent](docs/Model/AcceptDeliveryEvent.md)
- [AcceptDeliveryRequest](docs/Model/AcceptDeliveryRequest.md)
- [AdditionalCharge](docs/Model/AdditionalCharge.md)
- [Address](docs/Model/Address.md)
- [AllergenClassification](docs/Model/AllergenClassification.md)
- [BulkUpdateItemStatus](docs/Model/BulkUpdateItemStatus.md)
- [CancelDeliveryCallbackRequest](docs/Model/CancelDeliveryCallbackRequest.md)
- [CancelDeliveryEvent](docs/Model/CancelDeliveryEvent.md)
- [CancelDeliveryResponse](docs/Model/CancelDeliveryResponse.md)
- [CaptchaRequest](docs/Model/CaptchaRequest.md)
- [CaptchaSolution](docs/Model/CaptchaSolution.md)
- [Category](docs/Model/Category.md)
- [CompositeFinanceLine](docs/Model/CompositeFinanceLine.md)
- [Courier](docs/Model/Courier.md)
- [CustomerPayment](docs/Model/CustomerPayment.md)
- [CustomerPaymentV2](docs/Model/CustomerPaymentV2.md)
- [CustomerTip](docs/Model/CustomerTip.md)
- [DeliveryCost](docs/Model/DeliveryCost.md)
- [DeliveryInfo](docs/Model/DeliveryInfo.md)
- [DeliveryQuote](docs/Model/DeliveryQuote.md)
- [DeliveryQuoteOptions](docs/Model/DeliveryQuoteOptions.md)
- [DeliveryStatus](docs/Model/DeliveryStatus.md)
- [DeliveryStatusUpdateEvent](docs/Model/DeliveryStatusUpdateEvent.md)
- [DeliveryStatusUpdateRequest](docs/Model/DeliveryStatusUpdateRequest.md)
- [DietaryClassification](docs/Model/DietaryClassification.md)
- [Distance](docs/Model/Distance.md)
- [EnergyKcal](docs/Model/EnergyKcal.md)
- [EntityPathOverrideRule](docs/Model/EntityPathOverrideRule.md)
- [EntityPathOverrideRuleAllOf](docs/Model/EntityPathOverrideRuleAllOf.md)
- [ErrorDetail](docs/Model/ErrorDetail.md)
- [ErrorMessage](docs/Model/ErrorMessage.md)
- [EventCallbackError](docs/Model/EventCallbackError.md)
- [EventNotification](docs/Model/EventNotification.md)
- [EventNotificationBase](docs/Model/EventNotificationBase.md)
- [EventNotificationNoPayload](docs/Model/EventNotificationNoPayload.md)
- [EventNotificationNoPayloadAllOf](docs/Model/EventNotificationNoPayloadAllOf.md)
- [EventResultMetadata](docs/Model/EventResultMetadata.md)
- [FinancialData](docs/Model/FinancialData.md)
- [FinancialTransaction](docs/Model/FinancialTransaction.md)
- [FulfilledCredential](docs/Model/FulfilledCredential.md)
- [FulfillmentInfo](docs/Model/FulfillmentInfo.md)
- [FulfillmentModeOverrideRule](docs/Model/FulfillmentModeOverrideRule.md)
- [FulfillmentModeOverrideRuleAllOf](docs/Model/FulfillmentModeOverrideRuleAllOf.md)
- [FulfillmentPathEntity](docs/Model/FulfillmentPathEntity.md)
- [GenerateReportRequest](docs/Model/GenerateReportRequest.md)
- [GenerateReportResponse](docs/Model/GenerateReportResponse.md)
- [HourInterval](docs/Model/HourInterval.md)
- [Hours](docs/Model/Hours.md)
- [HoursData](docs/Model/HoursData.md)
- [HydraToken](docs/Model/HydraToken.md)
- [IntentToCancelEvent](docs/Model/IntentToCancelEvent.md)
- [Item](docs/Model/Item.md)
- [Item2](docs/Model/Item2.md)
- [ItemModifier](docs/Model/ItemModifier.md)
- [ItemPriceOverride](docs/Model/ItemPriceOverride.md)
- [ItemSelector](docs/Model/ItemSelector.md)
- [ItemStatus](docs/Model/ItemStatus.md)
- [ItemTax](docs/Model/ItemTax.md)
- [ItemUpdateRequest](docs/Model/ItemUpdateRequest.md)
- [JobReference](docs/Model/JobReference.md)
- [Location](docs/Model/Location.md)
- [ManagerCancelOrderRequest](docs/Model/ManagerCancelOrderRequest.md)
- [ManagerConfirmOrderRequest](docs/Model/ManagerConfirmOrderRequest.md)
- [ManagerItemIssue](docs/Model/ManagerItemIssue.md)
- [ManagerItemIssues](docs/Model/ManagerItemIssues.md)
- [ManagerOrderCancelDetails](docs/Model/ManagerOrderCancelDetails.md)
- [ManagerOrderIssue](docs/Model/ManagerOrderIssue.md)
- [ManagerOrderIssues](docs/Model/ManagerOrderIssues.md)
- [Menu3PD](docs/Model/Menu3PD.md)
- [MenuAsynchronousJob](docs/Model/MenuAsynchronousJob.md)
- [MenuData](docs/Model/MenuData.md)
- [MenuItem3PD](docs/Model/MenuItem3PD.md)
- [MenuItemPOS](docs/Model/MenuItemPOS.md)
- [MenuPOS](docs/Model/MenuPOS.md)
- [MenuPublishEvent](docs/Model/MenuPublishEvent.md)
- [MenuPublishJobState](docs/Model/MenuPublishJobState.md)
- [MenuPublishRequest](docs/Model/MenuPublishRequest.md)
- [MenuPublishResponse](docs/Model/MenuPublishResponse.md)
- [MenuPublishResponseMenuPublishTargets](docs/Model/MenuPublishResponseMenuPublishTargets.md)
- [MenuPublishTarget](docs/Model/MenuPublishTarget.md)
- [MenuPublishTargets](docs/Model/MenuPublishTargets.md)
- [Menus](docs/Model/Menus.md)
- [MenusUpsertRequest](docs/Model/MenusUpsertRequest.md)
- [MetadataObject](docs/Model/MetadataObject.md)
- [MetadataObjectNoPayload](docs/Model/MetadataObjectNoPayload.md)
- [ModifierGroup](docs/Model/ModifierGroup.md)
- [ModifierGroupUpdateRequest](docs/Model/ModifierGroupUpdateRequest.md)
- [ModifierItem](docs/Model/ModifierItem.md)
- [Money](docs/Model/Money.md)
- [NutritionalInfo](docs/Model/NutritionalInfo.md)
- [OptionalStoreIdInMetadata](docs/Model/OptionalStoreIdInMetadata.md)
- [OptionalStoreIdInMetadataMetadata](docs/Model/OptionalStoreIdInMetadataMetadata.md)
- [Order](docs/Model/Order.md)
- [OrderCustomerPaymentUpdateRequest](docs/Model/OrderCustomerPaymentUpdateRequest.md)
- [OrderDeliveryInfoUpdateRequest](docs/Model/OrderDeliveryInfoUpdateRequest.md)
- [OrderExternalIdentifiers](docs/Model/OrderExternalIdentifiers.md)
- [OrderFeed](docs/Model/OrderFeed.md)
- [OrderIdentifier](docs/Model/OrderIdentifier.md)
- [OrderIdentifierFinance](docs/Model/OrderIdentifierFinance.md)
- [OrderItemInformation](docs/Model/OrderItemInformation.md)
- [OrderItemIssue](docs/Model/OrderItemIssue.md)
- [OrderReference](docs/Model/OrderReference.md)
- [OrderStatusEvent](docs/Model/OrderStatusEvent.md)
- [OrderStatusHistory](docs/Model/OrderStatusHistory.md)
- [OrderStatusHistoryOrderAcceptedInfo](docs/Model/OrderStatusHistoryOrderAcceptedInfo.md)
- [OrderStatusUpdateRequest](docs/Model/OrderStatusUpdateRequest.md)
- [OrderTotal](docs/Model/OrderTotal.md)
- [OrderTotalV2](docs/Model/OrderTotalV2.md)
- [OrderWithManagerInfo](docs/Model/OrderWithManagerInfo.md)
- [OrderWithPosInfo](docs/Model/OrderWithPosInfo.md)
- [OverrideRule](docs/Model/OverrideRule.md)
- [OverrideRule3PD](docs/Model/OverrideRule3PD.md)
- [POSCancelOrderRequest](docs/Model/POSCancelOrderRequest.md)
- [POSConfirmOrderRequest](docs/Model/POSConfirmOrderRequest.md)
- [POSFeedDelivery](docs/Model/POSFeedDelivery.md)
- [POSOrderStatusUpdateRequest](docs/Model/POSOrderStatusUpdateRequest.md)
- [POSReInjectionRequest](docs/Model/POSReInjectionRequest.md)
- [PauseStoreEventResult](docs/Model/PauseStoreEventResult.md)
- [Payout](docs/Model/Payout.md)
- [PayoutInfo](docs/Model/PayoutInfo.md)
- [PercentageValue](docs/Model/PercentageValue.md)
- [Person](docs/Model/Person.md)
- [PersonalIdentifiers](docs/Model/PersonalIdentifiers.md)
- [Photo](docs/Model/Photo.md)
- [PingEvent](docs/Model/PingEvent.md)
- [PongObject](docs/Model/PongObject.md)
- [PosItemIssue](docs/Model/PosItemIssue.md)
- [PosItemIssues](docs/Model/PosItemIssues.md)
- [PosOrderCancelDetails](docs/Model/PosOrderCancelDetails.md)
- [PosOrderIssue](docs/Model/PosOrderIssue.md)
- [PosOrderIssues](docs/Model/PosOrderIssues.md)
- [PriceOverride](docs/Model/PriceOverride.md)
- [RegularHours](docs/Model/RegularHours.md)
- [ReportGeneratedEvent](docs/Model/ReportGeneratedEvent.md)
- [RequestDeliveryQuoteCallbackRequest](docs/Model/RequestDeliveryQuoteCallbackRequest.md)
- [RequestDeliveryQuoteEvent](docs/Model/RequestDeliveryQuoteEvent.md)
- [RequiredAddress](docs/Model/RequiredAddress.md)
- [RequiredDeliveryInfo](docs/Model/RequiredDeliveryInfo.md)
- [RequiredEventResultMetadata](docs/Model/RequiredEventResultMetadata.md)
- [RequiredPerson](docs/Model/RequiredPerson.md)
- [SendMenuEventCallback](docs/Model/SendMenuEventCallback.md)
- [ServiceProviderCharge](docs/Model/ServiceProviderCharge.md)
- [Servings](docs/Model/Servings.md)
- [SimpleFinanceLine](docs/Model/SimpleFinanceLine.md)
- [SkuBarcode](docs/Model/SkuBarcode.md)
- [SkuDetails](docs/Model/SkuDetails.md)
- [SpecialHours](docs/Model/SpecialHours.md)
- [Store](docs/Model/Store.md)
- [StoreAvailabilityEventResult](docs/Model/StoreAvailabilityEventResult.md)
- [StoreHours](docs/Model/StoreHours.md)
- [StoreHoursConfiguration](docs/Model/StoreHoursConfiguration.md)
- [StoreHoursConfigurationEventResult](docs/Model/StoreHoursConfigurationEventResult.md)
- [StoreInfo](docs/Model/StoreInfo.md)
- [StorefrontRegularHours](docs/Model/StorefrontRegularHours.md)
- [StorefrontSpecialHours](docs/Model/StorefrontSpecialHours.md)
- [StorefrontTimeRange](docs/Model/StorefrontTimeRange.md)
- [SuspendItemsRequest](docs/Model/SuspendItemsRequest.md)
- [SuspensionStatus](docs/Model/SuspensionStatus.md)
- [TimeRange](docs/Model/TimeRange.md)
- [UnpauseStoreEventResult](docs/Model/UnpauseStoreEventResult.md)
- [UnsuspendItemsRequest](docs/Model/UnsuspendItemsRequest.md)
- [UpdateItemStatusEntry](docs/Model/UpdateItemStatusEntry.md)
- [UpdateStorelinkStatusRequest](docs/Model/UpdateStorelinkStatusRequest.md)
- [UpsertFullMenuEventCallback](docs/Model/UpsertFullMenuEventCallback.md)
- [UpsertHoursEvent](docs/Model/UpsertHoursEvent.md)
- [UpsertStorelinkEvent](docs/Model/UpsertStorelinkEvent.md)
- [UpsertStorelinkEventResultRequest](docs/Model/UpsertStorelinkEventResultRequest.md)
- [UpsertStorelinkEventResultRequestErrorMessage](docs/Model/UpsertStorelinkEventResultRequestErrorMessage.md)
- [VehicleInformation](docs/Model/VehicleInformation.md)
- [ViewCredential](docs/Model/ViewCredential.md)
- [ViewCredentialsArray](docs/Model/ViewCredentialsArray.md)

## Authorization

### OAuth2.0

- **Type**: `OAuth`
- **Flow**: `application`
- **Authorization URL**: ``
- **Scopes**: 
    - **menus.publish**: Token has permission to notify the result of a publish menus operation for a given store.
    - **menus.get_current**: Token has permission to send the current state of a menu, after being requested by a webhook event.
    - **menus.upsert_hours**: Token has permission to notify the receiving of the upsert hours menu event, after being requested by a webhook event.
    - **menus.pos_publish**: Token has permission to read available integration targets and to publish complete menus for selected integration targets.
    - **menus.async_job.read**: Token has permission to read the status of a menu upsert job.
    - **menus.entity_suspension**: Token has permission to notify the result of a menu entity availability update, after being requested by a webhook event.
    - **menus.read**: Token has permission to read the current menus for a given store.
    - **menus.upsert**: Token has permission to create/update menus for a given store.
    - **orders.customer_payment_update**: Token has permission to update customer’s payment information for a previously created order for a given store.
    - **orders.delivery_info_update**: Token has permission to update delivery information for a previously created order.
    - **orders.status_update**: Token has permission to update the order status for a previously created order.
    - **orders.create**: Token has permission to create new order for a given store.
    - **orders.update**: Token has permission to create and update new orders for a given store.
    - **ping**: Token has permission to ping the system.
    - **reports.generate_report**: Token has permission to request reports for a given store and period of time.
    - **storefront.store_pause_unpause**: Token has permission to notify the result of a pause/unpause operation, after being requested by a webhook event.
    - **storefront.store_availability**: Token has permission to send the current state of store.
    - **storefront.store_hours_configuration**: Token has permission to send the current store hours configuration.
    - **delivery.provider**: Token has permission to send the delivery operation result.
    - **callback.error.write**: Token has permission to send failed webhook event results.
    - **stores.manage**: Allow the use of stores' endpoints and webhooks.

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `v1`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
