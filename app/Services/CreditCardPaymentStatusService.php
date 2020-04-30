<?php

namespace App\Services;

use App\Contracts\AuthorizeableInterface;

class CreditCardPaymentStatusService implements AuthorizeableInterface
{

    public function authorize()
    {
        // authorize with Credit Card Payment gateway provider
    }

    public function getStatus()
    {
        $this->authorize();

        return 'SUCCESS';
    }
}
