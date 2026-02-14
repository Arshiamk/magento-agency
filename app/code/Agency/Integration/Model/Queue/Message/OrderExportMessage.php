<?php
declare(strict_types=1);

namespace Agency\Integration\Model\Queue\Message;

use Agency\Integration\Api\Data\OrderExportMessageInterface;
use Magento\Framework\DataObject;

class OrderExportMessage extends DataObject implements OrderExportMessageInterface
{
    public function getOrderId(): int
    {
        return (int) $this->getData('order_id');
    }

    public function setOrderId(int $orderId): void
    {
        $this->setData('order_id', $orderId);
    }
}
