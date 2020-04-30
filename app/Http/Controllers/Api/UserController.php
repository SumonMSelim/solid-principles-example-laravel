<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @param  CreateUserRequest  $request
     * @param  UserRepository  $userRepository
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request, UserRepository $userRepository)
    {
        try {
            // Persist user to database
            $userRepository->create($request);

            return response()->json(['user' => $user], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
