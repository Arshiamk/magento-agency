<?php

declare(strict_types=1);

namespace Agency\Integration\Model\Erp;

use Psr\Log\LoggerInterface;

/**
 * Simulated ERP/PIM HTTP client.
 *
 * This class is the deliberate seam between the integration flow and the
 * outside world: it returns canned responses so the full order-export and
 * product-import pipeline can be exercised without a live ERP or PIM.
 * A production implementation would issue real HTTP requests (e.g. via
 * Magento\Framework\HTTP\Client\Curl or a Guzzle-based client),
 * authenticate against the remote system, and handle transport errors,
 * timeouts and retries.
 */
class Client
{
    private const ENDPOINT = 'http://localhost:8080/erp/orders';

    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Post an order payload to the ERP and return its acknowledgement.
     *
     * @param array $payload
     * @return array
     * @throws \Exception
     */
    public function postOrder(array $payload): array
    {
        $this->logger->info('Sending order to ERP', ['endpoint' => self::ENDPOINT, 'payload' => $payload]);

        // Canned response emulating a successful ERP acknowledgement.
        return [
            'success' => true,
            'erp_id' => 'ERP-' . ($payload['increment_id'] ?? rand(1000, 9999))
        ];
    }

    /**
     * Fetch the product feed from the PIM.
     *
     * @return array
     */
    public function getProducts(): array
    {
        $this->logger->info('Fetching products from PIM');

        // Canned feed emulating a PIM export.
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
