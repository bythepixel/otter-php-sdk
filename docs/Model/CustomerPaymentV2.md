# # CustomerPaymentV2

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**customer_payment_due** | **float** | The portion of the overall order cost that will be collected when the order is delivered, or when picked up by the customer at the store. This field should not be set if the order was pre-paid. | [optional]
**customer_prepayment** | **float** | The portion of the overall order cost that was paid upfront by the customer (online payment), with the remaining portion in the customerPaymentDue. In most cases the order value will be covered entirely by prepayment or entirely by payment_due. But in some cases mixing is allowed. | [optional]
**customer_amount_to_return** | **float** | Change (cash back) to be returned to the customer by the courier or store when the order has payment due value.   Scenario:  1. Customer places an order for $7.50.  2. In the service app, after selecting Cash as payment type, the customer is presented with an additional field to indicate that order will be paid with a single $20 bill.  3. When the order is delivered, the courier should have $12.50 in cash on hand to complete the transaction. | [optional]
**payment_due_to_restaurant** | **float** | The portion of the overall order cost that was received directly by restaurant/store when the order is delivered or picked up. Should be used when customerPaymentDue is set. If payment due is entirely received by the store, customerPaymentDue and paymentDueToRestaurant will have the same value. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
