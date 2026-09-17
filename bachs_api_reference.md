# Bachs.io API Reference

> Comprehensive API reference generated from the official Bachs.io OpenAPI specification and documentation pages.

**Official sources:** [Bachs.io](https://bachs.io), [API overview](https://docs.bachs.io/api-reference/overview), [OpenAPI specification](https://docs.bachs.io/docs/openapi/openapi.json).

> **Scope note.** This reference covers every operation in the official OpenAPI specification, including methods, URLs, parameters, schemas, JSON examples, response codes, error references, and generated cURL examples. Documentation-only guides and changelog pages are listed in the source index where relevant.

## Table of contents

- [Payments](#payments)
- [Refunds](#refunds)
- [Disputes](#disputes)
- [Balances](#balances)
- [Conversions](#conversions)
- [Payouts](#payouts)
- [Webhooks](#webhooks)
- [Authentication](#authentication)
- [Customers](#customers)
- [Products](#products)
- [Product Groups](#product-groups)
- [Media](#media)
- [Checkouts](#checkouts)
- [Subscriptions](#subscriptions)
- [Customer sessions](#customer-sessions)
- [Accounts](#accounts)
- [Transfers](#transfers)
- [Platform Fees](#platform-fees)
- [Shared conventions](#shared-conventions)
- [Error reference](#error-reference)
- [Source index](#source-index)

## Payments

### List payment methods

**Method:** `GET`  
**URL:** `/v1/payment-methods`  
**Operation ID:** `listPaymentMethods`  

Get all available payment methods and their supported currencies. Use this to determine which payment options to show customers.

**Authentication:** None

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payment-methods" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "payment_methods": [
    {
      "id": "BANK_TRANSFER",
      "display_name": "Bank Transfer",
      "icon": "bank",
      "description": "Pay via bank transfer",
      "type": "fiat",
      "enabled_by_default": true,
      "currencies": [
        "NGN",
        "USD"
      ]
    },
    {
      "id": "CRYPTO",
      "display_name": "Cryptocurrency",
      "icon": "crypto",
      "description": "Pay with supported crypto assets",
      "type": "crypto",
      "enabled_by_default": true,
      "currencies": [
        "USDT_TRC20",
        "USDT_BEP20"
      ]
    }
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List supported currencies

**Method:** `GET`  
**URL:** `/v1/currencies/supported`  
**Operation ID:** `listSupportedCurrencies`  

Get all supported fiat and cryptocurrency codes. Use this to validate currency selections and display currency options to users.

**Authentication:** None

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/currencies/supported" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "fiat": [
    "USD",
    "NGN",
    "GHS",
    "KES",
    "ZAR"
  ],
  "crypto": [
    "USDT_TRC20",
    "USDT_ERC20",
    "BTC"
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List payment rails

**Method:** `GET`  
**URL:** `/v1/payment-methods/rails`  
**Operation ID:** `listPaymentRails`  

Get available payment rails for a specific payment method and currency combination. Use this to determine which payment rails are available before creating a quote. The 'id' field from the response should be used as the 'payment_rail' parameter when creating quotes.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `payment_method` | `query` | Yes | `string` | Payment method to get rails for |
| `currency` | `query` | Yes | `string` | Currency code (e.g., 'NGN', 'USD', 'GHS', 'USDT_TRC20') |
| `country_code` | `query` | No | `string` | Optional ISO country code (e.g., 'NG', 'GH') to filter rails by country |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payment-methods/rails?payment_method=&currency=&country_code=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payment rails retrieved

**application/json example:**

```json
{
  "payment_method": "BANK_TRANSFER",
  "currency": "NGN",
  "country_code": "NG",
  "rails": [
    {
      "id": "bank_transfer_ng",
      "name": "Bank Transfer Nigeria",
      "active": true
    }
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List payout supported currencies

**Method:** `GET`  
**URL:** `/v1/currencies/payout-supported`  
**Operation ID:** `listPayoutSupportedCurrencies`  

Get all currencies that support payouts/withdrawals, organized by fiat and cryptocurrency types.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/currencies/payout-supported" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payout supported currencies retrieved

**application/json example:**

```json
{
  "fiat": [
    "NGN",
    "USD",
    "GHS"
  ],
  "crypto": [
    "USDT_TRC20",
    "USDT_ERC20"
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get Charge Status

**Method:** `GET`  
**URL:** `/v1/payments/charges/{charge_id}`  
**Operation ID:** `getChargeStatus`  

Check the status of a payment charge. Use this to poll payment status or verify completion after webhook notifications.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `charge_id` | `path` | Yes | `string` | Charge ID from checkout or payment |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payments/charges/{charge_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Charge status retrieved

**application/json example:**

```json
{
  "charge_id": "ch_1a2b3c4d5e6f",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "customer_id": "cust_xyz789",
  "amount": "75000.00",
  "currency": "NGN",
  "settlement_currency": "NGN",
  "settlement_amount": "74250.00",
  "status": "succeeded",
  "metadata": {
    "order_id": "ORD-12345",
    "product_sku": "PREMIUM-ANNUAL"
  },
  "status_history": [
    {
      "status": "created",
      "occurred_at": "2026-01-24T14:30:00.000Z",
      "reason": null
    },
    {
      "status": "processing",
      "occurred_at": "2026-01-24T14:30:30.000Z",
      "reason": null
    },
    {
      "status": "succeeded",
      "occurred_at": "2026-01-24T14:35:00.000Z",
      "reason": "Payment received and confirmed"
    }
  ],
  "created_at": "2026-01-24T14:30:00.000Z",
  "updated_at": "2026-01-24T14:35:00.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List payments

**Method:** `GET`  
**URL:** `/v1/payments`  
**Operation ID:** `listPayments`  

Return a paginated list of payments your account has received, newest first. Filter with query parameters for reconciliation and monitoring. List items carry a summary of each payment; call Retrieve a payment for the full object including fees, products, and status history.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Page size. Defaults to 50. Maximum is 100. |
| `offset` | `query` | No | `integer` | Number of records to skip before returning results. |
| `status_filter` | `query` | No | `string` | Optional exact status filter for charge records. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payments?limit=&offset=&status_filter=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payments list retrieved

**application/json example:**

```json
{
  "items": [
    {
      "id": "chrg_1a2b3c4d5e",
      "reference": "order_9876",
      "status": "succeeded",
      "is_refundable": true,
      "amount": "10.00",
      "customer_name": "Jane Doe",
      "customer_email": "customer@example.com",
      "amount_paid": "10.00",
      "amount_remaining": "0.00",
      "settlement_amount": "10.00",
      "fee": null,
      "vat": null,
      "currency": "USD",
      "settlement_currency": "USD",
      "meta": null,
      "transaction_date": "2026-04-27T12:00:00Z",
      "completed_at": "2026-04-27T12:00:05Z"
    }
  ],
  "pagination": {
    "next_cursor": null,
    "prev_cursor": null,
    "has_more": false,
    "limit": 50,
    "offset": 0,
    "returned": 1,
    "total": 1
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Retrieve a payment

**Method:** `GET`  
**URL:** `/v1/payments/{payment_id}`  
**Operation ID:** `getPaymentDetail`  

Retrieve a single payment by its charge ID, with the full object: amount, status, the customer, fees, the products paid for, refunds, and status history.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `payment_id` | `path` | Yes | `string` | Charge ID of the payment. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payments/{payment_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payment retrieved

**application/json example:**

```json
{
  "reference": "ord_12903",
  "payment_id": "ch_1a2b3c4d5e6f",
  "checkout_id": "chk_1M2N3o4P5q6R7s8T",
  "status": "succeeded",
  "is_refundable": true,
  "amount": "75000.00",
  "amount_paid": "75000.00",
  "amount_remaining": "0.00",
  "currency": "NGN",
  "fee_usd": "0.59",
  "merchant_bears_cost": false,
  "platform_fee": null,
  "fee_paid_by": "merchant",
  "payment_method": "NGN_BANK_TRANSFER",
  "channel": "api",
  "narration": "Order payment ORD-12903",
  "meta": {
    "order_id": "ORD-12903"
  },
  "message": "Successful",
  "customer": {
    "name": "Jane Doe",
    "email": "jane@example.com"
  },
  "created_at": "2026-02-22T12:00:00.000Z",
  "updated_at": "2026-02-22T12:01:30.000Z",
  "completed_at": "2026-02-22T12:01:30.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Refunds

### Create a refund

**Method:** `POST`  
**URL:** `/v1/refunds`  
**Operation ID:** `createRefund`  

Create a refund for a completed payment. Only one refund can be created per charge.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "charge_id": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "reference": "RF-20260713-0042",
  "amount": "29.00",
  "fee_bearer": "org",
  "reason": "Customer requested cancellation",
  "idempotency_key": "RF-20260713-0042"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/refunds" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"charge_id": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f", "reference": "RF-20260713-0042", "amount": "29.00", "fee_bearer": "org", "reason": "Customer requested cancellation", "idempotency_key": "RF-20260713-0042"}'
```

#### Responses

##### `201` — Success - Refund created

**application/json example:**

```json
{
  "refund_id": "b7f2c41a-9d38-4e6b-8c15-2a7d0e934f61",
  "charge_id": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "reference": "RF-20260713-0042",
  "status": "processing",
  "requested_amount": "29.00",
  "refunded_amount": null,
  "refund_fee_amount": "0.00",
  "fee_bearer": "org",
  "reason": "Customer requested cancellation",
  "created_at": "2026-07-13T14:20:00.000Z",
  "updated_at": "2026-07-13T14:20:00.000Z",
  "completed_at": null
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `409` — Conflict - Duplicate request detected (idempotency). This occurs when the same request is made multiple times with the same idempotency key. The original request's response is returned.

**application/json example:**

```json
{
  "detail": "Duplicate request detected",
  "error_code": "CONFLICT"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List refunds

**Method:** `GET`  
**URL:** `/v1/refunds`  
**Operation ID:** `listRefunds`  

Retrieve a paginated list of refunds for your account, ordered from most recent to oldest.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of refunds to return. Min 1, max 100. Default 50. |
| `offset` | `query` | No | `integer` | Number of refunds to skip before returning results. Default 0. |
| `status` | `query` | No | `string` | Return only refunds in this state. `processing`: the refund is on its way to the customer. `success`: the customer has been refunded. `failed`: the refund did not complete and the money stayed put. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/refunds?limit=&offset=&status=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Refunds listed

**application/json example:**

```json
{
  "total": 2,
  "items": [
    {
      "refund_id": "b7f2c41a-9d38-4e6b-8c15-2a7d0e934f61",
      "charge_id": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
      "reference": "RF-20260713-0042",
      "status": "success",
      "requested_amount": "29.00",
      "refunded_amount": "29.00",
      "refund_fee_amount": "0.00",
      "fee_bearer": "org",
      "reason": "Customer requested cancellation",
      "created_at": "2026-07-13T14:20:00.000Z",
      "updated_at": "2026-07-13T14:26:41.220Z",
      "completed_at": "2026-07-13T14:26:41.220Z"
    },
    {
      "refund_id": "5e91d7c3-84b0-4a26-9df1-6c027b3849ea",
      "charge_id": "ch_71c3f8e0a94b25d6c8f10e4a3b975d2c",
      "reference": "RF-20260711-0007",
      "status": "failed",
      "requested_amount": "75000.00",
      "refunded_amount": null,
      "refund_fee_amount": "0.00",
      "fee_bearer": "org",
      "reason": "Duplicate order",
      "created_at": "2026-07-11T16:02:11.870Z",
      "updated_at": "2026-07-11T16:04:58.310Z",
      "completed_at": "2026-07-11T16:04:58.310Z"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Retrieve a refund

**Method:** `GET`  
**URL:** `/v1/refunds/{refund_id}`  
**Operation ID:** `getRefund`  

Retrieve a single refund by its ID.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `refund_id` | `path` | Yes | `string` | The unique identifier for the refund. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/refunds/{refund_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Refund retrieved

**application/json example:**

```json
{
  "refund_id": "b7f2c41a-9d38-4e6b-8c15-2a7d0e934f61",
  "charge_id": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "reference": "RF-20260713-0042",
  "status": "success",
  "requested_amount": "29.00",
  "refunded_amount": "29.00",
  "refund_fee_amount": "0.00",
  "fee_bearer": "org",
  "reason": "Customer requested cancellation",
  "created_at": "2026-07-13T14:20:00.000Z",
  "updated_at": "2026-07-13T14:26:41.220Z",
  "completed_at": "2026-07-13T14:26:41.220Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Retrieve a refund by charge

**Method:** `GET`  
**URL:** `/v1/refunds/by-charge/{payment_id}`  
**Operation ID:** `getRefundByCharge`  

Retrieve the refund associated with a specific payment by `payment_id`.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `payment_id` | `path` | Yes | `string` | The ID of the payment whose refund you want to retrieve. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/refunds/by-charge/{payment_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Refund retrieved for charge

**application/json example:**

```json
{
  "refund_id": "3d0a86f5-1c47-4b92-8e6d-9f5b04c71a2e",
  "charge_id": "ch_2b7e5a9c1f04d63a8e5b1c9d7f602a34",
  "reference": "RF-20260712-0018",
  "status": "success",
  "requested_amount": "12.50",
  "refunded_amount": "12.50",
  "refund_fee_amount": "0.00",
  "fee_bearer": "customer",
  "reason": null,
  "created_at": "2026-07-12T09:14:05.100Z",
  "updated_at": "2026-07-12T09:19:37.640Z",
  "completed_at": "2026-07-12T09:19:37.640Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Disputes

### List Disputes

**Method:** `GET`  
**URL:** `/v1/disputes`  
**Operation ID:** `listDisputes`  

Retrieve a paginated list of disputes for your account. Results are returned with the most recently created disputes first.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of disputes to return. Minimum 1 and maximum 100. |
| `offset` | `query` | No | `integer` | Number of disputes to skip before returning results. |
| `status` | `query` | No | `string` | Filter disputes by status. |
| `from_date` | `query` | No | `string` | Return disputes created at or after this timestamp (ISO 8601). |
| `to_date` | `query` | No | `string` | Return disputes created at or before this timestamp (ISO 8601). |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/disputes?limit=&offset=&status=&from_date=&to_date=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Disputes retrieved successfully.

**application/json example:**

```json
{
  "total": 1,
  "items": [
    {
      "dispute_id": "dsp_3e7b1c9a2f48",
      "charge_id": "ch_8f3a1c9b4e72",
      "amount": "75.00",
      "currency": "USD",
      "status": "needs_response",
      "is_response_editable": true,
      "reason": "fraudulent",
      "response_deadline_at": "2026-03-23T23:59:59.000Z",
      "created_at": "2026-03-09T08:00:00.000Z",
      "updated_at": "2026-03-09T08:00:00.000Z"
    }
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get Dispute

**Method:** `GET`  
**URL:** `/v1/disputes/{dispute_id}`  
**Operation ID:** `getDispute`  

Retrieve full details for a single dispute, including the current evidence draft and latest submission metadata.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `dispute_id` | `path` | Yes | `string` | Unique identifier for the dispute. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/disputes/{dispute_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Dispute retrieved successfully.

**application/json example:**

```json
{
  "dispute_id": "dsp_3e7b1c9a2f48",
  "charge_id": "ch_8f3a1c9b4e72",
  "amount": "75.00",
  "currency": "USD",
  "status": "under_review",
  "is_response_editable": false,
  "reason": "fraudulent",
  "response_deadline_at": "2026-03-23T23:59:59.000Z",
  "evidence": {
    "customer_name": "Amara Osei",
    "customer_email_address": "customer@example.com",
    "product_description": "Annual SaaS subscription, plan ID PLAN-PRO-001",
    "service_date": "2026-03-01",
    "notes": "Customer confirmed delivery via email on March 5.",
    "customer_communication_attachment_id": "upl_9f2c7b3d1e45"
  },
  "latest_submission": {
    "submission_id": "dse_a1b2c3d4e5f6",
    "status": "submitted",
    "trigger_source": "merchant_submit",
    "submitted_at": "2026-03-10T09:15:00.000Z",
    "failed_at": null,
    "attempt_sequence": 1
  },
  "created_at": "2026-03-09T08:00:00.000Z",
  "updated_at": "2026-03-10T09:15:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Upload Dispute Document

**Method:** `POST`  
**URL:** `/v1/disputes/uploads`  
**Operation ID:** `uploadDisputeDocument`  

Upload a supporting document for a dispute and receive a document identifier for evidence submission.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `multipart/form-data`

```json
{}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/disputes/uploads" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Document uploaded successfully.

**application/json example:**

```json
{
  "document_id": "upl_9f2c7b3d1e45",
  "file_name": "email-screenshot.pdf",
  "mime_type": "application/pdf",
  "file_size_bytes": 204800,
  "uploaded_at": "2026-03-09T10:00:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Update Dispute Evidence

**Method:** `PATCH`  
**URL:** `/v1/disputes/{dispute_id}/evidence`  
**Operation ID:** `updateDisputeEvidence`  

Save or update dispute evidence fields before final submission. Evidence can be updated iteratively while the dispute remains editable.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `dispute_id` | `path` | Yes | `string` | Unique identifier for the dispute. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "customer_name": "Amara Osei",
  "customer_email_address": "customer@example.com",
  "product_description": "Annual SaaS subscription, plan ID PLAN-PRO-001",
  "service_date": "2026-03-01",
  "notes": "Customer confirmed delivery via email on March 5.",
  "customer_communication_attachment_id": "upl_9f2c7b3d1e45"
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/disputes/{dispute_id}/evidence" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"customer_name": "Amara Osei", "customer_email_address": "customer@example.com", "product_description": "Annual SaaS subscription, plan ID PLAN-PRO-001", "service_date": "2026-03-01", "notes": "Customer confirmed delivery via email on March 5.", "customer_communication_attachment_id": "upl_9f2c7b3d1e45"}'
```

#### Responses

##### `200` — Evidence updated successfully.

**application/json example:**

```json
{
  "dispute_id": "dsp_3e7b1c9a2f48",
  "status": "needs_response",
  "is_response_editable": true,
  "evidence_updated_at": "2026-03-09T11:30:00.000Z"
}
```

##### `409` — Conflict - Duplicate request detected (idempotency). This occurs when the same request is made multiple times with the same idempotency key. The original request's response is returned.

**application/json example:**

```json
{
  "detail": "Duplicate request detected",
  "error_code": "CONFLICT"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Submit Dispute

**Method:** `POST`  
**URL:** `/v1/disputes/{dispute_id}/submit`  
**Operation ID:** `submitDispute`  

Submit saved dispute evidence for network review. This action is irreversible and locks further evidence edits.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `dispute_id` | `path` | Yes | `string` | Unique identifier for the dispute. |

#### Request body

This endpoint does not require a request body. Submit all dispute evidence beforehand via the evidence update endpoint.

**Content-Type:** `application/json`

```json
{}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/disputes/{dispute_id}/submit" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{}'
```

#### Responses

##### `200` — Dispute evidence submitted successfully.

**application/json example:**

```json
{
  "dispute_id": "dsp_3e7b1c9a2f48",
  "status": "under_review",
  "is_response_editable": false,
  "submission": {
    "submission_id": "dse_a1b2c3d4e5f6",
    "submission_status": "submitted",
    "trigger_source": "merchant_submit",
    "submitted_at": "2026-03-10T09:15:00.000Z"
  }
}
```

##### `409` — Conflict - Duplicate request detected (idempotency). This occurs when the same request is made multiple times with the same idempotency key. The original request's response is returned.

**application/json example:**

```json
{
  "detail": "Duplicate request detected",
  "error_code": "CONFLICT"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Balances

### Retrieve balances

**Method:** `GET`  
**URL:** `/v1/balances`  
**Operation ID:** `getBalances`  

Return account balance buckets by currency, including available, locked, and pending amounts, plus a consolidated USD total.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/balances" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Account balances retrieved

**application/json example:**

```json
{
  "account_id": "acct_7KpQ2mNv4XbR9dLc",
  "balances": [
    {
      "currency": "NGN",
      "available_balance": "58700.00",
      "pending_balance": "0.00"
    },
    {
      "currency": "USD",
      "available_balance": "95178.20",
      "pending_balance": "0.00"
    }
  ],
  "total_balance_usd": "95221.29",
  "pending_settlements_by_day": []
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get payout schedule

**Method:** `GET`  
**URL:** `/v1/balance_settings`  
**Operation ID:** `getPayoutSchedule`  

Read the payout schedule for your account, or for a connected account named by `X-Account-Id`. Its own resource rather than a block on the account object, so a platform can read timing without pulling the whole account.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `X-Account-Id` | `header` | No | `string` | Read the schedule of a connected account you own instead of your own. Same resolution every other API-key route uses: the account must be yours or one you own, or the request 404s. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/balance_settings" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The account's payout schedule, keyed by currency. A currency with no schedule is absent rather than present and empty.

**application/json example:**

```json
{
  "schedule_by_currency": {
    "NGN": {
      "currency": "NGN",
      "payout_currency": "NGN",
      "interval": "weekly",
      "weekly_payout_days": [
        "monday",
        "thursday"
      ],
      "monthly_payout_days": null,
      "anchor_hour_utc": 9,
      "minimum_amount": "5000.00",
      "next_run_at": "2026-08-13T09:00:00.000Z",
      "last_run_at": null,
      "last_withdrawal_id": null,
      "disabled_reason": null
    }
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Update payout schedule

**Method:** `POST`  
**URL:** `/v1/balance_settings`  
**Operation ID:** `updatePayoutSchedule`  

Set the payout schedule for your account, or for a connected account named by `X-Account-Id`. A currency you leave out of `schedule_by_currency` keeps the schedule it has; a currency you name is replaced in full. See [Payout Schedules](/guides/payouts/payout-schedules).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `X-Account-Id` | `header` | No | `string` | Set the schedule of a connected account you own instead of your own. Same resolution every other API-key route uses: the account must be yours or one you own, or the request 404s. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "schedule_by_currency": {
    "NGN": {
      "interval": "weekly",
      "weekly_payout_days": [
        "monday",
        "thursday"
      ],
      "anchor_hour_utc": 9,
      "minimum_amount": "5000.00"
    }
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/balance_settings" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"schedule_by_currency": {"NGN": {"interval": "weekly", "weekly_payout_days": ["monday", "thursday"], "anchor_hour_utc": 9, "minimum_amount": "5000.00"}}}'
```

#### Responses

##### `200` — The account's payout schedule after the write.

**application/json example:**

```json
{
  "schedule_by_currency": {
    "NGN": {
      "currency": "NGN",
      "payout_currency": "NGN",
      "interval": "weekly",
      "weekly_payout_days": [
        "monday",
        "thursday"
      ],
      "monthly_payout_days": null,
      "anchor_hour_utc": 9,
      "minimum_amount": "5000.00",
      "next_run_at": "2026-08-13T09:00:00.000Z",
      "last_run_at": null,
      "last_withdrawal_id": null,
      "disabled_reason": null
    }
  }
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Conversions

### Create Conversion Quote

**Method:** `POST`  
**URL:** `/v1/conversions/quotes`  
**Operation ID:** `createConversionQuote`  

Create a quote for converting between settlement currencies (USD <-> NGN).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "from_currency": "USD",
  "to_currency": "NGN",
  "amount": "1000.00"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/conversions/quotes" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"from_currency": "USD", "to_currency": "NGN", "amount": "1000.00"}'
```

#### Responses

##### `201` — Success - Conversion quote generated

**application/json example:**

```json
{
  "quote_id": "cqt_1a2b3c4d5e6f",
  "from_currency": "USD",
  "to_currency": "NGN",
  "from_amount": "1000.00",
  "to_amount": "1500000.00",
  "exchange_rate": "1500.00",
  "expires_at": "2026-01-24T14:31:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List Conversions

**Method:** `GET`  
**URL:** `/v1/conversions`  
**Operation ID:** `listConversions`  

List conversion records for your account with offset pagination.

Common errors:
- `400 VALIDATION_ERROR`: One or more query parameters are invalid. Resolution: correct query values and retry.
- `401 UNAUTHORIZED`: API key is missing, invalid, or revoked. Resolution: use a valid API key in the `Authorization` header.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` |  |
| `offset` | `query` | No | `integer` |  |
| `from_currency` | `query` | No | `string` |  |
| `to_currency` | `query` | No | `string` |  |
| `status` | `query` | No | `string` |  |
| `start_date` | `query` | No | `string` |  |
| `end_date` | `query` | No | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/conversions?limit=&offset=&from_currency=&to_currency=&status=&start_date=&end_date=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Conversions retrieved

**application/json example:**

```json
{
  "total": 2,
  "limit": 20,
  "offset": 0,
  "items": [
    {
      "conversion_id": "cvt_1a2b3c4d5e6f",
      "status": "completed",
      "from_currency": "USD",
      "to_currency": "NGN",
      "from_amount": "1000.00",
      "to_amount": "1500000.00",
      "exchange_rate": "1500.00",
      "created_at": "2026-01-24T14:30:00.000Z"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Execute Conversion

**Method:** `POST`  
**URL:** `/v1/conversions`  
**Operation ID:** `executeConversion`  

Execute a conversion between settlement currencies (USD <-> NGN) using a valid quote_id.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "from_currency": "USD",
  "to_currency": "NGN",
  "amount": "1000.00",
  "quote_id": "cqt_1a2b3c4d5e6f"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/conversions" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"from_currency": "USD", "to_currency": "NGN", "amount": "1000.00", "quote_id": "cqt_1a2b3c4d5e6f"}'
```

#### Responses

##### `201` — Success - Conversion executed

**application/json example:**

```json
{
  "conversion_id": "cvt_1a2b3c4d5e6f",
  "status": "completed",
  "from_currency": "USD",
  "to_currency": "NGN",
  "from_amount": "1000.00",
  "to_amount": "1500000.00",
  "exchange_rate": "1500.00",
  "created_at": "2026-01-24T14:30:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get Conversion

**Method:** `GET`  
**URL:** `/v1/conversions/{conversion_id}`  
**Operation ID:** `getConversion`  

Fetch a single conversion by ID.

Common errors:
- `401 UNAUTHORIZED`: API key is missing, invalid, or revoked. Resolution: use a valid API key in the `Authorization` header.
- `404 NOT_FOUND`: No conversion exists for this `conversion_id`. Resolution: verify the conversion ID and retry.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `conversion_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/conversions/{conversion_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Conversion retrieved

**application/json example:**

```json
{
  "conversion_id": "cvt_1a2b3c4d5e6f",
  "status": "completed",
  "from_currency": "USD",
  "to_currency": "NGN",
  "from_amount": "1000.00",
  "to_amount": "1500000.00",
  "exchange_rate": "1500.00",
  "created_at": "2026-01-24T14:30:00.000Z",
  "quote_id": "cqt_1a2b3c4d5e6f",
  "metadata": null
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Payouts

### Create Payout Quote

**Method:** `POST`  
**URL:** `/v1/payouts/quotes`  
**Operation ID:** `createPayoutQuote`  

Lock an exchange rate for a payout that delivers a different currency from the balance it debits. Returns a `quote_id` to pass to Create Payout in place of `amount`, along with the rate and the amount the destination receives. Same-currency payouts need no quote. The quote carries no fee: the payout fee is charged on top of the amount when the payout is created.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "from_currency": "USD",
  "to_currency": "NGN",
  "amount": "100.00"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/payouts/quotes" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"from_currency": "USD", "to_currency": "NGN", "amount": "100.00"}'
```

#### Responses

##### `201` — Success - Payout quote generated

**application/json example:**

```json
{
  "quote_id": "pqt_1a2b3c4d5e6f",
  "from_currency": "USD",
  "to_currency": "NGN",
  "from_amount": "100.00",
  "to_amount": "148500.00",
  "exchange_rate": "1500.00",
  "expires_at": "2026-02-22T12:31:00+00:00"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List Payout Destinations

**Method:** `GET`  
**URL:** `/v1/payouts/destinations`  
**Operation ID:** `listPayoutDestinations`  

List all configured payout destinations (bank accounts, mobile money, crypto wallets) for your account.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `currency` | `query` | No | `string` | Filter by destination currency code. |
| `status` | `query` | No | `string` | Filter by admin review status: `pending_review`, `approved`, or `rejected`. |
| `limit` | `query` | No | `integer` | Number of records to return. |
| `offset` | `query` | No | `integer` | Number of records to skip. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payouts/destinations?currency=&status=&limit=&offset=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payout destinations list retrieved

**application/json example:**

```json
{
  "destinations": [
    {
      "id": "pd_7Kq2mNv4XbR9dLc0",
      "name": "My GTBank Savings",
      "type": "bank_account",
      "currency": "NGN",
      "status": "approved",
      "status_reason": null,
      "is_usable": true,
      "is_default": false,
      "account_number": "0123456789",
      "account_name": "JOHN DOE",
      "bank_code": "058",
      "bank_name": "Guaranty Trust Bank",
      "phone_number": null,
      "mobile_provider": null,
      "wallet_address": null,
      "network": null,
      "reviewed_at": "2026-01-24T15:00:00.000Z",
      "created_at": "2026-01-24T14:30:00.000Z",
      "updated_at": "2026-01-24T14:30:00.000Z"
    }
  ],
  "total": 1,
  "limit": 20,
  "offset": 0
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Create Payout Destination

**Method:** `POST`  
**URL:** `/v1/payouts/destinations`  
**Operation ID:** `createPayoutDestination`  

Add a new payout destination (bank account, mobile money, or crypto wallet) where you can withdraw funds.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "My GTBank Savings",
  "currency": "NGN",
  "label": "Treasury NGN Account",
  "account_number": "0123456789",
  "bank_code": "058"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/payouts/destinations" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "My GTBank Savings", "currency": "NGN", "label": "Treasury NGN Account", "account_number": "0123456789", "bank_code": "058"}'
```

#### Responses

##### `201` — Success

**application/json example:**

```json
{
  "id": "pd_7Kq2mNv4XbR9dLc0",
  "name": "My GTBank Savings",
  "type": "bank_account",
  "currency": "NGN",
  "status": "pending_review",
  "status_reason": null,
  "is_usable": false,
  "is_default": false,
  "account_number": "0123456789",
  "account_name": "JOHN DOE",
  "bank_code": "058",
  "bank_name": "Guaranty Trust Bank",
  "phone_number": null,
  "mobile_provider": null,
  "wallet_address": null,
  "network": null,
  "reviewed_at": null,
  "created_at": "2026-01-24T14:30:00.000Z",
  "updated_at": "2026-01-24T14:30:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get Payout Destination

**Method:** `GET`  
**URL:** `/v1/payouts/destinations/{destination_id}`  
**Operation ID:** `getPayoutDestination`  

Retrieve a single payout destination by ID.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `destination_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payouts/destinations/{destination_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "id": "pd_7Kq2mNv4XbR9dLc0",
  "name": "Treasury NGN Account",
  "type": "bank_account",
  "currency": "NGN",
  "status": "pending_review",
  "status_reason": null,
  "is_usable": false,
  "is_default": false,
  "account_number": "0123456789",
  "account_name": "JOHN DOE",
  "bank_code": "058",
  "bank_name": "Guaranty Trust Bank",
  "phone_number": null,
  "mobile_provider": null,
  "wallet_address": null,
  "network": null,
  "reviewed_at": null,
  "created_at": "2026-01-24T14:30:00.000Z",
  "updated_at": "2026-02-22T14:30:00.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Update Payout Destination

**Method:** `PATCH`  
**URL:** `/v1/payouts/destinations/{destination_id}`  
**Operation ID:** `updatePayoutDestination`  

Update a destination: rename it, (de)promote it as a payout schedule's default, or restate where money lands.

`name` and `is_default` alone are safe: neither touches review status, since the default can only ever be one of your own approved destinations. Sending any routing detail (currency, type, account, wallet or phone) restates the destination in full, the same shape as `POST`; omitted routing fields fall back to what is already stored. Changing an account number, bank code, wallet, network, or phone number this way sends the destination back for review, because the approval it holds was granted for the details it is being asked to leave behind.

Common errors:
- `400 VALIDATION_ERROR`: neither `name` nor `is_default` sent, or an invalid payload for the destination type. Resolution: validate request fields and retry.
- `401 UNAUTHORIZED`: API key is missing, invalid, or revoked. Resolution: use a valid API key in the `Authorization` header.
- `404 NOT_FOUND`: `destination_id` was not found. Resolution: verify destination ID and retry.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `destination_id` | `path` | Yes | `string` |  |

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "Treasury NGN Account"
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/payouts/destinations/{destination_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Treasury NGN Account"}'
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "id": "pd_7Kq2mNv4XbR9dLc0",
  "name": "Treasury NGN Account",
  "type": "bank_account",
  "currency": "NGN",
  "status": "pending_review",
  "status_reason": null,
  "is_usable": false,
  "is_default": false,
  "account_number": "0123456789",
  "account_name": "JOHN DOE",
  "bank_code": "058",
  "bank_name": "Guaranty Trust Bank",
  "phone_number": null,
  "mobile_provider": null,
  "wallet_address": null,
  "network": null,
  "reviewed_at": null,
  "created_at": "2026-01-24T14:30:00.000Z",
  "updated_at": "2026-02-22T14:30:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Delete Payout Destination

**Method:** `DELETE`  
**URL:** `/v1/payouts/destinations/{destination_id}`  
**Operation ID:** `deletePayoutDestination`  

Delete a payout destination.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `destination_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X DELETE "https://sandbox-api.bachs.io/v1/payouts/destinations/{destination_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - destination deactivated

**application/json example:**

```json
{
  "id": "pd_7Kq2mNv4XbR9dLc0",
  "deleted": true
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### List Payouts

**Method:** `GET`  
**URL:** `/v1/payouts`  
**Operation ID:** `listPayouts`  

List payout withdrawals for your account.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of records to return. |
| `offset` | `query` | No | `integer` | Number of records to skip. |
| `status_filter` | `query` | No | `string` | Optional exact withdrawal status filter. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payouts?limit=&offset=&status_filter=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payout list retrieved

**application/json example:**

```json
{
  "total": 1,
  "items": [
    {
      "id": "pay_4Xr9dLc0mNv7Kq2B",
      "status": "processing",
      "amount": "5000.00",
      "currency": "NGN",
      "source_currency": "NGN",
      "fee": "100.00",
      "total_debited": "5100.00",
      "destination": "pd_7Kq2mNv4XbR9dLc0",
      "reference": "WD-20260222-001",
      "failure_reason": null,
      "created_at": "2026-02-22T12:00:00.000Z",
      "completed_at": null
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Create Payout

**Method:** `POST`  
**URL:** `/v1/payouts`  
**Operation ID:** `createPayout`  

Send money to a payout destination you have registered. `amount` is what the destination receives, and the fee is charged on top, so the balance must cover `total_debited`. Paying out in a different currency from the balance you are debiting omits `amount` and passes `quote_id` instead.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `Idempotency-Key` | `header` | No | `string` | Recommended. If the same key is retried with an identical request body, the cached response is returned rather than sending a second payout. Retrying the same key with a different body returns `409 IDEMPOTENCY_CONFLICT`. |
| `X-Account-Id` | `header` | No | `string` | Pay out on behalf of an account you own rather than your own account. The destination, balance, and payout are all scoped to that party. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "destination": "pd_7Kq2mNv4XbR9dLc0",
  "amount": "5000.00",
  "reference": "payout-2026-08-07-001"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/payouts" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"destination": "pd_7Kq2mNv4XbR9dLc0", "amount": "5000.00", "reference": "payout-2026-08-07-001"}'
```

#### Responses

##### `200` — Success - Payout created

**application/json example:**

```json
{
  "id": "pay_4Xr9dLc0mNv7Kq2B",
  "status": "pending",
  "amount": "5000.00",
  "currency": "NGN",
  "source_currency": "NGN",
  "fee": "100.00",
  "total_debited": "5100.00",
  "destination": "pd_7Kq2mNv4XbR9dLc0",
  "reference": "payout-2026-08-07-001",
  "failure_reason": null,
  "created_at": "2026-08-07T14:30:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `409` — Conflict - Duplicate request detected (idempotency). This occurs when the same request is made multiple times with the same idempotency key. The original request's response is returned.

**application/json example:**

```json
{
  "detail": "Duplicate request detected",
  "error_code": "CONFLICT"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get Payout

**Method:** `GET`  
**URL:** `/v1/payouts/{withdrawal_id}`  
**Operation ID:** `getPayout`  

Get a payout withdrawal by ID.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `withdrawal_id` | `path` | Yes | `string` | Withdrawal ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/payouts/{withdrawal_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Payout retrieved

**application/json example:**

```json
{
  "id": "pay_4Xr9dLc0mNv7Kq2B",
  "status": "processing",
  "amount": "5000.00",
  "currency": "NGN",
  "source_currency": "NGN",
  "fee": "100.00",
  "total_debited": "5100.00",
  "destination": "pd_7Kq2mNv4XbR9dLc0",
  "reference": "WD-20260222-001",
  "failure_reason": null,
  "created_at": "2026-02-22T12:00:00.000Z",
  "completed_at": null
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Webhooks

### Replay a webhook event

**Method:** `POST`  
**URL:** `/v1/webhooks/replay`  
**Operation ID:** `replayWebhookEvent`  

Replay a previously generated webhook event by creating a new outbound delivery attempt. Use this when your endpoint missed or rejected an earlier delivery and you need Bachs to send that event again.

Common errors:
- `400 BAD_REQUEST`: No supported lookup field was provided. Resolution: provide at least one of `event_id`, `charge_id`, or `reference`.
- `401 UNAUTHORIZED`: Authorization is missing, invalid, or revoked. Resolution: send a valid bearer credential.
- `404 NOT_FOUND`: No matching webhook event could be resolved for your lookup values. Resolution: verify IDs/references and retry.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "event_id": "evt_3ab4e0d5d27445cf8a52ab3d8cb8f0b1"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/webhooks/replay" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"event_id": "evt_3ab4e0d5d27445cf8a52ab3d8cb8f0b1"}'
```

#### Responses

##### `200` — Success - replay request accepted and a new delivery attempt was created.

**application/json example:**

```json
{
  "event_id": "evt_3ab4e0d5d27445cf8a52ab3d8cb8f0b1",
  "attempt_id": "wha_6f1e40f6bdf84c1980e1e1f6407f3f8a",
  "attempt_no": 3,
  "event_type": "collection.failed"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Create a webhook endpoint

**Method:** `POST`  
**URL:** `/v1/webhooks/endpoints`  
**Operation ID:** `createWebhookEndpoint`  

Register a URL to receive webhook events, and choose which events to subscribe to. The signing secret is returned once in the response. Requires the `webhooks:write` scope.

**Authentication:** None

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "Production events",
  "url": "https://api.example.com/webhooks/bachs",
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "account"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/webhooks/endpoints" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Production events", "url": "https://api.example.com/webhooks/bachs", "event_types": ["checkout.completed", "collection.succeeded", "payout.paid", "refund.paid"], "event_source": "account"}'
```

#### Responses

##### `201` — The created endpoint, including its signing secret.

**application/json example:**

```json
{
  "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42",
  "name": "Production events",
  "url": "https://api.example.com/webhooks/bachs",
  "enabled": true,
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "account",
  "created_at": "2026-03-09T10:00:00.000Z",
  "updated_at": "2026-03-09T10:00:00.000Z",
  "signing_secret": "whsec_62da9edb5b97b120f7d55e1e190118b0ec08fcace294dfaf211ec370b6d21f34"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `422` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### List webhook endpoints

**Method:** `GET`  
**URL:** `/v1/webhooks/endpoints`  
**Operation ID:** `listWebhookEndpoints`  

List all webhook endpoints for your account. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of endpoints to return per page. |
| `offset` | `query` | No | `integer` | Number of endpoints to skip before the page starts. |
| `cursor` | `query` | No | `string` | Cursor from a previous page's `pagination.next_cursor`. Takes precedence over `offset` when both are sent. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/endpoints?limit=&offset=&cursor=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Your webhook endpoints.

**application/json example:**

```json
[
  {
    "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42",
    "name": "Production events",
    "url": "https://api.example.com/webhooks/bachs",
    "enabled": true,
    "event_types": [
      "checkout.completed",
      "collection.succeeded",
      "payout.paid",
      "refund.paid"
    ],
    "event_source": "account",
    "created_at": "2026-03-09T10:00:00.000Z",
    "updated_at": "2026-03-09T10:00:00.000Z"
  },
  {
    "endpoint_id": "whe_e1eae19222ebc5e7e2b4270eaf6f4dec",
    "name": "Account monitor",
    "url": "https://api.example.com/webhooks/bachs/connected",
    "enabled": true,
    "event_types": [
      "account.updated",
      "capability.updated",
      "transfer.created"
    ],
    "event_source": "connect",
    "created_at": "2026-02-14T08:30:00.000Z",
    "updated_at": "2026-03-02T16:45:12.000Z"
  }
]
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Retrieve a webhook endpoint

**Method:** `GET`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}`  
**Operation ID:** `getWebhookEndpoint`  

Retrieve a single webhook endpoint by ID. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The endpoint.

**application/json example:**

```json
{
  "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42",
  "name": "Production events",
  "url": "https://api.example.com/webhooks/bachs",
  "enabled": true,
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "account",
  "created_at": "2026-03-09T10:00:00.000Z",
  "updated_at": "2026-03-09T10:00:00.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Update a webhook endpoint

**Method:** `PATCH`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}`  
**Operation ID:** `updateWebhookEndpoint`  

Update an endpoint's name, URL, or subscribed events. Only the fields you send are changed. Requires the `webhooks:write` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "Production events (v2 receiver)",
  "url": "https://api.example.com/webhooks/bachs/v2",
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "collection.failed",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "all"
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Production events (v2 receiver)", "url": "https://api.example.com/webhooks/bachs/v2", "event_types": ["checkout.completed", "collection.succeeded", "collection.failed", "payout.paid", "refund.paid"], "event_source": "all"}'
```

#### Responses

##### `200` — The updated endpoint.

**application/json example:**

```json
{
  "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42",
  "name": "Production events (v2 receiver)",
  "url": "https://api.example.com/webhooks/bachs/v2",
  "enabled": true,
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "collection.failed",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "all",
  "created_at": "2026-03-09T10:00:00.000Z",
  "updated_at": "2026-03-11T09:22:04.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `422` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Delete a webhook endpoint

**Method:** `DELETE`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}`  
**Operation ID:** `deleteWebhookEndpoint`  

Delete a webhook endpoint. It stops receiving events immediately. Requires the `webhooks:write` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |

#### cURL

```bash
curl -X DELETE "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The endpoint was deleted.

**application/json example:**

```json
{
  "status": "deleted",
  "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Retrieve an endpoint's signing secret

**Method:** `GET`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}/secret`  
**Operation ID:** `getWebhookEndpointSecret`  

Retrieve the current signing secret for an endpoint. Use it to verify the `X-Bachs-Signature` header on deliveries. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}/secret" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The endpoint and its signing secret.

**application/json example:**

```json
{
  "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42",
  "name": "Production events",
  "url": "https://api.example.com/webhooks/bachs",
  "enabled": true,
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "account",
  "created_at": "2026-03-09T10:00:00.000Z",
  "updated_at": "2026-03-09T10:00:00.000Z",
  "secret": "whsec_62da9edb5b97b120f7d55e1e190118b0ec08fcace294dfaf211ec370b6d21f34"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Rotate an endpoint's signing secret

**Method:** `POST`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}/rotate-secret`  
**Operation ID:** `rotateWebhookEndpointSecret`  

Generate a new signing secret for an endpoint. The old secret stops working immediately, so update your verification before rotating. Requires the `webhooks:write` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}/rotate-secret" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The endpoint with its secret rotated.

**application/json example:**

```json
{
  "endpoint_id": "whe_a1e823c073ab743ce5969ceef2db4d42",
  "name": "Production events",
  "url": "https://api.example.com/webhooks/bachs",
  "enabled": true,
  "event_types": [
    "checkout.completed",
    "collection.succeeded",
    "payout.paid",
    "refund.paid"
  ],
  "event_source": "account",
  "created_at": "2026-03-09T10:00:00.000Z",
  "updated_at": "2026-03-12T14:05:33.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Retrieve endpoint delivery metrics

**Method:** `GET`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}/metrics`  
**Operation ID:** `getWebhookEndpointMetrics`  

Retrieve delivery success and failure counts for an endpoint over a time range. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |
| `period` | `query` | No | `string` | Grouping period, e.g. `day`. |
| `date_from` | `query` | No | `string` | Start of the range (ISO 8601). |
| `date_to` | `query` | No | `string` | End of the range (ISO 8601). |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}/metrics?period=&date_from=&date_to=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Delivery metrics.

**application/json example:**

```json
{
  "total": "160",
  "period": "day",
  "data": [
    {
      "date": "2026-03-03",
      "success": 22,
      "failed": 0
    },
    {
      "date": "2026-03-04",
      "success": 19,
      "failed": 1
    },
    {
      "date": "2026-03-05",
      "success": 25,
      "failed": 0
    },
    {
      "date": "2026-03-06",
      "success": 18,
      "failed": 0
    },
    {
      "date": "2026-03-07",
      "success": 27,
      "failed": 2
    },
    {
      "date": "2026-03-08",
      "success": 21,
      "failed": 0
    },
    {
      "date": "2026-03-09",
      "success": 24,
      "failed": 1
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### List events for an endpoint

**Method:** `GET`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}/events`  
**Operation ID:** `listWebhookEndpointEvents`  

List the events delivered (or attempted) to a specific endpoint. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |
| `limit` | `query` | No | `integer` | Maximum results to return (1–100, default 50). |
| `offset` | `query` | No | `integer` | Number of results to skip. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}/events?limit=&offset=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Events for the endpoint.

**application/json example:**

```json
{
  "items": [
    {
      "event_id": "evt_5d50b401e3e47948235c374ae57b8807",
      "event_type": "customer.created",
      "entity_id": "cust_9ae63038729d2d6b793423bdbc27c19a",
      "attempts": 2,
      "success": 1,
      "failed": 1,
      "last_attempt_status": "succeeded",
      "last_attempt_http_status": 200,
      "last_attempt_error": null,
      "last_attempt_at": "2026-03-09T10:02:41.000Z"
    },
    {
      "event_id": "evt_2a960a1d977989742bbdceee5c7cc398",
      "event_type": "checkout.completed",
      "entity_id": "9d7c1f0b-4a52-4f0e-9d3b-6b8e2c11a4f7",
      "attempts": 1,
      "success": 0,
      "failed": 1,
      "last_attempt_status": "failed",
      "last_attempt_http_status": null,
      "last_attempt_error": "Connection timed out after 10s",
      "last_attempt_at": "2026-03-09T09:41:18.000Z"
    }
  ],
  "total": 2,
  "limit": 50,
  "offset": 0
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Retrieve an endpoint event

**Method:** `GET`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}/events/{event_id}`  
**Operation ID:** `getWebhookEndpointEvent`  

Retrieve one event's full payload and delivery attempts for a specific endpoint. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |
| `event_id` | `path` | Yes | `string` | The event's ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}/events/{event_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The event with its payload and attempts.

**application/json example:**

```json
{
  "event_id": "evt_5d50b401e3e47948235c374ae57b8807",
  "event_type": "customer.created",
  "entity_type": "customer",
  "entity_id": "cust_9ae63038729d2d6b793423bdbc27c19a",
  "created_at": "2026-03-09T10:00:00.000Z",
  "payload": {
    "id": "evt_5d50b401e3e47948235c374ae57b8807",
    "type": "customer.created",
    "created_at": "2026-03-09T10:00:00.000Z",
    "organization_id": "acct_MxIFSNnNbZ1N4jaP",
    "data": {
      "customer_id": "cust_9ae63038729d2d6b793423bdbc27c19a",
      "email": "ada@example.com",
      "name": "Ada Okafor",
      "phone_number": "+2348012345678",
      "metadata": {
        "signup_source": "web"
      },
      "billing_address": {
        "line1": "14 Marina Road",
        "line2": null,
        "city": "Lagos",
        "state": "Lagos",
        "postal_code": "101241",
        "country": "NG"
      },
      "created_at": "2026-03-09T10:00:00.000Z",
      "updated_at": "2026-03-09T10:00:00.000Z"
    }
  },
  "attempts": [
    {
      "attempt_id": "wha_8e42bc52310ceff8bed0ff7664efd4ed",
      "attempt_no": 2,
      "status": "succeeded",
      "callback_url": "https://api.example.com/webhooks/bachs",
      "http_status": 200,
      "response_snippet": "{\"received\":true}",
      "last_error": null,
      "created_at": "2026-03-09T10:02:41.000Z",
      "updated_at": "2026-03-09T10:02:41.000Z"
    },
    {
      "attempt_id": "wha_5566022efc62628d4098bb7ea1598837",
      "attempt_no": 1,
      "status": "failed",
      "callback_url": "https://api.example.com/webhooks/bachs",
      "http_status": 503,
      "response_snippet": "Service Unavailable",
      "last_error": "Endpoint returned HTTP 503",
      "created_at": "2026-03-09T10:00:02.000Z",
      "updated_at": "2026-03-09T10:00:12.000Z"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Resend an event to an endpoint

**Method:** `POST`  
**URL:** `/v1/webhooks/endpoints/{endpoint_id}/events/{event_id}/resend`  
**Operation ID:** `resendWebhookEvent`  

Re-deliver a past event to a specific endpoint. Requires the `webhooks:write` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `endpoint_id` | `path` | Yes | `string` | The webhook endpoint's ID. |
| `event_id` | `path` | Yes | `string` | The event's ID. |

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/webhooks/endpoints/{endpoint_id}/events/{event_id}/resend" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The resend was queued.

**application/json example:**

```json
{
  "status": "queued",
  "attempt_id": "wha_8e42bc52310ceff8bed0ff7664efd4ed"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### List webhook events

**Method:** `GET`  
**URL:** `/v1/webhooks/events`  
**Operation ID:** `listWebhookEvents`  

List all webhook events for your account, across every endpoint. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Maximum results to return (1–100, default 50). |
| `offset` | `query` | No | `integer` | Number of results to skip. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/events?limit=&offset=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Your webhook events.

**application/json example:**

```json
{
  "items": [
    {
      "event_id": "evt_5d50b401e3e47948235c374ae57b8807",
      "event_type": "customer.created",
      "entity_type": "customer",
      "entity_id": "cust_9ae63038729d2d6b793423bdbc27c19a",
      "created_at": "2026-03-09T10:00:00.000Z",
      "account": "acct_MxIFSNnNbZ1N4jaP",
      "attempts": 2,
      "success": 1,
      "failed": 1,
      "last_attempt_status": "succeeded",
      "last_attempt_http_status": 200,
      "last_attempt_error": null,
      "last_attempt_at": "2026-03-09T10:02:41.000Z"
    },
    {
      "event_id": "evt_2a960a1d977989742bbdceee5c7cc398",
      "event_type": "checkout.completed",
      "entity_type": "checkout",
      "entity_id": "9d7c1f0b-4a52-4f0e-9d3b-6b8e2c11a4f7",
      "created_at": "2026-03-09T09:41:07.000Z",
      "account": "acct_MxIFSNnNbZ1N4jaP",
      "attempts": 1,
      "success": 0,
      "failed": 1,
      "last_attempt_status": "failed",
      "last_attempt_http_status": null,
      "last_attempt_error": "Connection timed out after 10s",
      "last_attempt_at": "2026-03-09T09:41:18.000Z"
    }
  ],
  "total": 2,
  "limit": 50,
  "offset": 0
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Retrieve a webhook event

**Method:** `GET`  
**URL:** `/v1/webhooks/events/{event_id}`  
**Operation ID:** `getWebhookEvent`  

Retrieve a single event's full payload and delivery attempts. Requires the `webhooks:read` scope.

**Authentication:** None

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `event_id` | `path` | Yes | `string` | The event's ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/webhooks/events/{event_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The event with its payload and attempts.

**application/json example:**

```json
{
  "event_id": "evt_5d50b401e3e47948235c374ae57b8807",
  "event_type": "customer.created",
  "entity_type": "customer",
  "entity_id": "cust_9ae63038729d2d6b793423bdbc27c19a",
  "created_at": "2026-03-09T10:00:00.000Z",
  "payload": {
    "id": "evt_5d50b401e3e47948235c374ae57b8807",
    "type": "customer.created",
    "created_at": "2026-03-09T10:00:00.000Z",
    "organization_id": "acct_MxIFSNnNbZ1N4jaP",
    "data": {
      "customer_id": "cust_9ae63038729d2d6b793423bdbc27c19a",
      "email": "ada@example.com",
      "name": "Ada Okafor",
      "phone_number": "+2348012345678",
      "metadata": {
        "signup_source": "web"
      },
      "billing_address": {
        "line1": "14 Marina Road",
        "line2": null,
        "city": "Lagos",
        "state": "Lagos",
        "postal_code": "101241",
        "country": "NG"
      },
      "created_at": "2026-03-09T10:00:00.000Z",
      "updated_at": "2026-03-09T10:00:00.000Z"
    }
  },
  "attempts": [
    {
      "attempt_id": "wha_8e42bc52310ceff8bed0ff7664efd4ed",
      "attempt_no": 2,
      "status": "succeeded",
      "callback_url": "https://api.example.com/webhooks/bachs",
      "http_status": 200,
      "response_snippet": "{\"received\":true}",
      "last_error": null,
      "created_at": "2026-03-09T10:02:41.000Z",
      "updated_at": "2026-03-09T10:02:41.000Z"
    },
    {
      "attempt_id": "wha_5566022efc62628d4098bb7ea1598837",
      "attempt_no": 1,
      "status": "failed",
      "callback_url": "https://api.example.com/webhooks/bachs",
      "http_status": 503,
      "response_snippet": "Service Unavailable",
      "last_error": "Endpoint returned HTTP 503",
      "created_at": "2026-03-09T10:00:02.000Z",
      "updated_at": "2026-03-09T10:00:12.000Z"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

## Customers

### List customers

**Method:** `GET`  
**URL:** `/v1/customers`  
**Operation ID:** `listCustomers`  

Returns a paginated list of your customers, most recent first. Pass `search` to filter by email or name. See [Pagination](/guides/pagination) for how to page through results. Requires the `customers:read` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` |  |
| `offset` | `query` | No | `integer` |  |
| `search` | `query` | No | `string` | Search by customer email or name. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/customers?limit=&offset=&search=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "items": [
    {
      "customer_id": "cust_1a2b3c4d5e6f7g8h",
      "email": "ada@example.com",
      "name": "Ada Lovelace",
      "metadata": {
        "tier": "vip"
      },
      "created_at": "2026-07-13T14:00:00.000Z",
      "updated_at": "2026-07-13T14:00:00.000Z"
    }
  ],
  "pagination": {
    "next_cursor": "cur_20",
    "prev_cursor": null,
    "has_more": true,
    "limit": 20,
    "offset": 0,
    "returned": 1,
    "total": 47
  }
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Create a customer

**Method:** `POST`  
**URL:** `/v1/customers`  
**Operation ID:** `createCustomer`  

Creates a customer. A customer groups a buyer's payments, subscriptions, and saved payment methods under one record. Only `email` is required. Requires the `customers:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "email": "jane@example.com",
  "metadata": {
    "plan": "pro"
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/customers" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email": "jane@example.com", "metadata": {"plan": "pro"}}'
```

#### Responses

##### `201` — Customer created

**application/json example:**

```json
{
  "customer_id": "cust_1a2b3c4d5e6f7g8h",
  "email": "ada@example.com",
  "name": "Ada Lovelace",
  "phone_number": "+2348012345678",
  "metadata": {
    "tier": "vip"
  },
  "billing_address": {
    "line1": "40 Yaba Road",
    "line2": null,
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101245",
    "country": "NG"
  },
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Retrieve a customer

**Method:** `GET`  
**URL:** `/v1/customers/{customer_id}`  
**Operation ID:** `getCustomer`  

Retrieves a single customer by ID. Requires the `customers:read` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `customer_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/customers/{customer_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "customer_id": "cust_1a2b3c4d5e6f7g8h",
  "email": "ada@example.com",
  "name": "Ada Lovelace",
  "phone_number": "+2348012345678",
  "metadata": {
    "tier": "vip"
  },
  "billing_address": {
    "line1": "40 Yaba Road",
    "line2": null,
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101245",
    "country": "NG"
  },
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Update a customer

**Method:** `PATCH`  
**URL:** `/v1/customers/{customer_id}`  
**Operation ID:** `updateCustomer`  

Updates a customer. Only the fields you send are changed. Requires the `customers:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `customer_id` | `path` | Yes | `string` |  |

#### Request body



**Content-Type:** `application/json`

```json
{
  "email": "jane.new@example.com",
  "metadata": {
    "plan": "enterprise"
  }
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/customers/{customer_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email": "jane.new@example.com", "metadata": {"plan": "enterprise"}}'
```

#### Responses

##### `200` — Customer updated

**application/json example:**

```json
{
  "customer_id": "cust_1a2b3c4d5e6f7g8h",
  "email": "ada@example.com",
  "name": "Ada Lovelace",
  "phone_number": "+2348012345678",
  "metadata": {
    "tier": "vip"
  },
  "billing_address": {
    "line1": "40 Yaba Road",
    "line2": null,
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101245",
    "country": "NG"
  },
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Products

### Create a product

**Method:** `POST`  
**URL:** `/v1/products`  
**Operation ID:** `createProduct`  

Creates a product with its pricing. Every product has a `price`; add a `billing_cycle` to make it recurring, or omit it for a one-time product. Sell products through checkout sessions and subscriptions. Requires the `products:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "Pro Plan",
  "description": "Monthly access to all Pro features.",
  "price": {
    "currency": "USD",
    "amount": "29.00",
    "currency_options": [
      {
        "currency": "NGN",
        "amount": "45000.00"
      }
    ]
  },
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/products" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Pro Plan", "description": "Monthly access to all Pro features.", "price": {"currency": "USD", "amount": "29.00", "currency_options": [{"currency": "NGN", "amount": "45000.00"}]}, "billing_cycle": {"interval": "month", "frequency": 1}}'
```

#### Responses

##### `201` — Product created

**application/json example:**

```json
{
  "id": "prod_1a2b3c4d5e6f7g8h",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan",
  "description": "Full access, billed monthly.",
  "price": {
    "currency": "USD",
    "price_type": "fixed",
    "amount": "29.00",
    "preset_amount": null,
    "minimum_amount": null,
    "maximum_amount": null,
    "currency_options": []
  },
  "prices": [
    {
      "currency": "USD",
      "amount": "29.00",
      "minimum_amount": null,
      "maximum_amount": null,
      "is_default": true
    }
  ],
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "trial_period": null,
  "status": "active",
  "metadata": {
    "tier": "pro"
  },
  "media": [],
  "actor_id": "usr_abc123",
  "total_payments": 0,
  "total_amount": "0.00",
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z",
  "archived_at": null
}
```

##### `400` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

---

### List products

**Method:** `GET`  
**URL:** `/v1/products`  
**Operation ID:** `listProducts`  

Returns a paginated list of your products, most recent first. Archived products are excluded unless you pass `include_archived=true`. See [Pagination](/guides/pagination) for how to page through results. Requires the `products:read` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` |  |
| `cursor` | `query` | No | `string` |  |
| `include_archived` | `query` | No | `boolean` | Include archived products in the results. Defaults to `false`. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/products?limit=&cursor=&include_archived=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "items": [
    {
      "id": "prod_1a2b3c4d5e6f7g8h",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Plan",
      "description": "Full access, billed monthly.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "29.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": []
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "29.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        }
      ],
      "billing_cycle": {
        "interval": "month",
        "frequency": 1
      },
      "trial_period": null,
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_abc123",
      "total_payments": 0,
      "total_amount": "0.00",
      "created_at": "2026-07-13T14:00:00.000Z",
      "updated_at": "2026-07-13T14:00:00.000Z",
      "archived_at": null
    }
  ],
  "pagination": {
    "next_cursor": "cur_20",
    "prev_cursor": null,
    "has_more": true,
    "limit": 20,
    "offset": 0,
    "returned": 1,
    "total": 47
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

---

### Retrieve a product

**Method:** `GET`  
**URL:** `/v1/products/{product_id}`  
**Operation ID:** `getProduct`  

Retrieves a single product by its ID. Requires the `products:read` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `product_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/products/{product_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "id": "prod_1a2b3c4d5e6f7g8h",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan",
  "description": "Full access, billed monthly.",
  "price": {
    "currency": "USD",
    "price_type": "fixed",
    "amount": "29.00",
    "preset_amount": null,
    "minimum_amount": null,
    "maximum_amount": null,
    "currency_options": []
  },
  "prices": [
    {
      "currency": "USD",
      "amount": "29.00",
      "minimum_amount": null,
      "maximum_amount": null,
      "is_default": true
    }
  ],
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "trial_period": null,
  "status": "active",
  "metadata": {
    "tier": "pro"
  },
  "media": [],
  "actor_id": "usr_abc123",
  "total_payments": 0,
  "total_amount": "0.00",
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z",
  "archived_at": null
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Update a product

**Method:** `PATCH`  
**URL:** `/v1/products/{product_id}`  
**Operation ID:** `updateProduct`  

Updates a product. You can change its name, description, metadata, media, price, and (if not yet set) its `billing_cycle` and `trial_period`. A `billing_cycle` is immutable once set, so a recurring product's interval cannot be changed. Create a new product for a different cadence. Requires the `products:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `product_id` | `path` | Yes | `string` |  |

#### Request body



**Content-Type:** `application/json`

```json
{
  "description": "Updated description.",
  "metadata": {
    "tier": "pro"
  }
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/products/{product_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"description": "Updated description.", "metadata": {"tier": "pro"}}'
```

#### Responses

##### `200` — Product updated

**application/json example:**

```json
{
  "id": "prod_1a2b3c4d5e6f7g8h",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan",
  "description": "Updated description.",
  "price": {
    "currency": "USD",
    "price_type": "fixed",
    "amount": "29.00",
    "preset_amount": null,
    "minimum_amount": null,
    "maximum_amount": null,
    "currency_options": []
  },
  "prices": [
    {
      "currency": "USD",
      "amount": "29.00",
      "minimum_amount": null,
      "maximum_amount": null,
      "is_default": true
    }
  ],
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "trial_period": null,
  "status": "active",
  "metadata": {
    "tier": "pro"
  },
  "media": [],
  "actor_id": "usr_abc123",
  "total_payments": 0,
  "total_amount": "0.00",
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z",
  "archived_at": null
}
```

##### `400` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Archive a product

**Method:** `POST`  
**URL:** `/v1/products/{product_id}/archive`  
**Operation ID:** `archiveProduct`  

Archives a product so it can no longer be used in new checkouts or subscriptions. Existing subscriptions keep billing. This is idempotent: archiving an already-archived product succeeds. Reverse it with [Unarchive Product](/api-reference/products/unarchive-product). Requires the `products:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `product_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/products/{product_id}/archive" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Product archived

**application/json example:**

```json
{
  "id": "prod_1a2b3c4d5e6f7g8h",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan",
  "description": "Full access, billed monthly.",
  "price": {
    "currency": "USD",
    "price_type": "fixed",
    "amount": "29.00",
    "preset_amount": null,
    "minimum_amount": null,
    "maximum_amount": null,
    "currency_options": []
  },
  "prices": [
    {
      "currency": "USD",
      "amount": "29.00",
      "minimum_amount": null,
      "maximum_amount": null,
      "is_default": true
    }
  ],
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "trial_period": null,
  "status": "archived",
  "metadata": {
    "tier": "pro"
  },
  "media": [],
  "actor_id": "usr_abc123",
  "total_payments": 0,
  "total_amount": "0.00",
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z",
  "archived_at": "2026-07-13T14:30:00.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Unarchive a product

**Method:** `POST`  
**URL:** `/v1/products/{product_id}/unarchive`  
**Operation ID:** `unarchiveProduct`  

Restores an archived product to active status so it can be used again. This is idempotent. Requires the `products:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `product_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/products/{product_id}/unarchive" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Product unarchived

**application/json example:**

```json
{
  "id": "prod_1a2b3c4d5e6f7g8h",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan",
  "description": "Full access, billed monthly.",
  "price": {
    "currency": "USD",
    "price_type": "fixed",
    "amount": "29.00",
    "preset_amount": null,
    "minimum_amount": null,
    "maximum_amount": null,
    "currency_options": []
  },
  "prices": [
    {
      "currency": "USD",
      "amount": "29.00",
      "minimum_amount": null,
      "maximum_amount": null,
      "is_default": true
    }
  ],
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "trial_period": null,
  "status": "active",
  "metadata": {
    "tier": "pro"
  },
  "media": [],
  "actor_id": "usr_abc123",
  "total_payments": 0,
  "total_amount": "0.00",
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z",
  "archived_at": null
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Product Groups

### Create Product Group

**Method:** `POST`  
**URL:** `/v1/product-groups`  
**Operation ID:** `createProductGroup`  

Bundle two or more products into a group for multi-plan checkout. Requires `PRODUCTS_WRITE` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "Pro Plan Billing Options",
  "product_ids": [
    "prod_4b91c2e7d3a85f60b1c9",
    "prod_7e2a9c4f1b60d38a5e21"
  ]
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/product-groups" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Pro Plan Billing Options", "product_ids": ["prod_4b91c2e7d3a85f60b1c9", "prod_7e2a9c4f1b60d38a5e21"]}'
```

#### Responses

##### `201` — Product group created

**application/json example:**

```json
{
  "id": "pgrp_9c4d1e7a2b8f6035a1d4",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan Billing Options",
  "products": [
    {
      "id": "prod_4b91c2e7d3a85f60b1c9",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Monthly",
      "description": "Full access, billed every month.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "29.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": [
          {
            "currency": "NGN",
            "amount": "43500.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null
          }
        ]
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "29.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        },
        {
          "currency": "NGN",
          "amount": "43500.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": false
        }
      ],
      "billing_cycle": {
        "interval": "month",
        "frequency": 1
      },
      "trial_period": null,
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
      "total_payments": 0,
      "total_amount": "0.00",
      "created_at": "2026-07-13T13:41:02.000Z",
      "updated_at": "2026-07-13T13:41:02.000Z",
      "archived_at": null
    },
    {
      "id": "prod_7e2a9c4f1b60d38a5e21",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Yearly",
      "description": "Full access, billed once a year at two months off.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "290.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": [
          {
            "currency": "NGN",
            "amount": "435000.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null
          }
        ]
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "290.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        },
        {
          "currency": "NGN",
          "amount": "435000.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": false
        }
      ],
      "billing_cycle": {
        "interval": "year",
        "frequency": 1
      },
      "trial_period": {
        "interval": "day",
        "frequency": 14
      },
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
      "total_payments": 0,
      "total_amount": "0.00",
      "created_at": "2026-07-13T13:44:19.000Z",
      "updated_at": "2026-07-13T13:44:19.000Z",
      "archived_at": null
    }
  ],
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z"
}
```

##### `400` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

---

### List Product Groups

**Method:** `GET`  
**URL:** `/v1/product-groups`  
**Operation ID:** `listProductGroups`  

Return a paginated list of product groups. Requires `PRODUCTS_READ` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` |  |
| `cursor` | `query` | No | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/product-groups?limit=&cursor=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "items": [
    {
      "id": "pgrp_9c4d1e7a2b8f6035a1d4",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Plan Billing Options",
      "products": [
        {
          "id": "prod_4b91c2e7d3a85f60b1c9",
          "organization_id": "acct_7KpQ2mNv4XbR9dLc",
          "name": "Pro Monthly",
          "description": "Full access, billed every month.",
          "price": {
            "currency": "USD",
            "price_type": "fixed",
            "amount": "29.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null,
            "currency_options": [
              {
                "currency": "NGN",
                "amount": "43500.00",
                "preset_amount": null,
                "minimum_amount": null,
                "maximum_amount": null
              }
            ]
          },
          "prices": [
            {
              "currency": "USD",
              "amount": "29.00",
              "minimum_amount": null,
              "maximum_amount": null,
              "is_default": true
            },
            {
              "currency": "NGN",
              "amount": "43500.00",
              "minimum_amount": null,
              "maximum_amount": null,
              "is_default": false
            }
          ],
          "billing_cycle": {
            "interval": "month",
            "frequency": 1
          },
          "trial_period": null,
          "status": "active",
          "metadata": {
            "tier": "pro"
          },
          "media": [],
          "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
          "total_payments": 18,
          "total_amount": "522.00",
          "created_at": "2026-07-13T13:41:02.000Z",
          "updated_at": "2026-07-13T13:41:02.000Z",
          "archived_at": null
        },
        {
          "id": "prod_7e2a9c4f1b60d38a5e21",
          "organization_id": "acct_7KpQ2mNv4XbR9dLc",
          "name": "Pro Yearly",
          "description": "Full access, billed once a year at two months off.",
          "price": {
            "currency": "USD",
            "price_type": "fixed",
            "amount": "290.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null,
            "currency_options": [
              {
                "currency": "NGN",
                "amount": "435000.00",
                "preset_amount": null,
                "minimum_amount": null,
                "maximum_amount": null
              }
            ]
          },
          "prices": [
            {
              "currency": "USD",
              "amount": "290.00",
              "minimum_amount": null,
              "maximum_amount": null,
              "is_default": true
            },
            {
              "currency": "NGN",
              "amount": "435000.00",
              "minimum_amount": null,
              "maximum_amount": null,
              "is_default": false
            }
          ],
          "billing_cycle": {
            "interval": "year",
            "frequency": 1
          },
          "trial_period": {
            "interval": "day",
            "frequency": 14
          },
          "status": "active",
          "metadata": {
            "tier": "pro"
          },
          "media": [],
          "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
          "total_payments": 4,
          "total_amount": "1160.00",
          "created_at": "2026-07-13T13:44:19.000Z",
          "updated_at": "2026-07-13T13:44:19.000Z",
          "archived_at": null
        }
      ],
      "created_at": "2026-07-13T14:00:00.000Z",
      "updated_at": "2026-07-13T14:00:00.000Z"
    },
    {
      "id": "pgrp_1f80a63c9d24e5b7c0a8",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Starter Billing Options",
      "products": [
        {
          "id": "prod_0d5c8a12e7b93f461ca2",
          "organization_id": "acct_7KpQ2mNv4XbR9dLc",
          "name": "Starter Monthly",
          "description": "Core features for a single seat, billed every month.",
          "price": {
            "currency": "USD",
            "price_type": "fixed",
            "amount": "9.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null,
            "currency_options": []
          },
          "prices": [
            {
              "currency": "USD",
              "amount": "9.00",
              "minimum_amount": null,
              "maximum_amount": null,
              "is_default": true
            }
          ],
          "billing_cycle": {
            "interval": "month",
            "frequency": 1
          },
          "trial_period": null,
          "status": "active",
          "metadata": {
            "tier": "starter"
          },
          "media": [],
          "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
          "total_payments": 61,
          "total_amount": "549.00",
          "created_at": "2026-06-02T10:15:30.000Z",
          "updated_at": "2026-06-02T10:15:30.000Z",
          "archived_at": null
        }
      ],
      "created_at": "2026-06-02T10:20:00.000Z",
      "updated_at": "2026-06-02T10:20:00.000Z"
    }
  ],
  "pagination": {
    "next_cursor": null,
    "prev_cursor": null,
    "has_more": false,
    "limit": 20,
    "offset": 0,
    "returned": 2,
    "total": 2
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

---

### Get Product Group

**Method:** `GET`  
**URL:** `/v1/product-groups/{group_id}`  
**Operation ID:** `getProductGroup`  

Fetch a product group and its member products. Requires `PRODUCTS_READ` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `group_id` | `path` | Yes | `string` |  |
| `include_archived` | `query` | No | `boolean` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/product-groups/{group_id}?include_archived=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "id": "pgrp_9c4d1e7a2b8f6035a1d4",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan Billing Options",
  "products": [
    {
      "id": "prod_4b91c2e7d3a85f60b1c9",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Monthly",
      "description": "Full access, billed every month.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "29.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": [
          {
            "currency": "NGN",
            "amount": "43500.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null
          }
        ]
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "29.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        },
        {
          "currency": "NGN",
          "amount": "43500.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": false
        }
      ],
      "billing_cycle": {
        "interval": "month",
        "frequency": 1
      },
      "trial_period": null,
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
      "total_payments": 18,
      "total_amount": "522.00",
      "created_at": "2026-07-13T13:41:02.000Z",
      "updated_at": "2026-07-13T13:41:02.000Z",
      "archived_at": null
    },
    {
      "id": "prod_7e2a9c4f1b60d38a5e21",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Yearly",
      "description": "Full access, billed once a year at two months off.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "290.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": [
          {
            "currency": "NGN",
            "amount": "435000.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null
          }
        ]
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "290.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        },
        {
          "currency": "NGN",
          "amount": "435000.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": false
        }
      ],
      "billing_cycle": {
        "interval": "year",
        "frequency": 1
      },
      "trial_period": {
        "interval": "day",
        "frequency": 14
      },
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
      "total_payments": 4,
      "total_amount": "1160.00",
      "created_at": "2026-07-13T13:44:19.000Z",
      "updated_at": "2026-07-13T13:44:19.000Z",
      "archived_at": null
    }
  ],
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-13T14:00:00.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Update Product Group

**Method:** `PATCH`  
**URL:** `/v1/product-groups/{group_id}`  
**Operation ID:** `updateProductGroup`  

Rename the group and/or replace its product membership. Requires `PRODUCTS_WRITE` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `group_id` | `path` | Yes | `string` |  |

#### Request body



**Content-Type:** `application/json`

```json
{
  "name": "Pro Plan Billing Options (2026)",
  "product_ids": [
    "prod_7e2a9c4f1b60d38a5e21",
    "prod_4b91c2e7d3a85f60b1c9"
  ]
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/product-groups/{group_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Pro Plan Billing Options (2026)", "product_ids": ["prod_7e2a9c4f1b60d38a5e21", "prod_4b91c2e7d3a85f60b1c9"]}'
```

#### Responses

##### `200` — Product group updated

**application/json example:**

```json
{
  "id": "pgrp_9c4d1e7a2b8f6035a1d4",
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Pro Plan Billing Options (2026)",
  "products": [
    {
      "id": "prod_7e2a9c4f1b60d38a5e21",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Yearly",
      "description": "Full access, billed once a year at two months off.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "290.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": [
          {
            "currency": "NGN",
            "amount": "435000.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null
          }
        ]
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "290.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        },
        {
          "currency": "NGN",
          "amount": "435000.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": false
        }
      ],
      "billing_cycle": {
        "interval": "year",
        "frequency": 1
      },
      "trial_period": {
        "interval": "day",
        "frequency": 14
      },
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
      "total_payments": 4,
      "total_amount": "1160.00",
      "created_at": "2026-07-13T13:44:19.000Z",
      "updated_at": "2026-07-13T13:44:19.000Z",
      "archived_at": null
    },
    {
      "id": "prod_4b91c2e7d3a85f60b1c9",
      "organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "name": "Pro Monthly",
      "description": "Full access, billed every month.",
      "price": {
        "currency": "USD",
        "price_type": "fixed",
        "amount": "29.00",
        "preset_amount": null,
        "minimum_amount": null,
        "maximum_amount": null,
        "currency_options": [
          {
            "currency": "NGN",
            "amount": "43500.00",
            "preset_amount": null,
            "minimum_amount": null,
            "maximum_amount": null
          }
        ]
      },
      "prices": [
        {
          "currency": "USD",
          "amount": "29.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": true
        },
        {
          "currency": "NGN",
          "amount": "43500.00",
          "minimum_amount": null,
          "maximum_amount": null,
          "is_default": false
        }
      ],
      "billing_cycle": {
        "interval": "month",
        "frequency": 1
      },
      "trial_period": null,
      "status": "active",
      "metadata": {
        "tier": "pro"
      },
      "media": [],
      "actor_id": "usr_3c8e0b1f9d244a7c8e5f6b2a1d907c43",
      "total_payments": 18,
      "total_amount": "522.00",
      "created_at": "2026-07-13T13:41:02.000Z",
      "updated_at": "2026-07-13T13:41:02.000Z",
      "archived_at": null
    }
  ],
  "created_at": "2026-07-13T14:00:00.000Z",
  "updated_at": "2026-07-14T08:12:44.930Z"
}
```

##### `400` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Delete Product Group

**Method:** `DELETE`  
**URL:** `/v1/product-groups/{group_id}`  
**Operation ID:** `deleteProductGroup`  

Permanently delete a product group. Member products are not affected. Requires `PRODUCTS_WRITE` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `group_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X DELETE "https://sandbox-api.bachs.io/v1/product-groups/{group_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `204` — Group deleted

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Media

### Upload a file

**Method:** `POST`  
**URL:** `/v1/utilities/uploads`  
**Operation ID:** `createUpload`  

Upload a file and receive an `upload_id`. Pass this ID in the `media` array when creating or updating a product.

Files must be sent as `multipart/form-data`. Maximum size is **20 MB**.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `multipart/form-data`

```json
{
  "scope": "general"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/utilities/uploads" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `201` — Upload created

**application/json example:**

```json
{
  "upload_id": "upl_4f3e2d1c",
  "file_name": "product-hero.png",
  "mime_type": "image/png",
  "file_size_bytes": 204800,
  "url": "https://cdn.bachs.io/uploads/upl_4f3e2d1c/product-hero.png",
  "linked_resource_type": null,
  "linked_resource_id": null,
  "created_at": "2026-01-24T12:00:00.000Z",
  "updated_at": "2026-01-24T12:00:00.000Z"
}
```

##### `400` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

---

### Retrieve an upload

**Method:** `GET`  
**URL:** `/v1/utilities/uploads/{upload_id}`  
**Operation ID:** `getUpload`  

Retrieve metadata for a previously created upload by its ID.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `upload_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/utilities/uploads/{upload_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Upload metadata

**application/json example:**

```json
{
  "upload_id": "upl_4f3e2d1c9b8a7605f4e3",
  "file_name": "pro-plan-hero.png",
  "mime_type": "image/png",
  "file_size_bytes": 204800,
  "url": "https://cdn.bachs.io/uploads/upl_4f3e2d1c9b8a7605f4e3/pro-plan-hero.png",
  "linked_resource_type": "product",
  "linked_resource_id": "prod_4b91c2e7d3a85f60b1c9",
  "created_at": "2026-07-13T13:40:11.000Z",
  "updated_at": "2026-07-13T13:41:02.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Delete an upload

**Method:** `DELETE`  
**URL:** `/v1/utilities/uploads/{upload_id}`  
**Operation ID:** `deleteUpload`  

Delete an upload that has not yet been linked to any resource. Returns a `409` if the upload is already attached to a product.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `upload_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X DELETE "https://sandbox-api.bachs.io/v1/utilities/uploads/{upload_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Upload deleted

**application/json example:**

```json
{
  "upload_id": "upl_4f3e2d1c",
  "deleted": true
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `409` — Conflict - Duplicate request detected (idempotency). This occurs when the same request is made multiple times with the same idempotency key. The original request's response is returned.

**application/json example:**

```json
{
  "detail": "Duplicate request detected",
  "error_code": "CONFLICT"
}
```

---

## Subscriptions

### List subscriptions

**Method:** `GET`  
**URL:** `/v1/subscriptions`  
**Operation ID:** `listSubscriptions`  

List subscriptions for your account, newest first. Filter by customer or status.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` |  |
| `offset` | `query` | No | `integer` |  |
| `customer_id` | `query` | No | `string` | Only subscriptions for this customer (cust_...). |
| `status` | `query` | No | `string` | Only subscriptions in this status. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/subscriptions?limit=&offset=&customer_id=&status=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — A page of subscriptions

**application/json example:**

```json
{
  "items": [
    {
      "id": "sub_1a2b3c4d5e6f",
      "payment_method_id": "pm_7h8i9j0k",
      "status": "active",
      "collection_method": "charge_automatically",
      "currency": "USD",
      "amount": "10.00",
      "billing_cycle": {
        "interval": "month",
        "frequency": 1
      },
      "quantity": 1,
      "current_period_start": "2026-07-13T12:00:00Z",
      "current_period_end": "2026-08-13T12:00:00Z",
      "previously_billed_at": "2026-07-13T12:00:00Z",
      "next_billed_at": "2026-08-13T12:00:00Z",
      "trial_end": null,
      "cancel_at_period_end": false,
      "canceled_at": null,
      "created_at": "2026-07-13T12:00:00Z",
      "product": {
        "id": "prod_abc123",
        "name": "Pro plan",
        "description": "Everything in Pro.",
        "status": "active",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "items": [
        {
          "id": "si_11aa22bb",
          "status": "active",
          "quantity": 1,
          "recurring": true,
          "price_type": "fixed",
          "unit_amount": "10.00",
          "currency": "USD",
          "previously_billed_at": "2026-07-13T12:00:00Z",
          "next_billed_at": "2026-08-13T12:00:00Z",
          "price": {
            "id": "price_pro_usd",
            "product_id": "prod_abc123",
            "price_type": "fixed",
            "currency": "USD",
            "unit_amount": "10.00",
            "billing_cycle": {
              "interval": "month",
              "frequency": 1
            },
            "trial_period": null,
            "seat_tiers": null,
            "is_archived": false,
            "created_at": "2026-07-01T09:00:00Z",
            "updated_at": "2026-07-01T09:00:00Z"
          },
          "product": {
            "id": "prod_abc123",
            "name": "Pro plan",
            "status": "active",
            "billing_cycle": {
              "interval": "month",
              "frequency": 1
            },
            "trial_period": null,
            "created_at": "2026-07-01T09:00:00Z",
            "updated_at": "2026-07-01T09:00:00Z"
          },
          "created_at": "2026-07-13T12:00:00Z",
          "updated_at": "2026-07-13T12:00:00Z"
        }
      ],
      "customer": {
        "customer_id": "cust_xyz789",
        "email": "customer@example.com",
        "name": "Jane Doe",
        "phone_number": "+2348012345678",
        "metadata": {},
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      }
    }
  ],
  "pagination": {
    "next_cursor": null,
    "prev_cursor": null,
    "has_more": false,
    "limit": 50,
    "offset": 0,
    "returned": 1,
    "total": 1
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Retrieve a subscription

**Method:** `GET`  
**URL:** `/v1/subscriptions/{subscription_id}`  
**Operation ID:** `getSubscription`  

Retrieve a single subscription with its product, price, items, and billing dates.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `subscription_id` | `path` | Yes | `string` | The subscription's public ID (sub_...). |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/subscriptions/{subscription_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The subscription

**application/json example:**

```json
{
  "id": "sub_1a2b3c4d5e6f",
  "payment_method_id": "pm_7h8i9j0k",
  "status": "active",
  "collection_method": "charge_automatically",
  "currency": "USD",
  "amount": "10.00",
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "quantity": 1,
  "current_period_start": "2026-07-13T12:00:00Z",
  "current_period_end": "2026-08-13T12:00:00Z",
  "previously_billed_at": "2026-07-13T12:00:00Z",
  "next_billed_at": "2026-08-13T12:00:00Z",
  "trial_end": null,
  "cancel_at_period_end": false,
  "canceled_at": null,
  "created_at": "2026-07-13T12:00:00Z",
  "product": {
    "id": "prod_abc123",
    "name": "Pro plan",
    "description": "Everything in Pro.",
    "status": "active",
    "billing_cycle": {
      "interval": "month",
      "frequency": 1
    },
    "trial_period": null,
    "created_at": "2026-07-01T09:00:00Z",
    "updated_at": "2026-07-01T09:00:00Z"
  },
  "items": [
    {
      "id": "si_11aa22bb",
      "status": "active",
      "quantity": 1,
      "recurring": true,
      "price_type": "fixed",
      "unit_amount": "10.00",
      "currency": "USD",
      "previously_billed_at": "2026-07-13T12:00:00Z",
      "next_billed_at": "2026-08-13T12:00:00Z",
      "price": {
        "id": "price_pro_usd",
        "product_id": "prod_abc123",
        "price_type": "fixed",
        "currency": "USD",
        "unit_amount": "10.00",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "seat_tiers": null,
        "is_archived": false,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "product": {
        "id": "prod_abc123",
        "name": "Pro plan",
        "status": "active",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "created_at": "2026-07-13T12:00:00Z",
      "updated_at": "2026-07-13T12:00:00Z"
    }
  ],
  "customer": {
    "customer_id": "cust_xyz789",
    "email": "customer@example.com",
    "name": "Jane Doe",
    "phone_number": "+2348012345678",
    "metadata": {},
    "created_at": "2026-07-01T09:00:00Z",
    "updated_at": "2026-07-01T09:00:00Z"
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Update a subscription

**Method:** `PATCH`  
**URL:** `/v1/subscriptions/{subscription_id}`  
**Operation ID:** `updateSubscription`  

Change a subscription. Send exactly one intent: change the plan, move a trial, or change the payment method. Returns the full updated subscription.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `subscription_id` | `path` | Yes | `string` | The subscription's public ID (sub_...). |

#### Request body



**Content-Type:** `application/json`

```json
{
  "product_id": "prod_premium",
  "proration_behavior": "invoice_now"
}
```

#### cURL

```bash
curl -X PATCH "https://sandbox-api.bachs.io/v1/subscriptions/{subscription_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"product_id": "prod_xyz456", "trial_end": "2026-05-01T00:00:00Z", "payment_method_id": "pm_9f8e7d6c5b", "metadata": {"plan": "pro", "seat_count": "5"}, "proration_behavior": "invoice_now"}'
```

#### Responses

##### `200` — The updated subscription

**application/json example:**

```json
{
  "id": "sub_1a2b3c4d5e6f",
  "payment_method_id": "pm_7h8i9j0k",
  "status": "active",
  "collection_method": "charge_automatically",
  "currency": "USD",
  "amount": "10.00",
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "quantity": 1,
  "current_period_start": "2026-07-13T12:00:00Z",
  "current_period_end": "2026-08-13T12:00:00Z",
  "previously_billed_at": "2026-07-13T12:00:00Z",
  "next_billed_at": "2026-08-13T12:00:00Z",
  "trial_end": null,
  "cancel_at_period_end": false,
  "canceled_at": null,
  "created_at": "2026-07-13T12:00:00Z",
  "product": {
    "id": "prod_abc123",
    "name": "Pro plan",
    "description": "Everything in Pro.",
    "status": "active",
    "billing_cycle": {
      "interval": "month",
      "frequency": 1
    },
    "trial_period": null,
    "created_at": "2026-07-01T09:00:00Z",
    "updated_at": "2026-07-01T09:00:00Z"
  },
  "items": [
    {
      "id": "si_11aa22bb",
      "status": "active",
      "quantity": 1,
      "recurring": true,
      "price_type": "fixed",
      "unit_amount": "10.00",
      "currency": "USD",
      "previously_billed_at": "2026-07-13T12:00:00Z",
      "next_billed_at": "2026-08-13T12:00:00Z",
      "price": {
        "id": "price_pro_usd",
        "product_id": "prod_abc123",
        "price_type": "fixed",
        "currency": "USD",
        "unit_amount": "10.00",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "seat_tiers": null,
        "is_archived": false,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "product": {
        "id": "prod_abc123",
        "name": "Pro plan",
        "status": "active",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "created_at": "2026-07-13T12:00:00Z",
      "updated_at": "2026-07-13T12:00:00Z"
    }
  ],
  "customer": {
    "customer_id": "cust_xyz789",
    "email": "customer@example.com",
    "name": "Jane Doe",
    "phone_number": "+2348012345678",
    "metadata": {},
    "created_at": "2026-07-01T09:00:00Z",
    "updated_at": "2026-07-01T09:00:00Z"
  }
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Cancel a subscription

**Method:** `DELETE`  
**URL:** `/v1/subscriptions/{subscription_id}`  
**Operation ID:** `cancelSubscription`  

Cancel a subscription immediately, or at the end of the current period with cancel_at_period_end. Returns the updated subscription.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `subscription_id` | `path` | Yes | `string` | The subscription's public ID (sub_...). |

#### Request body



**Content-Type:** `application/json`

```json
{
  "cancel_at_period_end": true,
  "reason": "Customer requested"
}
```

#### cURL

```bash
curl -X DELETE "https://sandbox-api.bachs.io/v1/subscriptions/{subscription_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"cancel_at_period_end": false, "reason": "Customer requested cancellation"}'
```

#### Responses

##### `200` — The canceled (or scheduled-to-cancel) subscription

**application/json example:**

```json
{
  "id": "sub_1a2b3c4d5e6f",
  "payment_method_id": "pm_7h8i9j0k",
  "status": "canceled",
  "collection_method": "charge_automatically",
  "currency": "USD",
  "amount": "10.00",
  "billing_cycle": {
    "interval": "month",
    "frequency": 1
  },
  "quantity": 1,
  "current_period_start": "2026-07-13T12:00:00Z",
  "current_period_end": "2026-08-13T12:00:00Z",
  "previously_billed_at": "2026-07-13T12:00:00Z",
  "next_billed_at": null,
  "trial_end": null,
  "cancel_at_period_end": false,
  "canceled_at": "2026-09-01T09:00:00Z",
  "created_at": "2026-07-13T12:00:00Z",
  "product": {
    "id": "prod_abc123",
    "name": "Pro plan",
    "description": "Everything in Pro.",
    "status": "active",
    "billing_cycle": {
      "interval": "month",
      "frequency": 1
    },
    "trial_period": null,
    "created_at": "2026-07-01T09:00:00Z",
    "updated_at": "2026-07-01T09:00:00Z"
  },
  "items": [
    {
      "id": "si_11aa22bb",
      "status": "active",
      "quantity": 1,
      "recurring": true,
      "price_type": "fixed",
      "unit_amount": "10.00",
      "currency": "USD",
      "previously_billed_at": "2026-07-13T12:00:00Z",
      "next_billed_at": "2026-08-13T12:00:00Z",
      "price": {
        "id": "price_pro_usd",
        "product_id": "prod_abc123",
        "price_type": "fixed",
        "currency": "USD",
        "unit_amount": "10.00",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "seat_tiers": null,
        "is_archived": false,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "product": {
        "id": "prod_abc123",
        "name": "Pro plan",
        "status": "active",
        "billing_cycle": {
          "interval": "month",
          "frequency": 1
        },
        "trial_period": null,
        "created_at": "2026-07-01T09:00:00Z",
        "updated_at": "2026-07-01T09:00:00Z"
      },
      "created_at": "2026-07-13T12:00:00Z",
      "updated_at": "2026-07-13T12:00:00Z"
    }
  ],
  "customer": {
    "customer_id": "cust_xyz789",
    "email": "customer@example.com",
    "name": "Jane Doe",
    "phone_number": "+2348012345678",
    "metadata": {},
    "created_at": "2026-07-01T09:00:00Z",
    "updated_at": "2026-07-01T09:00:00Z"
  }
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

## Customer sessions

### Create a customer portal session

**Method:** `POST`  
**URL:** `/v1/customers/{customer_id}/portal-sessions`  
**Operation ID:** `createCustomerPortalSession`  

Creates a pre-authenticated customer portal session and returns the URL that opens it. The URL carries the session credential, so redirect the customer to it and do not log or share it. Sessions are short-lived; create a fresh one each time a customer asks to manage their billing. Requires the `customers:write` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `customer_id` | `path` | Yes | `string` |  |

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/customers/{customer_id}/portal-sessions" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success

**application/json example:**

```json
{
  "id": "psn_9f2c4a7b1d3e",
  "url": "https://portal.bachs.io/s/6Yc0nQpR2vX1sK7fLbA9tE"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

##### `503` — Service Unavailable - The portal cannot issue sessions right now. Retry once; if it persists, contact support.

**application/json example:**

```json
{
  "detail": "The billing portal is not configured for this environment.",
  "error_code": "SERVICE_UNAVAILABLE"
}
```

---

## Accounts

### Get your own account

**Method:** `GET`  
**URL:** `/v1/accounts/me`  
**Operation ID:** `getMyOrganization`  

Get the account your API key belongs to, including its capability names, checkout payment methods, and balance currencies. The `capabilities` and `requirements` blocks are not populated here; read the account by ID for those. Use this to confirm your own platform holds an active `connect` capability before you create accounts. See [Become a platform](/connect/become-a-platform).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts/me" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Your account.

**application/json example:**

```json
{
  "id": "acct_7KpQ2mNv4XbR9dLc",
  "name": "Ada Stores",
  "owner_user_id": "usr_7b3e19d24c0a",
  "parent_organization_id": null,
  "country": "NG",
  "fee_handling": "account_pays_fee",
  "enabled_payment_methods": {
    "USD_CARD": {
      "enabled": true
    },
    "NGN_CARD": {
      "enabled": true
    },
    "NGN_BANK_TRANSFER": {
      "enabled": true
    },
    "MOMO_GHS": {
      "enabled": true
    },
    "CRYPTO": {
      "enabled": true,
      "currencies": {
        "USDT_TRC20": true,
        "USDC_BEP20": true
      }
    }
  },
  "adaptive_pricing": true,
  "balance_currencies": [
    "NGN",
    "USD"
  ],
  "phone_number": null,
  "company_name": null,
  "enabled_capabilities": [
    "payouts",
    "conversions",
    "connect"
  ],
  "capabilities": null,
  "requirements": null,
  "is_active": true,
  "created_at": "2026-08-01T09:12:44.000Z",
  "updated_at": "2026-08-07T11:04:22.518Z",
  "responsibilities": null,
  "configuration": null
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Get an account

**Method:** `GET`  
**URL:** `/v1/accounts/{account_id}`  
**Operation ID:** `getAccount`  

Read an account: your own, or one you own. A platform account and an account you own are the same object, differing only by whether they have a parent, so one path serves both. `capabilities` and `requirements` always come back; `include=requirements.values` adds what has been submitted.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404` so the response never confirms that an unrelated account exists. |
| `include` | `query` | No | `array` | Expandable blocks to add. `requirements.values` returns the account's current field values and the per-person rollup, which cost an extra resource load. Comma-separated or repeated; an unknown value returns `400 invalid_include`. Anything not asked for is omitted from the response rather than returned as null. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts/{account_id}?include=requirements.values" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The account.

**application/json example:**

```json
{
  "id": "acct_3Wq8ZfT1yHnJ5sVe",
  "name": "Ada Stores",
  "owner_user_id": "usr_5e0b74c8a213",
  "parent_organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "country": "NG",
  "fee_handling": "account_pays_fee",
  "enabled_payment_methods": null,
  "adaptive_pricing": true,
  "balance_currencies": [
    "NGN"
  ],
  "phone_number": null,
  "company_name": null,
  "enabled_capabilities": [
    "payouts"
  ],
  "capabilities": {
    "payouts": {
      "status": "active",
      "requested": true,
      "status_details": null
    },
    "transfers": {
      "status": "restricted",
      "requested": true,
      "status_details": [
        {
          "code": "platform_disabled",
          "resolution": "Contact support to re-enable this capability.",
          "message": "This capability was disabled by the platform."
        }
      ]
    }
  },
  "requirements": {
    "currently_due": [
      "business_profile.social_media"
    ],
    "eventually_due": [],
    "past_due": [],
    "pending_verification": [
      "company.documents.registration"
    ],
    "errors": [
      {
        "field": "company.documents.memart",
        "code": "unreadable",
        "reason": "The document image was too blurry to read."
      }
    ]
  },
  "is_active": true,
  "created_at": "2026-08-01T09:12:44.000Z",
  "updated_at": "2026-08-07T11:04:22.518Z",
  "responsibilities": {
    "fees": {
      "collector": "bachs"
    }
  },
  "configuration": {
    "recipient": {}
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Update an account

**Method:** `POST`  
**URL:** `/v1/accounts/{account_id}`  
**Operation ID:** `updateAccount`  

The one write path for an account, yours or one you own. Set its profile and contact details, request capabilities, and supply requirement values in a single call. Omitted keys are left alone.

Each newly requested capability applies the configuration it belongs to, lands as `pending`, and surfaces the requirements it needs. Requesting authorizes nothing: a person enables the capability once those requirements are satisfied. Capabilities cannot be withdrawn once requested. See [Capabilities](/connect/capabilities).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404` so the response never confirms that an unrelated account exists. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "display_name": "Ada Stores Ltd",
  "configuration": {
    "recipient": {
      "capabilities": {
        "conversions": {
          "requested": true
        }
      }
    }
  },
  "fields": {
    "business_profile": {
      "url": "https://adastores.example"
    }
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts/{account_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"display_name": "Ada Stores Ltd", "configuration": {"recipient": {"capabilities": {"conversions": {"requested": true}}}}, "fields": {"business_profile": {"url": "https://adastores.example"}}}'
```

#### Responses

##### `200` — The account, including any requirements the newly requested capability just surfaced and the effect of any fields supplied.

**application/json example:**

```json
{
  "id": "acct_3Wq8ZfT1yHnJ5sVe",
  "name": "Ada Stores",
  "owner_user_id": "usr_5e0b74c8a213",
  "parent_organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "country": "NG",
  "fee_handling": "account_pays_fee",
  "enabled_payment_methods": null,
  "adaptive_pricing": true,
  "balance_currencies": [
    "NGN"
  ],
  "phone_number": null,
  "company_name": null,
  "enabled_capabilities": [
    "payouts"
  ],
  "capabilities": {
    "payouts": {
      "status": "active",
      "requested": true,
      "status_details": null
    },
    "transfers": {
      "status": "restricted",
      "requested": true,
      "status_details": [
        {
          "code": "platform_disabled",
          "resolution": "Contact support to re-enable this capability.",
          "message": "This capability was disabled by the platform."
        }
      ]
    },
    "conversions": {
      "status": "pending",
      "requested": true,
      "status_details": null
    }
  },
  "requirements": {
    "currently_due": [
      "business_profile.social_media"
    ],
    "eventually_due": [],
    "past_due": [],
    "pending_verification": [
      "company.documents.registration"
    ],
    "errors": [
      {
        "field": "company.documents.memart",
        "code": "unreadable",
        "reason": "The document image was too blurry to read."
      }
    ]
  },
  "is_active": true,
  "created_at": "2026-08-01T09:12:44.000Z",
  "updated_at": "2026-08-07T11:04:22.518Z",
  "responsibilities": {
    "fees": {
      "collector": "bachs"
    }
  },
  "configuration": {
    "recipient": {}
  }
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### List accounts

**Method:** `GET`  
**URL:** `/v1/accounts`  
**Operation ID:** `listConnectedAccounts`  

Returns the accounts linked to your account. Items never carry the `capabilities` or `requirements` blocks; read a single account with [Get account](/api-reference/connected-accounts/get-connected-account) for those. Requires the `connect` capability to be active on your account.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of accounts to return per page. |
| `offset` | `query` | No | `integer` | Number of accounts to skip before the page starts. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts?limit=&offset=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — A page of accounts. Each entry in `items` is an [Account](/api-reference/connected-accounts/get-connected-account).

**application/json example:**

```json
{
  "items": [
    {
      "id": "acct_3Wq8ZfT1yHnJ5sVe",
      "name": "Ada Stores",
      "owner_user_id": "usr_7b3e19d24c0a",
      "parent_organization_id": "acct_7KpQ2mNv4XbR9dLc",
      "country": "NG",
      "fee_handling": "account_pays_fee",
      "enabled_payment_methods": null,
      "adaptive_pricing": true,
      "balance_currencies": [
        "NGN"
      ],
      "phone_number": null,
      "company_name": null,
      "enabled_capabilities": [
        "transfers"
      ],
      "capabilities": null,
      "requirements": null,
      "is_active": true,
      "created_at": "2026-08-01T09:12:44.000Z",
      "updated_at": "2026-08-07T11:04:22.518Z",
      "responsibilities": null,
      "configuration": null
    }
  ],
  "total": 42,
  "limit": 20,
  "offset": 0
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Create an account

**Method:** `POST`  
**URL:** `/v1/accounts`  
**Operation ID:** `createConnectedAccount`  

Create an account under your platform. The account starts with nothing enabled: the capabilities you request here decide which requirements it is given, and a person enables each capability once those requirements are satisfied. Requires an active `connect` capability on your own platform, and an account cannot create accounts of its own. See [Create an account](/connect/accounts).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `X-Account-Id` | `header` | No | `string` | Account ID when acting on behalf of a sub-account. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "contact_email": "ada@adastores.example",
  "display_name": "Ada Stores",
  "first_name": "Ada",
  "last_name": "Okafor",
  "country": "NG",
  "entity_type": "company",
  "configuration": {
    "recipient": {
      "capabilities": {
        "payouts": {
          "requested": true
        },
        "transfers": {
          "requested": true
        }
      }
    }
  },
  "responsibilities": {
    "fees": {
      "collector": "bachs"
    }
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"contact_email": "ada@adastores.example", "display_name": "Ada Stores", "first_name": "Ada", "last_name": "Okafor", "country": "NG", "entity_type": "company", "configuration": {"recipient": {"capabilities": {"payouts": {"requested": true}, "transfers": {"requested": true}}}}, "responsibilities": {"fees": {"collector": "bachs"}}}'
```

#### Responses

##### `201` — Account created, with the requirements the requested capabilities just surfaced.

**application/json example:**

```json
{
  "id": "acct_3Wq8ZfT1yHnJ5sVe",
  "name": "Ada Stores",
  "owner_user_id": "usr_5e0b74c8a213",
  "parent_organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "country": "NG",
  "fee_handling": "account_pays_fee",
  "enabled_payment_methods": null,
  "adaptive_pricing": true,
  "balance_currencies": [
    "NGN"
  ],
  "phone_number": null,
  "company_name": null,
  "enabled_capabilities": [],
  "capabilities": {
    "payouts": {
      "status": "pending",
      "requested": true,
      "status_details": null
    },
    "transfers": {
      "status": "pending",
      "requested": true,
      "status_details": null
    }
  },
  "requirements": {
    "currently_due": [
      "persons",
      "company.registered_name",
      "company.registration_number",
      "payout_destination"
    ],
    "eventually_due": [],
    "past_due": [],
    "pending_verification": [],
    "errors": []
  },
  "is_active": true,
  "created_at": "2026-08-07T11:04:22.518Z",
  "updated_at": "2026-08-07T11:04:22.518Z",
  "responsibilities": {
    "fees": {
      "collector": "bachs"
    }
  },
  "configuration": {
    "recipient": {}
  }
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### Get checkout settings

**Method:** `GET`  
**URL:** `/v1/accounts/checkout/settings`  
**Operation ID:** `getCheckoutSettings`  

Retrieve checkout configuration for your account context, including enabled payment methods, per-method currency toggles, and fee preference.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `X-Account-Id` | `header` | No | `string` | Account ID when acting on behalf of a sub-account. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts/checkout/settings" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Success - Checkout settings retrieved

**application/json example:**

```json
{
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "enabled_payment_methods": {
    "USD_CARD": {
      "enabled": true
    },
    "NGN_CARD": {
      "enabled": false
    },
    "NGN_BANK_TRANSFER": {
      "enabled": true
    },
    "MOMO_GHS": {
      "enabled": true
    },
    "MOMO_XAF": {
      "enabled": true
    },
    "MOMO_XOF": {
      "enabled": true
    },
    "CRYPTO": {
      "enabled": true,
      "currencies": {
        "BNB_BEP20": false,
        "ETH_ETH": false,
        "SOL_SOL": false,
        "USDC_BEP20": false,
        "USDT_BEP20": true,
        "USDT_ERC20": false,
        "USDT_SOL": false,
        "USDT_TRC20": true
      }
    }
  },
  "fee_preference": "customer_pays",
  "available_currencies": {
    "USD_CARD": [
      "USD"
    ],
    "NGN_CARD": [
      "NGN"
    ],
    "NGN_BANK_TRANSFER": [
      "NGN"
    ],
    "MOMO_GHS": [
      "GHS"
    ],
    "CRYPTO": [
      "BNB_BEP20",
      "ETH_ETH",
      "SOL_SOL",
      "USDC_BEP20",
      "USDT_BEP20",
      "USDT_ERC20",
      "USDT_SOL",
      "USDT_TRC20"
    ]
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Update checkout settings

**Method:** `PUT`  
**URL:** `/v1/accounts/checkout/settings`  
**Operation ID:** `updateCheckoutSettings`  

Update checkout configuration for your account context, including enabled payment methods and fee preference.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `X-Account-Id` | `header` | No | `string` | Account ID when acting on behalf of a sub-account. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "enabled_payment_methods": {
    "USD_CARD": {
      "enabled": true
    },
    "NGN_BANK_TRANSFER": {
      "enabled": true
    },
    "MOMO_GHS": {
      "enabled": true
    },
    "MOMO_XAF": {
      "enabled": true
    },
    "MOMO_XOF": {
      "enabled": true
    },
    "CRYPTO": {
      "enabled": false,
      "currencies": {
        "BNB_BEP20": false,
        "ETH_ETH": false,
        "SOL_SOL": false,
        "USDC_BEP20": false,
        "USDT_BEP20": false,
        "USDT_ERC20": false,
        "USDT_SOL": false,
        "USDT_TRC20": false
      }
    }
  },
  "fee_preference": "org_pays"
}
```

#### cURL

```bash
curl -X PUT "https://sandbox-api.bachs.io/v1/accounts/checkout/settings" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"enabled_payment_methods": {"USD_CARD": {"enabled": true}, "NGN_BANK_TRANSFER": {"enabled": true}, "MOMO_GHS": {"enabled": true}, "MOMO_XAF": {"enabled": true}, "MOMO_XOF": {"enabled": true}, "CRYPTO": {"enabled": false, "currencies": {"BNB_BEP20": false, "ETH_ETH": false, "SOL_SOL": false, "USDC_BEP20": false, "USDT_BEP20": false, "USDT_ERC20": false, "USDT_SOL": false, "USDT_TRC20": false}}}, "fee_preference": "org_pays"}'
```

#### Responses

##### `200` — Success - Checkout settings updated

**application/json example:**

```json
{
  "organization_id": "acct_7KpQ2mNv4XbR9dLc",
  "enabled_payment_methods": {
    "USD_CARD": {
      "enabled": true
    },
    "NGN_BANK_TRANSFER": {
      "enabled": true
    },
    "MOMO_GHS": {
      "enabled": true
    },
    "MOMO_XAF": {
      "enabled": true
    },
    "MOMO_XOF": {
      "enabled": true
    },
    "CRYPTO": {
      "enabled": false,
      "currencies": {
        "BNB_BEP20": false,
        "ETH_ETH": false,
        "SOL_SOL": false,
        "USDC_BEP20": false,
        "USDT_BEP20": false,
        "USDT_ERC20": false,
        "USDT_SOL": false,
        "USDT_TRC20": false
      }
    }
  },
  "fee_preference": "org_pays",
  "message": "Checkout settings updated successfully"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Create an account link

**Method:** `POST`  
**URL:** `/v1/accounts/{account_id}/account-links`  
**Operation ID:** `createAccountLink`  

Issue a hosted link that walks an account through its outstanding requirements. Creating a link invalidates any outstanding active link of the same `type` for that account, so create one at the moment you redirect rather than on every page render. Requires an active `connect` capability on your own platform. See [Onboarding](/connect/onboarding).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404` so the response never confirms that an unrelated account exists. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "type": "onboarding",
  "refresh_url": "https://adastores.example/connect/refresh",
  "return_url": "https://adastores.example/connect/return"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts/{account_id}/account-links" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"type": "onboarding", "refresh_url": "https://adastores.example/connect/refresh", "return_url": "https://adastores.example/connect/return"}'
```

#### Responses

##### `200` — Account link created. `url` is returned only here and cannot be read back.

**application/json example:**

```json
{
  "id": "alnk_3b7e12c9d4a05f68b1c2",
  "object": "connected_account_link",
  "account": "acct_3Wq8ZfT1yHnJ5sVe",
  "type": "onboarding",
  "created": "2026-08-07T11:04:22.518Z",
  "expires_at": "2026-09-06T11:04:22.518Z",
  "url": "https://connect.bachs.io/setup/c/acct_3Wq8ZfT1yHnJ5sVe/al_kQ2v8nS1xJd0pR7mLtY4wZ6aHb3cFg9e",
  "previous_link_superseded": false
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### List capabilities

**Method:** `GET`  
**URL:** `/v1/accounts/{account_id}/capabilities`  
**Operation ID:** `listCapabilities`  

List every capability applicable to an account, including ones it has never requested. A capability with no record reports `unrequested` rather than being omitted, so you can tell "never asked for" apart from "turned off". See [Capabilities](/connect/capabilities).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404` so the response never confirms that an unrelated account exists. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts/{account_id}/capabilities" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The account's capabilities.

**application/json example:**

```json
{
  "items": [
    {
      "name": "payouts",
      "status": "active",
      "requested": true,
      "status_details": null
    },
    {
      "name": "transfers",
      "status": "restricted",
      "requested": true,
      "status_details": [
        {
          "code": "platform_disabled",
          "resolution": "Contact support to re-enable this capability.",
          "message": "This capability was disabled by the platform."
        }
      ]
    },
    {
      "name": "conversions",
      "status": "unrequested",
      "requested": false,
      "status_details": null
    },
    {
      "name": "connect",
      "status": "unrequested",
      "requested": false,
      "status_details": null
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Transfers

### Create a transfer

**Method:** `POST`  
**URL:** `/v1/transfers`  
**Operation ID:** `createTransfer`  

Move funds between your platform balance and an account you own. This debits the source balance immediately and cannot be cancelled. Transfers draw on available balance only, move a single currency, and never take a balance below zero. See the [Split payments](/connect/split-payments) guide for the full flow.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `X-Account-Id` | `header` | No | `string` | Act as this account, making it the debited side. Send it with `destination: "self"` to recover funds back to your platform. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "destination": "acct_3Wq8ZfT1yHnJ5sVe",
  "amount": "7000.00",
  "currency": "NGN",
  "transfer_group": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "description": "Order #4471 seller share"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/transfers" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"destination": "acct_3Wq8ZfT1yHnJ5sVe", "amount": "7000.00", "currency": "NGN", "transfer_group": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f", "description": "Order #4471 seller share"}'
```

#### Responses

##### `201` — Transfer created and the balances updated.

**application/json example:**

```json
{
  "id": "tr_8c1e04a7b93f2d6540ab",
  "source": "acct_7KpQ2mNv4XbR9dLc",
  "destination": "acct_3Wq8ZfT1yHnJ5sVe",
  "amount": "7000.00",
  "currency": "NGN",
  "status": "paid",
  "description": "Order #4471 seller share",
  "metadata": {},
  "transfer_group": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "kind": "manual",
  "source_charge_id": null,
  "created_at": "2026-08-07T11:04:22.518Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### List transfers

**Method:** `GET`  
**URL:** `/v1/transfers`  
**Operation ID:** `listTransfers`  

Returns transfers your platform was a party to, newest first.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of transfers to return per page. |
| `offset` | `query` | No | `integer` | Number of transfers to skip before the page starts. |
| `connected_account_id` | `query` | No | `string` | Return only transfers involving this account, in either direction. |
| `kind` | `query` | No | `string` | Filter to one class of movement: `payout` or `manual`. `platform_fee` is no longer accepted here, see [Platform fees](/connect/platform-fees). |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/transfers?limit=&offset=&connected_account_id=acct_3Wq8ZfT1yHnJ5sVe&kind=payout" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — A page of transfers. Each entry in `items` is a [Transfer](/api-reference/transfers/get-transfer).

**application/json example:**

```json
{
  "items": [
    {
      "id": "tr_8c1e04a7b93f2d6540ab",
      "source": "acct_7KpQ2mNv4XbR9dLc",
      "destination": "acct_3Wq8ZfT1yHnJ5sVe",
      "amount": "7000.00",
      "currency": "NGN",
      "status": "paid",
      "description": "Order #4471 seller share",
      "metadata": {},
      "transfer_group": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
      "kind": "payout",
      "source_charge_id": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
      "created_at": "2026-08-07T11:04:22.518Z"
    }
  ],
  "total": 128,
  "limit": 50,
  "offset": 0
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

---

### Get a transfer

**Method:** `GET`  
**URL:** `/v1/transfers/{transfer_id}`  
**Operation ID:** `getTransfer`  

Retrieve a single transfer your platform was a party to. A transfer between two accounts you do not own returns `404` rather than `403`, so the response never confirms that an unrelated id exists.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `transfer_id` | `path` | Yes | `string` | The transfer's ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/transfers/{transfer_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The transfer.

**application/json example:**

```json
{
  "id": "tr_8c1e04a7b93f2d6540ab",
  "source": "acct_7KpQ2mNv4XbR9dLc",
  "destination": "acct_3Wq8ZfT1yHnJ5sVe",
  "amount": "7000.00",
  "currency": "NGN",
  "status": "paid",
  "description": "Order #4471 seller share",
  "metadata": {},
  "transfer_group": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "kind": "manual",
  "source_charge_id": null,
  "created_at": "2026-08-07T11:04:22.518Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Platform Fees

### List platform fees

**Method:** `GET`  
**URL:** `/v1/platform_fees`  
**Operation ID:** `listPlatformFees`  

Returns platform fees your organization was a party to, newest first. Both the account a fee was collected from and the platform that earned it can list it.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `limit` | `query` | No | `integer` | Number of platform fees to return per page. |
| `offset` | `query` | No | `integer` | Number of platform fees to skip before the page starts. |
| `charge` | `query` | No | `string` | Filter to the platform fee struck against this charge. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/platform_fees?limit=&offset=&charge=ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — A page of platform fees. Each entry in `items` is a [Platform fee](/api-reference/platform-fees/get-platform-fee).

**application/json example:**

```json
{
  "items": [
    {
      "id": "pf_8c1e04a7b93f2d6540ab1234",
      "charge": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
      "collected_from": "acct_3Wq8ZfT1yHnJ5sVe",
      "earned_by": "acct_7KpQ2mNv4XbR9dLc",
      "amount": "20000.00",
      "currency": "NGN",
      "amount_refunded": "0.00",
      "refunded": false,
      "created_at": "2026-08-07T11:04:22.518Z"
    }
  ],
  "pagination": {
    "next_cursor": null,
    "prev_cursor": null,
    "has_more": true,
    "limit": 50,
    "offset": 0,
    "returned": 1,
    "total": 42
  }
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

---

### Get a platform fee

**Method:** `GET`  
**URL:** `/v1/platform_fees/{fee_id}`  
**Operation ID:** `getPlatformFee`  

Retrieve a single platform fee your organization was a party to.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `fee_id` | `path` | Yes | `string` | The platform fee's ID. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/platform_fees/{fee_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The platform fee.

**application/json example:**

```json
{
  "id": "pf_8c1e04a7b93f2d6540ab1234",
  "charge": "ch_9f4c1d2e7b6a4f8e9c0d1a2b3c4d5e6f",
  "collected_from": "acct_3Wq8ZfT1yHnJ5sVe",
  "earned_by": "acct_7KpQ2mNv4XbR9dLc",
  "amount": "20000.00",
  "currency": "NGN",
  "amount_refunded": "0.00",
  "refunded": false,
  "created_at": "2026-08-07T11:04:22.518Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Checkout Sessions

### Create a checkout session

**Method:** `POST`  
**URL:** `/v1/checkout-sessions`  
**Operation ID:** `createCheckoutSession`  

Create a product-based checkout session

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "customer": {
    "email": "customer@example.com",
    "name": "John Doe"
  },
  "product_cart": [
    {
      "product_id": "prod_abc123"
    }
  ],
  "payment_method_types": [
    "USD_CARD",
    "NGN_BANK_TRANSFER"
  ]
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/checkout-sessions" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"customer": {"email": "customer@example.com", "name": "John Doe"}, "product_cart": [{"product_id": "prod_abc123"}], "payment_method_types": ["USD_CARD", "NGN_BANK_TRANSFER"]}'
```

#### Responses

##### `201` — Success - Checkout session created successfully

**application/json example:**

```json
{
  "checkout_id": "chk_1M2N3o4P5q6R7s8T",
  "checkout_url": "https://checkout.bachs.io/c/Tb5rHn8YkQ2vXpL",
  "status": "open",
  "expires_at": "2026-01-24T15:30:00.000Z",
  "created_at": "2026-01-24T14:30:00.000Z",
  "reference": "order_9876"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

##### `500` — Internal Server Error - An unexpected error occurred while processing the request. Retry with exponential backoff. If the issue persists, contact support with your request context.

**application/json example:**

```json
{
  "detail": "An unexpected error occurred. Please try again later.",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

---

### Retrieve a checkout session

**Method:** `GET`  
**URL:** `/v1/checkout-sessions/{checkout_id}`  
**Operation ID:** `getCheckoutSession`  

Retrieve the details of a checkout session by its ID, including resolved product line items and charge information.

The `charge` field is `null` while the session is `OPEN` and populated once the customer submits a payment.

Requires `payments:read` scope.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `checkout_id` | `path` | Yes | `string` | The checkout ID returned when the session was created. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/checkout-sessions/{checkout_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Checkout session retrieved successfully.

**application/json example:**

```json
{
  "checkout_id": "chk_1M2N3o4P5q6R7s8T",
  "status": "completed",
  "recurring": null,
  "payment_status": "succeeded",
  "source_type": "CHECKOUT_SESSION",
  "amount": "50.00",
  "currency": "USD",
  "reference": "order_9876",
  "charge": {
    "payment_id": "pay_1a2b3c4d5e",
    "billing_reason": "purchase",
    "status": "succeeded",
    "amount": "29.00",
    "currency": "USD",
    "fee_usd": "0.59"
  },
  "payment_method": "CARD",
  "customer": {
    "id": "cust_1a2b3c4d5e6f",
    "email": "jane@example.com",
    "name": "Jane Doe"
  },
  "customer_details": {
    "email": "jane@example.com",
    "name": "Jane Doe"
  },
  "success_url": "https://yourapp.com/success",
  "cancel_url": "https://yourapp.com/cancel",
  "products": [
    {
      "product_id": "prod_abc123",
      "product_name": "Premium Plan",
      "quantity": 1,
      "unit_amount": "50.00",
      "currency": "USD",
      "price_type": "fixed",
      "minimum_amount": null,
      "maximum_amount": null,
      "line_total": "50.00"
    }
  ],
  "billing_currency": "NGN",
  "session_mode": "CART",
  "metadata": {
    "order_id": "ORD-9876"
  },
  "created_at": "2026-01-24T14:30:00.000Z",
  "expires_at": "2026-01-24T15:30:00.000Z",
  "completed_at": "2026-01-24T14:35:00.000Z",
  "updated_at": "2026-01-24T14:35:00.000Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

## Connected Accounts

### Attach a company document

**Method:** `POST`  
**URL:** `/v1/accounts/{account_id}/documents`  
**Operation ID:** `attachCompanyDocument`  

Point one of the company's document slots at an already-uploaded file. Upload the file first with `POST /v1/utilities/uploads`, then reference its `upload_id` here as `file`. `document` names the company slot the file satisfies (for example a certificate of incorporation or a memorandum), and which slots exist depends on the company's structure and country. This attaches company-level paperwork; a person's ID document attaches to the person instead. See [Requirements](/connect/requirements).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "file": "upl_7c2f9a10bd4e",
  "document": "certificate_of_incorporation"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts/{account_id}/documents" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"file": "upl_7c2f9a10bd4e", "document": "certificate_of_incorporation"}'
```

#### Responses

##### `201` — The document attached to the company.

**application/json example:**

```json
{
  "id": "doc_9b21ec70f5aa",
  "document_type": "certificate_of_incorporation",
  "file_name": "cac-certificate.pdf",
  "uploaded_at": "2026-08-07T09:24:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Reference

### List banks

**Method:** `GET`  
**URL:** `/v1/reference/banks`  
**Operation ID:** `listReferenceBanks`  

The banks an account can name as a payout destination. Use the `code` from this list when you resolve an account number or submit `payout_destination`.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `country` | `query` | No | `string` | Two-letter ISO 3166-1 country. Falls back to your own platform's country, and fails with `400` when neither is set. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/reference/banks?country=NG" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Banks available in the resolved country.

**application/json example:**

```json
{
  "country": "NG",
  "banks": [
    {
      "name": "Providus Bank",
      "code": "101"
    },
    {
      "name": "Sterling Bank",
      "code": "232"
    }
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### List mobile money providers

**Method:** `GET`  
**URL:** `/v1/reference/momo`  
**Operation ID:** `listReferenceMomoProviders`  

The mobile money operators an account can name as a payout destination.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `country` | `query` | No | `string` | Two-letter ISO 3166-1 country. Falls back to your own platform's country, and fails with `400` when neither is set. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/reference/momo?country=GH" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Mobile money providers available in the resolved country.

**application/json example:**

```json
{
  "country": "GH",
  "providers": [
    "MTN",
    "Vodafone",
    "AirtelTigo"
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

### List business structures

**Method:** `GET`  
**URL:** `/v1/reference/business-structures`  
**Operation ID:** `listReferenceBusinessStructures`  

The legal structures a registered business can declare as `company.structure`, for the resolved country. Each carries a `value` to submit, a display `label`, and a `description`. Which documents a structure owes depends on it. See [Requirements](/connect/requirements).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `country` | `query` | No | `string` | Two-letter ISO 3166-1 country. Falls back to your own platform's country. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/reference/business-structures?country=NG" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — Business structures available in the resolved country.

**application/json example:**

```json
{
  "country": "NG",
  "structures": [
    {
      "value": "business_name",
      "label": "Business Name (BN)",
      "description": "A sole trader or partnership registered with the CAC. No shareholders."
    },
    {
      "value": "private_incorporated",
      "label": "Private Company (RC / LTD)",
      "description": "A company limited by shares, with directors and shareholders."
    },
    {
      "value": "incorporated_trustees",
      "label": "Incorporated Trustees (IT)",
      "description": "An NGO, church, association or foundation registered as trustees."
    }
  ]
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

---

### List product categories

**Method:** `GET`  
**URL:** `/v1/reference/product-categories`  
**Operation ID:** `listReferenceProductCategories`  

The industry categories a business can declare as `business_profile.product_category`. Returns a flat `categories` list of `{value, label}` and the same values grouped into `sections` for display. Submit the `value`. See [Requirements](/connect/requirements).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/reference/product-categories" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The product categories and their display sections.

**application/json example:**

```json
{
  "categories": [
    {
      "value": "software_as_a_service_saas",
      "label": "Software as a service (SaaS)"
    },
    {
      "value": "mobile_or_web_app",
      "label": "Mobile or web app"
    }
  ],
  "sections": [
    {
      "label": "Software & technology",
      "categories": [
        "software_as_a_service_saas",
        "mobile_or_web_app"
      ]
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

---

## Persons

### List persons

**Method:** `GET`  
**URL:** `/v1/accounts/{account_id}/persons`  
**Operation ID:** `listConnectedAccountPersons`  

The people behind the account: its representative, beneficial owners and directors.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404`. |
| `limit` | `query` | No | `integer` |  |
| `offset` | `query` | No | `integer` |  |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts/{account_id}/persons?limit=&offset=" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The account's persons.

**application/json example:**

```json
{
  "items": [
    {
      "id": "per_3a91c0d7",
      "first_name": "Ada",
      "last_name": "Obi",
      "dob": "1990-04-12",
      "address": {
        "line1": "14 Balogun Street",
        "city": "Lagos",
        "state": "Lagos",
        "postal_code": "101241",
        "country": "NG"
      },
      "phone": "+2348012345678",
      "email": "ada@example.com",
      "id_number_provided": true,
      "relationship": {
        "representative": true,
        "owner": true,
        "director": false,
        "executive": false,
        "percent_ownership": 60,
        "title": "Founder"
      },
      "verification": {
        "status": "verified",
        "document_provided": true,
        "failure_reason": null
      },
      "created_at": "2026-08-10T09:31:12.000Z",
      "updated_at": "2026-08-11T14:05:40.219Z"
    },
    {
      "id": "per_9c40be12",
      "first_name": "Tunde",
      "last_name": "Bello",
      "dob": "1986-11-02",
      "address": null,
      "phone": null,
      "email": null,
      "id_number_provided": false,
      "relationship": {
        "representative": false,
        "owner": false,
        "director": true,
        "executive": false,
        "percent_ownership": null,
        "title": "Non-executive director"
      },
      "verification": {
        "status": "unverified",
        "document_provided": false,
        "failure_reason": null
      },
      "created_at": "2026-08-10T09:44:07.000Z",
      "updated_at": "2026-08-10T09:44:07.000Z"
    }
  ],
  "total": 2,
  "limit": 50,
  "offset": 0
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Add a person

**Method:** `POST`  
**URL:** `/v1/accounts/{account_id}/persons`  
**Operation ID:** `createConnectedAccountPerson`  

Add a person to the account. Roles are flags, so one person can be representative, owner and director at once.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404`. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "first_name": "Ada",
  "last_name": "Obi",
  "dob": "1990-04-12",
  "address": {
    "line1": "14 Balogun Street",
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101241",
    "country": "NG"
  },
  "phone": "+2348012345678",
  "email": "ada@example.com",
  "id_number": "22345678901",
  "relationship": {
    "representative": true,
    "owner": true,
    "director": false,
    "executive": false,
    "percent_ownership": 60,
    "title": "Founder"
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts/{account_id}/persons" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"first_name": "Ada", "last_name": "Obi", "dob": "1990-04-12", "address": {"line1": "14 Balogun Street", "city": "Lagos", "state": "Lagos", "postal_code": "101241", "country": "NG"}, "phone": "+2348012345678", "email": "ada@example.com", "id_number": "22345678901", "relationship": {"representative": true, "owner": true, "director": false, "executive": false, "percent_ownership": 60, "title": "Founder"}}'
```

#### Responses

##### `201` — The person that was added.

**application/json example:**

```json
{
  "id": "per_3a91c0d7",
  "first_name": "Ada",
  "last_name": "Obi",
  "dob": "1990-04-12",
  "address": {
    "line1": "14 Balogun Street",
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101241",
    "country": "NG"
  },
  "phone": "+2348012345678",
  "email": "ada@example.com",
  "id_number_provided": true,
  "relationship": {
    "representative": true,
    "owner": true,
    "director": false,
    "executive": false,
    "percent_ownership": 60,
    "title": "Founder"
  },
  "verification": {
    "status": "unverified",
    "document_provided": false,
    "failure_reason": null
  },
  "created_at": "2026-08-10T09:31:12.000Z",
  "updated_at": "2026-08-10T09:31:12.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `422` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Read a person

**Method:** `GET`  
**URL:** `/v1/accounts/{account_id}/persons/{person_id}`  
**Operation ID:** `getConnectedAccountPerson`  

Read one person. Requirement keys are anchored to the person id, so `persons.per_3a91c0d7.id_document` names exactly who this is about.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404`. |
| `person_id` | `path` | Yes | `string` | The person on that account. |

#### cURL

```bash
curl -X GET "https://sandbox-api.bachs.io/v1/accounts/{account_id}/persons/{person_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `200` — The person.

**application/json example:**

```json
{
  "id": "per_3a91c0d7",
  "first_name": "Ada",
  "last_name": "Obi",
  "dob": "1990-04-12",
  "address": {
    "line1": "14 Balogun Street",
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101241",
    "country": "NG"
  },
  "phone": "+2348012345678",
  "email": "ada@example.com",
  "id_number_provided": true,
  "relationship": {
    "representative": true,
    "owner": true,
    "director": false,
    "executive": false,
    "percent_ownership": 60,
    "title": "Founder"
  },
  "verification": {
    "status": "verified",
    "document_provided": true,
    "failure_reason": null
  },
  "created_at": "2026-08-10T09:31:12.000Z",
  "updated_at": "2026-08-11T14:05:40.219Z"
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Update a person

**Method:** `POST`  
**URL:** `/v1/accounts/{account_id}/persons/{person_id}`  
**Operation ID:** `updateConnectedAccountPerson`  

Edit one person in place. Keys you omit are left alone; sending a key as `null` clears it.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404`. |
| `person_id` | `path` | Yes | `string` | The person on that account. |

#### Request body



**Content-Type:** `application/json`

```json
{
  "last_name": "Obi-Nwosu",
  "phone": null,
  "relationship": {
    "director": true
  }
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts/{account_id}/persons/{person_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"last_name": "Obi-Nwosu", "phone": null, "relationship": {"director": true}}'
```

#### Responses

##### `200` — The updated person.

**application/json example:**

```json
{
  "id": "per_3a91c0d7",
  "first_name": "Ada",
  "last_name": "Obi-Nwosu",
  "dob": "1990-04-12",
  "address": {
    "line1": "14 Balogun Street",
    "city": "Lagos",
    "state": "Lagos",
    "postal_code": "101241",
    "country": "NG"
  },
  "phone": null,
  "email": "ada@example.com",
  "id_number_provided": true,
  "relationship": {
    "representative": true,
    "owner": true,
    "director": true,
    "executive": false,
    "percent_ownership": 60,
    "title": "Founder"
  },
  "verification": {
    "status": "verified",
    "document_provided": true,
    "failure_reason": null
  },
  "created_at": "2026-08-10T09:31:12.000Z",
  "updated_at": "2026-08-11T16:22:03.884Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `422` — Validation Error - one or more fields failed validation. Inspect `errors[]` for the field, the message, and the failure type, correct them, and retry.

**application/json example:**

```json
{
  "detail": "Validation failed for one or more fields",
  "error_code": "VALIDATION_ERROR",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference#general",
  "errors": [
    {
      "field": "name",
      "message": "This field is required",
      "type": "missing"
    }
  ]
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Remove a person

**Method:** `DELETE`  
**URL:** `/v1/accounts/{account_id}/persons/{person_id}`  
**Operation ID:** `deleteConnectedAccountPerson`  

Remove a person, along with the requirements that were only about them. The representative cannot be removed, since nothing would ask for a replacement, and returns `400 representative_cannot_be_removed`.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` | The account to act on. It must be one of your own accounts; any other ID returns `404`. |
| `person_id` | `path` | Yes | `string` | The person on that account. |

#### cURL

```bash
curl -X DELETE "https://sandbox-api.bachs.io/v1/accounts/{account_id}/persons/{person_id}" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json"
```

#### Responses

##### `204` — The person was removed.

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `403` — Forbidden - API key does not have permission for the requested resource. Verify you're using the correct account's API key and that you're not trying to access another account's data.

**application/json example:**

```json
{
  "detail": "API key does not have permission for this operation",
  "error_code": "FORBIDDEN"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

##### `429` — Too Many Requests - Rate limit exceeded. Standard tier allows 100 requests per minute per API key. Wait a few seconds before retrying. Check X-RateLimit-Reset header for when the window resets.

**application/json example:**

```json
{
  "detail": "Rate limit exceeded. Please retry after a few seconds.",
  "error_code": "TOO_MANY_REQUESTS"
}
```

---

### Attach a document to a person

**Method:** `POST`  
**URL:** `/v1/accounts/{account_id}/persons/{person_id}/documents`  
**Operation ID:** `attachPersonDocument`  

Point one of a person's document slots at an already-uploaded file. Upload the file first with `POST /v1/utilities/uploads`, then reference its `upload_id` here as `file`. `document` is `primary_verification` (government ID) or `secondary_verification` (address evidence); a two-sided card is two attachments, each with its own `side`. Attaching does not verify: a reviewer accepting the document is what moves the person's `verification.status` to `passed`. See [Verify an account's identity](/connect/guides/identity-verification).

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Parameters

| Name | In | Required | Type | Description |
|---|---|---:|---|---|
| `account_id` | `path` | Yes | `string` |  |
| `person_id` | `path` | Yes | `string` |  |

#### Request body



**Content-Type:** `application/json`

```json
{
  "file": "upl_7c2f9a10bd4e",
  "document": "primary_verification",
  "side": "front"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/accounts/{account_id}/persons/{person_id}/documents" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"file": "upl_7c2f9a10bd4e", "document": "primary_verification", "side": "front"}'
```

#### Responses

##### `201` — The document attached to the person.

**application/json example:**

```json
{
  "id": "doc_5f0339fac1ae",
  "person": "per_3a91c0d7f6e2b8149a05",
  "document_type": "primary_verification",
  "file_name": "ada-nin.jpg",
  "uploaded_at": "2026-08-07T09:23:00.000Z"
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Misc

### Resolve a bank account

**Method:** `POST`  
**URL:** `/v1/misc/bank-accounts/resolve`  
**Operation ID:** `resolveReferenceBankAccount`  

Resolve an account number and bank code to the account holder's name. Worth calling before you submit a payout destination: it turns a rejection days later into an inline error while the account holder is still on the page.

**Authentication:** Bearer API key; required scopes are stated by the official endpoint description when applicable.

#### Request body



**Content-Type:** `application/json`

```json
{
  "account_number": "0123456789",
  "bank_code": "101",
  "country": "NG"
}
```

#### cURL

```bash
curl -X POST "https://sandbox-api.bachs.io/v1/misc/bank-accounts/resolve" \
  -H "Authorization: Bearer $BACHS_API_KEY" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"account_number": "0123456789", "bank_code": "101", "country": "NG"}'
```

#### Responses

##### `200` — The lookup result. Check `resolved` before you trust `account_name`.

**application/json example:**

```json
{
  "resolved": true,
  "account_name": "ADA OKAFOR",
  "account_number": "0123456789",
  "message": null
}
```

##### `400` — Bad Request - Validation errors or invalid request format. Check the `details` object for field-specific validation errors. Common causes: missing required fields, invalid data types, values outside allowed ranges, or invalid formats.

**application/json example:**

```json
{
  "detail": "Invalid request parameters",
  "error_code": "VALIDATION_ERROR",
  "errors": [
    {
      "field": "amount",
      "message": "Amount must be a positive decimal string",
      "type": "value_error"
    }
  ]
}
```

##### `401` — Unauthorized - Invalid, missing, or expired API key. Verify your API key is correctly formatted and included in the Authorization header as `Bearer sk_sandbox_...` or `Bearer sk_live_...`. Check that your key hasn't been revoked.

**application/json example:**

```json
{
  "detail": "Invalid API key",
  "error_code": "UNAUTHORIZED"
}
```

##### `404` — Not Found - The requested resource does not exist. Verify the resource ID is correct and that it belongs to your account.

**application/json example:**

```json
{
  "detail": "Resource not found",
  "error_code": "NOT_FOUND"
}
```

---

## Shared conventions

The official API uses versioned REST URLs, JSON request and response bodies, Bearer authentication, and standard HTTP status codes. Money uses decimal strings in major units; timestamps are ISO 8601 UTC; resource IDs are opaque prefixed strings. List responses use `items` and `pagination`. Mutating requests support `Idempotency-Key`.

| Environment | Base URL |
|---|---|
| Production | `https://api.bachs.io` |
| Sandbox | `https://sandbox-api.bachs.io` |

### Common response statuses

| Status | Meaning |
|---:|---|
| 200 | Success |
| 201 | Created |
| 204 | No Content |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 409 | Conflict |
| 422 | Validation Error |
| 428 | Precondition Required |
| 429 | Too Many Requests |
| 500/502/503 | Server error |

## Error reference

The common error object is a flat JSON object with `detail`, `error_code`, and `doc_url`; validation errors may add `errors`, and limit errors may add `details`. Branch on `error_code` rather than human-readable `detail`.

```json
{
  "detail": "Product not found",
  "error_code": "NOT_FOUND",
  "doc_url": "https://docs.bachs.io/api-reference/error-reference"
}
```

For the complete official error-code table, see [Error Reference](https://docs.bachs.io/api-reference/error-reference).

## Source index

The following official pages were used or are relevant to this API reference:

- [Create An Account](https://docs.bachs.io/api-reference/accounts/create-an-account)
- [Create An Account Link](https://docs.bachs.io/api-reference/accounts/create-an-account-link)
- [Get Balances](https://docs.bachs.io/api-reference/accounts/get-balances)
- [List Capabilities](https://docs.bachs.io/api-reference/accounts/list-capabilities)
- [Update An Account](https://docs.bachs.io/api-reference/accounts/update-an-account)
- [Api Standards](https://docs.bachs.io/api-reference/api-standards)
- [Object](https://docs.bachs.io/api-reference/balance/object)
- [Get Checkout Session](https://docs.bachs.io/api-reference/checkout-sessions/get-checkout-session)
- [Object](https://docs.bachs.io/api-reference/checkout-sessions/object)
- [Attach A Company Document](https://docs.bachs.io/api-reference/connected-accounts/attach-a-company-document)
- [Create A Customer Portal Session](https://docs.bachs.io/api-reference/customer-sessions/create-a-customer-portal-session)
- [Object](https://docs.bachs.io/api-reference/customer-sessions/object)
- [Create A Customer](https://docs.bachs.io/api-reference/customers/create-a-customer)
- [List Customers](https://docs.bachs.io/api-reference/customers/list-customers)
- [Object](https://docs.bachs.io/api-reference/customers/object)
- [Retrieve A Customer](https://docs.bachs.io/api-reference/customers/retrieve-a-customer)
- [Update A Customer](https://docs.bachs.io/api-reference/customers/update-a-customer)
- [Error Reference](https://docs.bachs.io/api-reference/error-reference)
- [Delete An Upload](https://docs.bachs.io/api-reference/media/delete-an-upload)
- [Retrieve An Upload](https://docs.bachs.io/api-reference/media/retrieve-an-upload)
- [Upload A File](https://docs.bachs.io/api-reference/media/upload-a-file)
- [Resolve A Bank Account](https://docs.bachs.io/api-reference/misc/resolve-a-bank-account)
- [Overview](https://docs.bachs.io/api-reference/overview)
- [Create Checkout Session](https://docs.bachs.io/api-reference/payments/create-checkout-session)
- [Get Payment](https://docs.bachs.io/api-reference/payments/get-payment)
- [List Payment Methods](https://docs.bachs.io/api-reference/payments/list-payment-methods)
- [List Payment Rails](https://docs.bachs.io/api-reference/payments/list-payment-rails)
- [List Payments](https://docs.bachs.io/api-reference/payments/list-payments)
- [List Payout Supported Currencies](https://docs.bachs.io/api-reference/payments/list-payout-supported-currencies)
- [List Supported Currencies](https://docs.bachs.io/api-reference/payments/list-supported-currencies)
- [Object](https://docs.bachs.io/api-reference/payments/object)
- [Object](https://docs.bachs.io/api-reference/payout-destinations/object)
- [Create Payout](https://docs.bachs.io/api-reference/payouts/create-payout)
- [Create Payout Destination](https://docs.bachs.io/api-reference/payouts/create-payout-destination)
- [Create Payout Quote](https://docs.bachs.io/api-reference/payouts/create-payout-quote)
- [Delete Payout Destination](https://docs.bachs.io/api-reference/payouts/delete-payout-destination)
- [Get Payout](https://docs.bachs.io/api-reference/payouts/get-payout)
- [Get Payout Destination](https://docs.bachs.io/api-reference/payouts/get-payout-destination)
- [Get Payout Schedule](https://docs.bachs.io/api-reference/payouts/get-payout-schedule)
- [List Payout Destinations](https://docs.bachs.io/api-reference/payouts/list-payout-destinations)
- [List Payouts](https://docs.bachs.io/api-reference/payouts/list-payouts)
- [Object](https://docs.bachs.io/api-reference/payouts/object)
- [Update Payout Destination](https://docs.bachs.io/api-reference/payouts/update-payout-destination)
- [Update Payout Schedule](https://docs.bachs.io/api-reference/payouts/update-payout-schedule)
- [Permissions](https://docs.bachs.io/api-reference/permissions)
- [Add A Person](https://docs.bachs.io/api-reference/persons/add-a-person)
- [Attach A Document To A Person](https://docs.bachs.io/api-reference/persons/attach-a-document-to-a-person)
- [List Persons](https://docs.bachs.io/api-reference/persons/list-persons)
- [Read A Person](https://docs.bachs.io/api-reference/persons/read-a-person)
- [Remove A Person](https://docs.bachs.io/api-reference/persons/remove-a-person)
- [Update A Person](https://docs.bachs.io/api-reference/persons/update-a-person)
- [Get A Platform Fee](https://docs.bachs.io/api-reference/platform-fees/get-a-platform-fee)
- [List Platform Fees](https://docs.bachs.io/api-reference/platform-fees/list-platform-fees)
- [Archive A Product](https://docs.bachs.io/api-reference/products/archive-a-product)
- [Create A Product](https://docs.bachs.io/api-reference/products/create-a-product)
- [List Products](https://docs.bachs.io/api-reference/products/list-products)
- [Object](https://docs.bachs.io/api-reference/products/object)
- [Retrieve A Product](https://docs.bachs.io/api-reference/products/retrieve-a-product)
- [Unarchive A Product](https://docs.bachs.io/api-reference/products/unarchive-a-product)
- [Update A Product](https://docs.bachs.io/api-reference/products/update-a-product)
- [List Banks](https://docs.bachs.io/api-reference/reference/list-banks)
- [List Business Structures](https://docs.bachs.io/api-reference/reference/list-business-structures)
- [List Mobile Money Providers](https://docs.bachs.io/api-reference/reference/list-mobile-money-providers)
- [List Product Categories](https://docs.bachs.io/api-reference/reference/list-product-categories)
- [Create Refund](https://docs.bachs.io/api-reference/refunds/create-refund)
- [Get Refund](https://docs.bachs.io/api-reference/refunds/get-refund)
- [Get Refund By Charge](https://docs.bachs.io/api-reference/refunds/get-refund-by-charge)
- [List Refunds](https://docs.bachs.io/api-reference/refunds/list-refunds)
- [Object](https://docs.bachs.io/api-reference/refunds/object)
- [Cancel Subscription](https://docs.bachs.io/api-reference/subscriptions/cancel-subscription)
- [Get Subscription](https://docs.bachs.io/api-reference/subscriptions/get-subscription)
- [List Subscriptions](https://docs.bachs.io/api-reference/subscriptions/list-subscriptions)
- [Object](https://docs.bachs.io/api-reference/subscriptions/object)
- [Update Subscription](https://docs.bachs.io/api-reference/subscriptions/update-subscription)
- [Success Responses](https://docs.bachs.io/api-reference/success-responses)
- [Create A Transfer](https://docs.bachs.io/api-reference/transfers/create-a-transfer)
- [Get A Transfer](https://docs.bachs.io/api-reference/transfers/get-a-transfer)
- [List Transfers](https://docs.bachs.io/api-reference/transfers/list-transfers)
- [Create A Webhook Endpoint](https://docs.bachs.io/api-reference/webhooks/create-a-webhook-endpoint)
- [Delete A Webhook Endpoint](https://docs.bachs.io/api-reference/webhooks/delete-a-webhook-endpoint)
- [List Events For An Endpoint](https://docs.bachs.io/api-reference/webhooks/list-events-for-an-endpoint)
- [List Webhook Endpoints](https://docs.bachs.io/api-reference/webhooks/list-webhook-endpoints)
- [List Webhook Events](https://docs.bachs.io/api-reference/webhooks/list-webhook-events)
- [Object](https://docs.bachs.io/api-reference/webhooks/object)
- [Replay Webhook Event](https://docs.bachs.io/api-reference/webhooks/replay-webhook-event)
- [Resend An Event To An Endpoint](https://docs.bachs.io/api-reference/webhooks/resend-an-event-to-an-endpoint)
- [Retrieve A Webhook Endpoint](https://docs.bachs.io/api-reference/webhooks/retrieve-a-webhook-endpoint)
- [Retrieve A Webhook Event](https://docs.bachs.io/api-reference/webhooks/retrieve-a-webhook-event)
- [Retrieve An Endpoint Event](https://docs.bachs.io/api-reference/webhooks/retrieve-an-endpoint-event)
- [Retrieve Endpoint Delivery Metrics](https://docs.bachs.io/api-reference/webhooks/retrieve-endpoint-delivery-metrics)
- [Rotate An Endpoints Signing Secret](https://docs.bachs.io/api-reference/webhooks/rotate-an-endpoints-signing-secret)
- [Update A Webhook Endpoint](https://docs.bachs.io/api-reference/webhooks/update-a-webhook-endpoint)
- [Authentication](https://docs.bachs.io/authentication)
- [Api](https://docs.bachs.io/changelog/api)
- [Product](https://docs.bachs.io/changelog/product)
- [Commands](https://docs.bachs.io/cli/commands)
- [Overview](https://docs.bachs.io/cli/overview)
- [Roadmap](https://docs.bachs.io/cli/roadmap)
- [Overview](https://docs.bachs.io/community/overview)
- [Projects](https://docs.bachs.io/community/projects)
- [Submit](https://docs.bachs.io/community/submit)
- [Accounts](https://docs.bachs.io/connect/accounts)
- [Acting As An Account](https://docs.bachs.io/connect/acting-as-an-account)
- [Balances](https://docs.bachs.io/connect/balances)
- [Become A Platform](https://docs.bachs.io/connect/become-a-platform)
- [Capabilities](https://docs.bachs.io/connect/capabilities)
- [Choose Your Integration](https://docs.bachs.io/connect/choose-your-integration)
- [Disputes](https://docs.bachs.io/connect/disputes)
- [Go Live](https://docs.bachs.io/connect/go-live)
- [Api Onboarding](https://docs.bachs.io/connect/guides/api-onboarding)
- [Create An Account](https://docs.bachs.io/connect/guides/create-an-account)
- [Hosted Onboarding](https://docs.bachs.io/connect/guides/hosted-onboarding)
- [Identity Verification](https://docs.bachs.io/connect/guides/identity-verification)
- [Monitor Onboarding](https://docs.bachs.io/connect/guides/monitor-onboarding)
- [Accept A Payment](https://docs.bachs.io/connect/marketplaces/accept-a-payment)
- [Overview](https://docs.bachs.io/connect/marketplaces/overview)
- [Refunds And Disputes](https://docs.bachs.io/connect/marketplaces/refunds-and-disputes)
- [Money Movement](https://docs.bachs.io/connect/money-movement)
- [Onboarding](https://docs.bachs.io/connect/onboarding)
- [Overview](https://docs.bachs.io/connect/overview)
- [Payout Networks](https://docs.bachs.io/connect/payout-networks)
- [Payouts](https://docs.bachs.io/connect/payouts)
- [Platform Fees](https://docs.bachs.io/connect/platform-fees)
- [Processing Fees](https://docs.bachs.io/connect/processing-fees)
- [Quickstart](https://docs.bachs.io/connect/quickstart)
- [Refunds](https://docs.bachs.io/connect/refunds)
- [Requirements](https://docs.bachs.io/connect/requirements)
- [Split Payments](https://docs.bachs.io/connect/split-payments)
- [Destination](https://docs.bachs.io/connect/split-payments/destination)
- [Direct](https://docs.bachs.io/connect/split-payments/direct)
- [Testing](https://docs.bachs.io/connect/testing)
- [Transfers](https://docs.bachs.io/connect/transfers)
- [Marketplace](https://docs.bachs.io/connect/walkthroughs/marketplace)
- [Saas](https://docs.bachs.io/connect/walkthroughs/saas)
- [Demo](https://docs.bachs.io/demo)
- [Api Keys](https://docs.bachs.io/developer-portal/api-keys)
- [Events](https://docs.bachs.io/developer-portal/events)
- [Local Testing](https://docs.bachs.io/developer-portal/local-testing)
- [Logs](https://docs.bachs.io/developer-portal/logs)
- [Overview](https://docs.bachs.io/developer-portal/overview)
- [Errors](https://docs.bachs.io/errors)
- [Age Requirements](https://docs.bachs.io/for-you/age-requirements)
- [Fees](https://docs.bachs.io/for-you/fees)
- [Payins Payouts](https://docs.bachs.io/for-you/payins-payouts)
- [Supported Businesses](https://docs.bachs.io/for-you/supported-businesses)
- [Supported Currencies](https://docs.bachs.io/for-you/supported-currencies)
- [Go Live](https://docs.bachs.io/go-live)
- [Adhoc Pricing](https://docs.bachs.io/guides/checkout/adhoc-pricing)
- [Any Currency Checkout](https://docs.bachs.io/guides/checkout/any-currency-checkout)
- [Checkout Sessions](https://docs.bachs.io/guides/checkout/checkout-sessions)
- [Overlay Checkout](https://docs.bachs.io/guides/checkout/overlay-checkout)
- [Create Portal Session](https://docs.bachs.io/guides/customer-portal/create-portal-session)
- [Overview](https://docs.bachs.io/guides/customer-portal/overview)
- [Customers](https://docs.bachs.io/guides/customers)
- [Dashboard Analytics](https://docs.bachs.io/guides/dashboard-analytics)
- [Idempotency](https://docs.bachs.io/guides/idempotency)
- [Pagination](https://docs.bachs.io/guides/pagination)
- [Deposit Limits](https://docs.bachs.io/guides/payments/deposit-limits)
- [Payment Method Support](https://docs.bachs.io/guides/payments/payment-method-support)
- [Overview](https://docs.bachs.io/guides/payouts/overview)
- [Payout Schedules](https://docs.bachs.io/guides/payouts/payout-schedules)
- [Payout Using Api](https://docs.bachs.io/guides/payouts/payout-using-api)
- [Local Pricing](https://docs.bachs.io/guides/products/local-pricing)
- [Overview](https://docs.bachs.io/guides/products/overview)
- [Refunds](https://docs.bachs.io/guides/refunds)
- [Failed Payments](https://docs.bachs.io/guides/subscriptions/failed-payments)
- [Manage](https://docs.bachs.io/guides/subscriptions/manage)
- [Overview](https://docs.bachs.io/guides/subscriptions/overview)
- [Proration](https://docs.bachs.io/guides/subscriptions/proration)
- [Trials](https://docs.bachs.io/guides/subscriptions/trials)
- [Transactions](https://docs.bachs.io/guides/transactions)
- [Account Updated](https://docs.bachs.io/guides/webhooks/events/account-updated)
- [Capability Updated](https://docs.bachs.io/guides/webhooks/events/capability-updated)
- [Checkout Completed](https://docs.bachs.io/guides/webhooks/events/checkout-completed)
- [Checkout Expired](https://docs.bachs.io/guides/webhooks/events/checkout-expired)
- [Collection Failed](https://docs.bachs.io/guides/webhooks/events/collection-failed)
- [Collection Succeeded](https://docs.bachs.io/guides/webhooks/events/collection-succeeded)
- [Collection Underpaid](https://docs.bachs.io/guides/webhooks/events/collection-underpaid)
- [Conversion Completed](https://docs.bachs.io/guides/webhooks/events/conversion-completed)
- [Conversion Failed](https://docs.bachs.io/guides/webhooks/events/conversion-failed)
- [Customer Created](https://docs.bachs.io/guides/webhooks/events/customer-created)
- [Customer Subscription Created](https://docs.bachs.io/guides/webhooks/events/customer-subscription-created)
- [Customer Subscription Deleted](https://docs.bachs.io/guides/webhooks/events/customer-subscription-deleted)
- [Customer Subscription Updated](https://docs.bachs.io/guides/webhooks/events/customer-subscription-updated)
- [Customer Updated](https://docs.bachs.io/guides/webhooks/events/customer-updated)
- [Dispute Created](https://docs.bachs.io/guides/webhooks/events/dispute-created)
- [Dispute Updated](https://docs.bachs.io/guides/webhooks/events/dispute-updated)
- [Invoice Created](https://docs.bachs.io/guides/webhooks/events/invoice-created)
- [Invoice Paid](https://docs.bachs.io/guides/webhooks/events/invoice-paid)
- [Invoice Payment Failed](https://docs.bachs.io/guides/webhooks/events/invoice-payment-failed)
- [Payout Created](https://docs.bachs.io/guides/webhooks/events/payout-created)
- [Payout Failed](https://docs.bachs.io/guides/webhooks/events/payout-failed)
- [Payout Paid](https://docs.bachs.io/guides/webhooks/events/payout-paid)
- [Refund Created](https://docs.bachs.io/guides/webhooks/events/refund-created)
- [Refund Failed](https://docs.bachs.io/guides/webhooks/events/refund-failed)
- [Refund Paid](https://docs.bachs.io/guides/webhooks/events/refund-paid)
- [Transfer Created](https://docs.bachs.io/guides/webhooks/events/transfer-created)
- [Overview](https://docs.bachs.io/guides/webhooks/overview)
- [Replay Events](https://docs.bachs.io/guides/webhooks/replay-events)
- [Sandbox](https://docs.bachs.io/integrate/sandbox)
- [Introduction](https://docs.bachs.io/introduction)

## References

[1]: https://bachs.io "Bachs.io official website"
[2]: https://docs.bachs.io/api-reference/overview "Bachs API reference overview"
[3]: https://docs.bachs.io/docs/openapi/openapi.json "Bachs official OpenAPI specification"
[4]: https://docs.bachs.io/api-reference/error-reference "Bachs API error reference"
