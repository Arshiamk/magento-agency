<?php

declare(strict_types=1);

namespace Agency\Integration\Test\Unit\Model\Erp;

use Agency\Integration\Model\Erp\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ClientTest extends TestCase
{
    private Client $client;
    private LoggerInterface|MockObject $loggerMock;

    protected function setUp(): void
    {
        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)->getMock();

        $this->client = new Client($this->loggerMock);
    }

    public function testPostOrderReturnsSuccess()
    {
        $result = $this->client->postOrder(['increment_id' => '001']);
        $this->assertTrue($result['success']);
        $this->assertStringContainsString('ERP-', $result['erp_id']);
    }
}
