<?php
declare(strict_types=1);

namespace Agency\Integration\Api;

interface OrderSyncInterface
{
    /**
     * Sync an order to the ERP system.
     *
     * @param int $orderId
     * @return \Agency\Integration\Api\Data\IntegrationResultInterface
     */
    public function syncOrder(int $orderId): \Agency\Integration\Api\Data\IntegrationResultInterface;
}
