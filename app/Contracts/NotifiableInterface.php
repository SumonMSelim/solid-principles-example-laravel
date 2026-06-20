<?php

namespace App\Contracts;

interface NotifiableInterface
{
    public function getNotifyEmail(): string;
}
