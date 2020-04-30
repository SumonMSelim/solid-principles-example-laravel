<?php

namespace App\Payment;

class PaymentFactory
{
    /**
     * PaymentFactory constructor.
     * @param  string|null  $paymentType
     */
    public function __construct(?string $paymentType)
    {
        switch ($paymentType) {
            case 'PayPal':
                return new PayPalPayment();
                break;
            case 'Credit Card':
                return new CreditCardPayment();
                break;
            default:
                return new WireTransferPayment();
        }
    }
}
