<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @param  CreateUserRequest  $request
     * @param  UserRepository  $userRepository
     * @return RedirectResponse
     */
    public function store(CreateUserRequest $request, UserRepository $userRepository)
    {
        try {
            // Persist user to database
            $userRepository->create($request);

            notify_success('User created');
            return redirect()->route('users.index');
        } catch (Exception $e) {
            notify_error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * @param  UserRepository  $userRepository
     * @return JsonResponse
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->getUsersFromYesterday();

        return response()->json(['users' => $users], Response::HTTP_OK);
    }
}
