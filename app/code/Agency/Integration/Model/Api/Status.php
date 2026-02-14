<?php
declare(strict_types=1);

namespace Agency\Integration\Model\Api;

use Agency\Integration\Api\StatusInterface;

class Status implements StatusInterface
{
    public function getStatus(): array
    {
        return [
            'erp_connection' => 'simulated',
            'last_sync' => date('c'),
            'queue_status' => 'healthy'
        ];
    }
}
