<?php

declare(strict_types=1);

namespace Agency\Integration\Api;

interface ProductImportInterface
{
    /**
     * Import products from PIM.
     *
     * @return \Agency\Integration\Api\Data\IntegrationResultInterface
     */
    public function importProducts(): \Agency\Integration\Api\Data\IntegrationResultInterface;
}
