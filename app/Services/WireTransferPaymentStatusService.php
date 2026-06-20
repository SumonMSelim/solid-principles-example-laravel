<?php

namespace App\Services;

use App\Contracts\PaymentStatusInterface;

class WireTransferPaymentStatusService implements PaymentStatusInterface
{
    public function getStatus(): string
    {
        return 'SUCCESS';
    }
}
