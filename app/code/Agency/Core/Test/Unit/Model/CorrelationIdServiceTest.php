<?php

declare(strict_types=1);

namespace Agency\Core\Test\Unit\Model;

use Agency\Core\Model\CorrelationIdService;
use Magento\Framework\App\Request\Http;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CorrelationIdServiceTest extends TestCase
{
    private CorrelationIdService $service;
    private Http|MockObject $requestMock;

    protected function setUp(): void
    {
        $this->requestMock = $this->createMock(Http::class);
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

    public function testGetCorrelationIdGeneratesUuidWhenHeaderMissing()
    {
        $this->requestMock->expects($this->once())
            ->method('getHeader')
            ->with('X-Correlation-Id')
            ->willReturn(false);

        $correlationId = $this->service->getCorrelationId();

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $correlationId
        );
        $this->assertSame($correlationId, $this->service->getCorrelationId(), 'ID must be stable per request');
    }
}
