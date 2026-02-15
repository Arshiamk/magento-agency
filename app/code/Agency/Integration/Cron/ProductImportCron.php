<?php

declare(strict_types=1);

namespace Agency\Integration\Cron;

use Agency\Integration\Api\ProductImportInterface;
use Psr\Log\LoggerInterface;

class ProductImportCron
{
    public function __construct(
        private readonly ProductImportInterface $importer,
        private readonly LoggerInterface $logger
    ) {
    }

    public function execute(): void
    {
        $this->logger->info('Starting scheduled product import.');
        $result = $this->importer->importProducts();
        $this->logger->info(
            'Product import finished.',
            ['status' => $result->getStatus(), 'message' => $result->getMessage()]
        );
    }
}
