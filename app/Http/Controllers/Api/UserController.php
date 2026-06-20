<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{
    public function store(CreateUserRequest $request, UserRepositoryInterface $userRepository): JsonResponse
    {
        try {
            $user = $userRepository->create($request);

            return response()->json(['user' => $user], Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
