<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function create(Request $request): User;

    public function getUsersFromYesterday();
}
