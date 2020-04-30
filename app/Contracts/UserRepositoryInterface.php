<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function create(Request $request);

    public function getUsersFromYesterday();
}
