# API Reference

## Integration Status

Get the current status of ERP and PIM integrations.

### REST

`GET /V1/agency/integration/status`

**Response:**

```json
{
  "erp_connection": "simulated",
  "last_sync": "2023-10-27T10:00:00+00:00",
  "queue_status": "healthy"
}
```

### GraphQL

```graphql
query {
  agencyIntegrationStatus {
    erp_connection
    last_sync
    queue_status
  }
}
```

## Internal Endpoints

### Webhook Receiver

`POST /agency-integration/webhook`

**Headers:**

- `X-Signature`: HMAC SHA256 signature of the payload using the webhook secret.

**Payload:**
JSON object containing event data.

**Response:**

- 200 OK: Processed
- 401 Unauthorized: Invalid Signature
