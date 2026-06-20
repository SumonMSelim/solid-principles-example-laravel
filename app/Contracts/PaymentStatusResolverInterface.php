<?php

namespace App\Contracts;

interface PaymentStatusResolverInterface
{
    public function resolve(?string $paymentType = null): PaymentStatusInterface;
}
