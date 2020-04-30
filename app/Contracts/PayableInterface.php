<?php

namespace App\Contracts;

interface PayableInterface
{
    /**
     * Process payment for a user.
     *
     * @return string
     */
    public function pay();
}
