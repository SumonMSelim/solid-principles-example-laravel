<?php

namespace App\Contracts;

interface NotifiableInterface
{
    /**
     * Process payment for a user.
     *
     * @return string
     */
    public function getNotifyEmail();
}
