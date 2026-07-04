<?php

declare(strict_types=1);

namespace Agency\CheckoutEnhancements\Test\Unit\Model\Total;

use Agency\CheckoutEnhancements\Model\Total\HandlingFee;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Api\Data\ShippingInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Address\Total;
use PHPUnit\Framework\TestCase;

class HandlingFeeTest extends TestCase
{
    private HandlingFee $model;
    private Quote $quoteMock;
    private ShippingAssignmentInterface $shippingAssignmentMock;

    protected function setUp(): void
    {
        $this->model = new HandlingFee();
        $this->quoteMock = $this->createMock(Quote::class);

        $shippingMock = $this->createMock(ShippingInterface::class);
        $shippingMock->method('getAddress')->willReturn($this->createMock(Address::class));
        $this->shippingAssignmentMock = $this->createMock(ShippingAssignmentInterface::class);
        $this->shippingAssignmentMock->method('getShipping')->willReturn($shippingMock);
    }

    private function createTotal(float $subtotal): Total
    {
        $total = new Total([], $this->createMock(Json::class));
        $total->setTotalAmount('subtotal', $subtotal);
        $total->setBaseTotalAmount('subtotal', $subtotal);

        return $total;
    }

    public function testCollectAddsFeeWhenApplicable()
    {
        $total = $this->createTotal(150.00);

        $this->model->collect($this->quoteMock, $this->shippingAssignmentMock, $total);

        $this->assertEquals(10.00, $total->getTotalAmount('handling_fee'));
        $this->assertEquals(10.00, $total->getBaseTotalAmount('handling_fee'));
        $this->assertEquals(10.00, $total->getTotalAmount('grand_total'));
        $this->assertEquals(10.00, $total->getBaseTotalAmount('grand_total'));
    }

    public function testCollectSkipsFeeBelowThreshold()
    {
        $total = $this->createTotal(50.00);

        $this->model->collect($this->quoteMock, $this->shippingAssignmentMock, $total);

        $this->assertEquals(0, $total->getTotalAmount('handling_fee'));
        $this->assertEquals(0, $total->getTotalAmount('grand_total'));
    }
}
