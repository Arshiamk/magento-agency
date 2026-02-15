<?php

declare(strict_types=1);

namespace Agency\CheckoutEnhancements\Test\Unit\Model\Total;

use Agency\CheckoutEnhancements\Model\Total\HandlingFee;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use PHPUnit\Framework\TestCase;

class HandlingFeeTest extends TestCase
{
    public function testCollectAddsFeeWhenApplicable()
    {
        $model = new HandlingFee();
        $quoteMock = $this->createMock(Quote::class);
        $shippingAssignmentMock = $this->createMock(ShippingAssignmentInterface::class);
        $totalMock = $this->getMockBuilder(Total::class)
            ->setMethods(['getTotalAmount', 'setTotalAmount', 'setBaseTotalAmount', 'addTotalAmount', 'addBaseTotalAmount'])
            ->getMock();

        $totalMock->method('getTotalAmount')->with('subtotal')->willReturn(150.00);

        $totalMock->expects($this->once())->method('setTotalAmount')->with('handling_fee', 10.00);

        $model->collect($quoteMock, $shippingAssignmentMock, $totalMock);
    }
}
