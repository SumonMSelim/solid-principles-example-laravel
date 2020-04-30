<?php

namespace App\Services;

use App\Contracts\AuthorizeableInterface;

class PayPalPaymentStatusService implements AuthorizeableInterface
{

    public function authorize()
    {
        // authorize with PayPal
    }

    public function getStatus()
    {
        $this->authorize();

        return 'SUCCESS';
    }
}
