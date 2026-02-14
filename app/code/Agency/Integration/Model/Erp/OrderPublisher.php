<?php
declare(strict_types=1);

namespace Agency\Integration\Model\Erp;

use Agency\Integration\Api\Data\IntegrationResultInterface;
use Agency\Integration\Api\Data\IntegrationResultInterfaceFactory;
use Agency\Integration\Api\OrderSyncInterface;
use Agency\Integration\Model\Erp\Client;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class OrderPublisher implements OrderSyncInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly Client $client,
        private readonly IntegrationResultInterfaceFactory $resultFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    public function syncOrder(int $orderId): IntegrationResultInterface
    {
        try {
            $order = $this->orderRepository->get($orderId);

            // Transform Order to ERP Payload
            $payload = [
                'increment_id' => $order->getIncrementId(),
                'email' => $order->getCustomerEmail(),
                'total' => $order->getGrandTotal(),
                'currency' => $order->getOrderCurrencyCode(),
                'items' => [],
                'billing_address' => $order->getBillingAddress()->toArray(),
            ];

            foreach ($order->getAllVisibleItems() as $item) {
                $payload['items'][] = [
                    'sku' => $item->getSku(),
                    'qty' => $item->getQtyOrdered(),
                    'price' => $item->getPrice(),
                ];
            }

            // Send to ERP
            $response = $this->client->postOrder($payload);

            /** @var \Agency\Integration\Model\IntegrationResult $result */
            $result = $this->resultFactory->create();

            if (($response['success'] ?? false) === true) {
                $result->setData([
                    'status' => IntegrationResultInterface::STATUS_SUCCESS,
                    'message' => 'Exported with ERP ID: ' . ($response['erp_id'] ?? 'unknown'),
                    'raw_data' => json_encode($response)
                ]);
            } else {
                $result->setData([
                    'status' => IntegrationResultInterface::STATUS_ERROR,
                    'message' => 'ERP rejected order.',
                    'raw_data' => json_encode($response)
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            $this->logger->error('Order Sync Exception: ' . $e->getMessage());

            /** @var \Agency\Integration\Model\IntegrationResult $result */
            $result = $this->resultFactory->create();
            $result->setData([
                'status' => IntegrationResultInterface::STATUS_ERROR,
                'message' => $e->getMessage()
            ]);
            return $result;
        }
    }
}
