<?php
declare(strict_types=1);

namespace Agency\CheckoutEnhancements\Model\Total;

use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

class HandlingFee extends AbstractTotal
{
    public function __construct()
    {
        $this->setCode('handling_fee');
    }

    public function collect(
        Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        // Simple logic: If subtotal > 100, add $10 handling fee
        // In reality, this would be driven by extension attributes or user selection
        $subtotal = $total->getTotalAmount('subtotal');
        if ($subtotal > 100) {
            $fee = 10.00;

            $total->setTotalAmount('handling_fee', $fee);
            $total->setBaseTotalAmount('handling_fee', $fee);

            $total->addTotalAmount('grand_total', $fee);
            $total->addBaseTotalAmount('grand_total', $fee);

            $quote->setHandlingFee($fee);
            $quote->setBaseHandlingFee($fee);
        }

        return $this;
    }

    public function fetch(Quote $quote, Total $total)
    {
        return [
            'code' => $this->getCode(),
            'title' => __('Handling Fee'),
            'value' => $total->getHandlingFee()
        ];
    }
}
