<?php

declare(strict_types=1);

namespace Agency\Integration\Test\Unit\Model\Erp;

use Agency\Integration\Api\Data\IntegrationResultInterface;
use Agency\Integration\Api\Data\IntegrationResultInterfaceFactory;
use Agency\Integration\Model\Erp\Client;
use Agency\Integration\Model\Erp\OrderPublisher;
use Agency\Integration\Model\IntegrationResult;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class OrderPublisherTest extends TestCase
{
    private OrderPublisher $publisher;
    private OrderRepositoryInterface|MockObject $repoMock;
    private Client|MockObject $clientMock;
    private IntegrationResultInterfaceFactory|MockObject $resultFactoryMock;

    protected function setUp(): void
    {
        $this->repoMock = $this->getMockBuilder(OrderRepositoryInterface::class)->getMock();
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->resultFactoryMock = $this->getMockBuilder(IntegrationResultInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $loggerMock = $this->getMockBuilder(LoggerInterface::class)->getMock();

        $this->publisher = new OrderPublisher(
            $this->repoMock,
            $this->clientMock,
            $this->resultFactoryMock,
            $loggerMock
        );
    }

    public function testSyncOrderSuccess()
    {
        $orderMock = $this->getMockBuilder(OrderInterface::class)->getMock();
        $orderMock->method('getIncrementId')->willReturn('100001');
        $orderMock->method('getBillingAddress')->willReturn(
            $this->getMockBuilder(OrderAddressInterface::class)->getMock()
        );

        $this->repoMock->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($orderMock);

        $this->clientMock->expects($this->once())
            ->method('postOrder')
            ->willReturn(['success' => true, 'erp_id' => '123']);

        // Mock Factory
        $resultMock = new IntegrationResult();
        $this->resultFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($resultMock);

        $result = $this->publisher->syncOrder(1);
        $this->assertEquals(IntegrationResultInterface::STATUS_SUCCESS, $result->getStatus());
    }
}
