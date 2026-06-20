<?php

namespace App\Contracts;

use App\Contracts\PayableInterface;

interface PaymentGatewayResolverInterface
{
    public function resolve(string $paymentType): PayableInterface;
}
