<?php

declare(strict_types=1);

namespace Agency\Core\Model;

use Magento\Framework\App\RequestInterface;

class CorrelationIdService
{
    private ?string $correlationId = null;

    public function __construct(
        private readonly RequestInterface $request
    ) {
    }

    public function getCorrelationId(): string
    {
        if ($this->correlationId === null) {
            $headerId = $this->request->getHeader('X-Correlation-Id');
            $this->correlationId = $headerId ?: $this->generateCorrelationId();
        }
        return $this->correlationId;
    }

    private function generateCorrelationId(): string
    {
        // Simple UUID v4 generation or similar
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
