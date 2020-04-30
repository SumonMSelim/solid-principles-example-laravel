<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param  CreateUserRequest  $request
     * @param  UserRepository  $userRepository
     * @return RedirectResponse
     */
    public function register(CreateUserRequest $request, UserRepository $userRepository)
    {
        try {
            // Persist user to database
            $user = $userRepository->create($request);

            notify_success('Account registered');
            return redirect()->route('login');
        } catch (Exception $e) {
            notify_error($e->getMessage());
            return redirect()->back();
        }
    }
}
