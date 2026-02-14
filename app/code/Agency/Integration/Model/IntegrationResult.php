<?php
declare(strict_types=1);

namespace Agency\Integration\Model;

use Agency\Integration\Api\Data\IntegrationResultInterface;
use Magento\Framework\DataObject;

class IntegrationResult extends DataObject implements IntegrationResultInterface
{
    public function getStatus(): string
    {
        return (string) $this->getData('status');
    }

    public function getMessage(): string
    {
        return (string) $this->getData('message');
    }

    public function getRawData(): ?string
    {
        return $this->getData('raw_data') === null ? null : (string) $this->getData('raw_data');
    }
}
