<?php

namespace App\Repository;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function create(Request $request): User
    {
        return User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
    }

    public function getUsersFromYesterday()
    {
        return $this->user->newQuery()
            ->where('created_at', '>=', Carbon::yesterday())
            ->get();
    }
}
