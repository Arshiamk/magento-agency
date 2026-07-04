<?php

declare(strict_types=1);

namespace Agency\Core\Model;

use Magento\Framework\App\Request\Http;

/**
 * Resolves a correlation identifier for the current request.
 *
 * Reuses the X-Correlation-Id header when an upstream system (gateway,
 * ERP, load balancer) already assigned one, otherwise generates a new
 * UUID. The resolved value is attached to every log record via
 * Agency\Core\Logger\Processor\CorrelationIdProcessor so a single
 * transaction can be traced across services.
 */
class CorrelationIdService
{
    private ?string $correlationId = null;

    public function __construct(
        private readonly Http $request
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

    /**
     * Generate an RFC 4122 version 4 formatted identifier.
     */
    private function generateCorrelationId(): string
    {
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
