<?php

namespace App\Payment;

use App\Contracts\PayableInterface;

class PayPalPayment implements PayableInterface
{
    public function pay(): array
    {
        return ['status' => 'OK', 'gateway' => 'PayPal'];
    }
}
