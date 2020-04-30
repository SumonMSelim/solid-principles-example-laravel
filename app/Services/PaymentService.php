<?php

namespace App\Services;

use App\Payment\BrainTreePayment;
use App\Payment\CreditCardPayment;
use App\Payment\PayPalPayment;
use App\Payment\WireTransferPayment;

class PaymentService
{
    public function initialize(string $payment_type)
    {
        switch ($payment_type) {
            case 'PayPal':
                return new PayPalPayment();
                break;
            case 'Credit Card':
                return new CreditCardPayment();
                break;
            case 'BrainTree':
                return new BrainTreePayment();
                break;
            default:
                return new WireTransferPayment();
        }
    }
}
