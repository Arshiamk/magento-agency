<?php
declare(strict_types=1);

namespace Agency\Integration\Test\Unit\Model;

use Agency\Integration\Model\IntegrationResult;
use PHPUnit\Framework\TestCase;

class IntegrationResultTest extends TestCase
{
    public function testGettersReturnData()
    {
        $result = new IntegrationResult();
        $result->setData([
            'status' => 'success',
            'message' => 'Done',
            'raw_data' => '{"a":1}'
        ]);

        $this->assertEquals('success', $result->getStatus());
        $this->assertEquals('Done', $result->getMessage());
        $this->assertEquals('{"a":1}', $result->getRawData());
    }
}
