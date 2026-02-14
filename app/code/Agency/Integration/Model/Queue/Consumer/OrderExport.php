<?php
declare(strict_types=1);

namespace Agency\Integration\Model\Queue\Consumer;

use Agency\Integration\Api\Data\OrderExportMessageInterface;
use Agency\Integration\Api\OrderSyncInterface;
use Psr\Log\LoggerInterface;

class OrderExport
{
    public function __construct(
        private readonly OrderSyncInterface $orderSync,
        private readonly LoggerInterface $logger
    ) {
    }

    public function process(OrderExportMessageInterface $message): void
    {
        $orderId = $message->getOrderId();
        try {
            $this->logger->info(sprintf('Processing order export for Order ID: %d', $orderId));
            $result = $this->orderSync->syncOrder($orderId);

            if ($result->getStatus() === 'error') {
                $this->logger->error(sprintf('Order export failed for ID %d: %s', $orderId, $result->getMessage()));
                // In a real scenario, we might throw an exception to trigger a retry if using AMQP
            } else {
                $this->logger->info(sprintf('Order export successful for ID %d', $orderId));
            }
        } catch (\Exception $e) {
            $this->logger->critical(sprintf('Exception during order export for ID %d: %s', $orderId, $e->getMessage()));
        }
    }
}
