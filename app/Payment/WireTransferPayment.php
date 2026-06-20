<?php

namespace App\Payment;

use App\Contracts\PayableInterface;

class WireTransferPayment implements PayableInterface
{
    public function pay(): array
    {
        return ['status' => 'OK', 'gateway' => 'Wire Transfer'];
    }
}
