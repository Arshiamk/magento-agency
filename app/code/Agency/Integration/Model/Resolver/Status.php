<?php

declare(strict_types=1);

namespace Agency\Integration\Model\Resolver;

use Agency\Integration\Api\StatusInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Status implements ResolverInterface
{
    public function __construct(
        private readonly StatusInterface $statusService
    ) {
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        return $this->statusService->getStatus();
    }
}
