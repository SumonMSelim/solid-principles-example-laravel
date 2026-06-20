<?php

namespace App\Services;

use App\Contracts\AuthorizeableInterface;
use App\Contracts\PaymentStatusInterface;

class CreditCardPaymentStatusService implements AuthorizeableInterface, PaymentStatusInterface
{
    public function authorize(): void
    {
        // authorize with credit card provider
    }

    public function getStatus(): string
    {
        $this->authorize();

        return 'SUCCESS';
    }
}
