<?php

namespace App\Services;

use App\Contracts\AuthorizeableInterface;
use App\Contracts\PaymentStatusInterface;

class PayPalPaymentStatusService implements AuthorizeableInterface, PaymentStatusInterface
{
    public function authorize(): void
    {
        // authorize with PayPal
    }

    public function getStatus(): string
    {
        $this->authorize();

        return 'SUCCESS';
    }
}
