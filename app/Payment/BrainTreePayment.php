<?php

namespace App\Payment;

use App\Contracts\PayableInterface;

class BrainTreePayment implements PayableInterface
{
    public function pay()
    {
        // logic goes here
        return 'OK';
    }
}
