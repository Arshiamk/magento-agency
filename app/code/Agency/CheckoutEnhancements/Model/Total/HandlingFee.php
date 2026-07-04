<?php

declare(strict_types=1);

namespace Agency\CheckoutEnhancements\Model\Total;

use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

/**
 * Custom quote total that applies a flat handling fee to larger carts.
 *
 * The threshold and amount are fixed for the demo; a production
 * implementation would source both from store configuration and/or a
 * quote extension attribute set by the customer during checkout.
 */
class HandlingFee extends AbstractTotal
{
    private const SUBTOTAL_THRESHOLD = 100.00;
    private const FEE_AMOUNT = 10.00;

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

        $subtotal = $total->getTotalAmount('subtotal');
        if ($subtotal > self::SUBTOTAL_THRESHOLD) {
            $fee = self::FEE_AMOUNT;

            $total->setTotalAmount('handling_fee', $fee);
            $total->setBaseTotalAmount('handling_fee', $fee);

            $total->addTotalAmount('grand_total', $fee);
            $total->addBaseTotalAmount('grand_total', $fee);

            $quote->setData('handling_fee', $fee);
            $quote->setData('base_handling_fee', $fee);
        }

        return $this;
    }

    public function fetch(Quote $quote, Total $total)
    {
        return [
            'code' => $this->getCode(),
            'title' => __('Handling Fee'),
            'value' => $total->getTotalAmount($this->getCode())
        ];
    }
}
