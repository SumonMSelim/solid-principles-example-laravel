<?php

namespace App\Http\Controllers;

use App\Contracts\UserRepositoryInterface;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{
    public function store(CreateUserRequest $request, UserRepositoryInterface $userRepository): RedirectResponse
    {
        try {
            $userRepository->create($request);

            notify_success('User created');

            return redirect()->route('users.index');
        } catch (Throwable $e) {
            notify_error($e->getMessage());

            return redirect()->back();
        }
    }

    public function index(UserRepositoryInterface $userRepository): JsonResponse
    {
        $users = $userRepository->getUsersFromYesterday();

        return response()->json(['users' => $users], Response::HTTP_OK);
    }
}
