<?php

namespace App\Payment;

use App\Contracts\PayableInterface;

class BrainTreePayment implements PayableInterface
{
    public function pay(): array
    {
        return ['status' => 'OK', 'gateway' => 'BrainTree'];
    }
}
