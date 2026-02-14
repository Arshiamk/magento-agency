<?php
declare(strict_types=1);

namespace Agency\Integration\Observer;

use Agency\Integration\Api\Data\OrderExportMessageInterfaceFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Psr\Log\LoggerInterface;

class OrderPlacedObserver implements ObserverInterface
{
    private const TOPIC_NAME = 'agency.erp.order.export';

    public function __construct(
        private readonly PublisherInterface $publisher,
        private readonly OrderExportMessageInterfaceFactory $messageFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    public function execute(Observer $observer): void
    {
        try {
            /** @var \Magento\Sales\Model\Order $order */
            $order = $observer->getEvent()->getOrder();
            $orderId = (int) $order->getId();

            /** @var \Agency\Integration\Api\Data\OrderExportMessageInterface $message */
            $message = $this->messageFactory->create();
            $message->setOrderId($orderId);

            $this->publisher->publish(self::TOPIC_NAME, $message);

            $this->logger->info(sprintf('Queued order export for Order ID: %d', $orderId));
        } catch (\Exception $e) {
            $this->logger->error('Failed to queue order export: ' . $e->getMessage());
        }
    }
}
