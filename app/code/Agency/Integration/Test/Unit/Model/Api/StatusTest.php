<?php
declare(strict_types=1);

namespace Agency\Integration\Test\Unit\Model\Api;

use Agency\Integration\Model\Api\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testGetStatusReturnsArray()
    {
        $model = new Status();
        $result = $model->getStatus();
        $this->assertArrayHasKey('erp_connection', $result);
        $this->assertEquals('simulated', $result['erp_connection']);
    }
}
