<?php

namespace App\Contracts;

interface PayableInterface
{
    public function pay(): array;
}
