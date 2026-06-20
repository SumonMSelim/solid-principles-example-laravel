<?php

namespace App\Payment;

use App\Contracts\PayableInterface;

class CreditCardPayment implements PayableInterface
{
    public function pay(): array
    {
        return ['status' => 'OK', 'gateway' => 'Credit Card'];
    }
}
