<?php

declare(strict_types=1);

namespace Agency\Core\Test\Unit\Model;

use Agency\Core\Model\CorrelationIdService;
use Magento\Framework\App\RequestInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CorrelationIdServiceTest extends TestCase
{
    private CorrelationIdService $service;
    private RequestInterface|MockObject $requestMock;

    protected function setUp(): void
    {
        $this->requestMock = $this->getMockBuilder(RequestInterface::class)->getMock();
        $this->service = new CorrelationIdService($this->requestMock);
    }

    public function testGetCorrelationIdReturnsExistingHeader()
    {
        $this->requestMock->expects($this->once())
            ->method('getHeader')
            ->with('X-Correlation-Id')
            ->willReturn('12345');

        $this->assertEquals('12345', $this->service->getCorrelationId());
    }
}
