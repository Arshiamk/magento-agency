<?php

declare(strict_types=1);

namespace Agency\Core\Logger\Processor;

use Agency\Core\Model\CorrelationIdService;
use Monolog\Processor\ProcessorInterface;

class CorrelationIdProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CorrelationIdService $correlationIdService
    ) {
    }

    public function __invoke(array $record): array
    {
        $record['extra']['correlation_id'] = $this->correlationIdService->getCorrelationId();
        return $record;
    }
}
