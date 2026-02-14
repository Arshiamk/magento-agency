<?php
declare(strict_types=1);

namespace Agency\Integration\Api\Data;

interface OrderExportMessageInterface
{
    /**
     * @return int
     */
    public function getOrderId(): int;

    /**
     * @param int $orderId
     * @return void
     */
    public function setOrderId(int $orderId): void;
}
