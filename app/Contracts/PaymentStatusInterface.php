<?php

namespace App\Contracts;

interface PaymentStatusInterface
{
    public function getStatus(): string;
}
