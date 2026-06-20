<?php

namespace App\Contracts;

interface AuthorizeableInterface
{
    public function authorize(): void;
}
