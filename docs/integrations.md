# Integration Guide

## ERP Order Sync

- **Direction**: Outbound (Push)
- **Trigger**: Order Placed Event
- **Mechanism**:
  1. Order is placed.
  2. Event Observer acts as a Producer, publishing a message to `agency.erp.order.export`.
  3. The message is persisted in `queue_message` (DB or RabbitMQ).
  4. Cron/Consumer picks up the message and calls `OrderPublisher`.
  5. `OrderPublisher` calls the ERP Endpoint.
- **Retries**: Configured via `queue_consumer.xml` (default retry policy).

## PIM Product Import

- **Direction**: Inbound (Pull)
- **Trigger**: Cron Schedule (`0 1 * * *`)
- **Mechanism**:
  1. Cron job triggers `ProductImportCron`.
  2. `ProductImporter` fetches JSON from PIM.
  3. Products are created/updated via `ProductRepository`.

## Webhooks

- **Direction**: Inbound (Push)
- **Security**: HMAC SHA256 Signature required.
- **Header**: `X-Signature`
- **Calculation**: `hash_hmac('sha256', payload, secret)`
