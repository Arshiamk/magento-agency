<?php
declare(strict_types=1);

namespace Agency\Integration\Test\Unit\Model\Erp;

use Agency\Integration\Model\Erp\Client;
use Magento\Framework\HTTP\Client\Curl;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ClientTest extends TestCase
{
    private Client $client;
    private Curl|MockObject $curlMock;
    private LoggerInterface|MockObject $loggerMock;

    protected function setUp(): void
    {
        $this->curlMock = $this->getMockBuilder(Curl::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)->getMock();

        $this->client = new Client($this->curlMock, $this->loggerMock);
    }

    public function testPostOrderReturnsSuccess()
    {
        $result = $this->client->postOrder(['increment_id' => '001']);
        $this->assertTrue($result['success']);
        $this->assertStringContainsString('ERP-', $result['erp_id']);
    }
}
