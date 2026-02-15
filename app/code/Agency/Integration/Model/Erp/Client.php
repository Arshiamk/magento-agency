<?php

declare(strict_types=1);

namespace Agency\Integration\Model\Erp;

use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class Client
{
    private const MOCK_ENDPOINT = 'http://localhost:8080/erp/orders';

    public function __construct(
        private readonly Curl $curl,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @param array $payload
     * @return array
     * @throws \Exception
     */
    public function postOrder(array $payload): array
    {
        $this->logger->info('Sending order to ERP', ['payload' => $payload]);

        // Simulate network call
        // In reality: $this->curl->post(self::MOCK_ENDPOINT, json_encode($payload));

        // Mock Response
        return [
            'success' => true,
            'erp_id' => 'ERP-' . ($payload['increment_id'] ?? rand(1000, 9999))
        ];
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        $this->logger->info('Fetching products from PIM');

        // Mock PIM Response
        return [
            [
                'sku' => 'PIM-001',
                'name' => 'Demo Product 1',
                'price' => 29.99,
                'qty' => 100
            ],
            [
                'sku' => 'PIM-002',
                'name' => 'Demo Product 2',
                'price' => 49.99,
                'qty' => 50
            ]
        ];
    }
}
