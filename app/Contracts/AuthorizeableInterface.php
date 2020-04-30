<?php

namespace App\Contracts;

interface AuthorizeableInterface
{
    /**
     * Process payment for a user.
     *
     * @return string
     */
    public function authorize();
}
