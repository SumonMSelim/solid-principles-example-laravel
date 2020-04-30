<?php

namespace App\Payment;

use App\Contracts\PayableInterface;

class CreditCardPayment implements PayableInterface
{
    public function pay()
    {
        // logic goes here
        return 'OK';
    }
}
