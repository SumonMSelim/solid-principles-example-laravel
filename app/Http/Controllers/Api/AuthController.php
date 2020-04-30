<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        // Validation
        $this->validate($request, [
            'first_name' => 'required|regex:/^[a-zA-Z0-9\'\s]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z0-9\'\s]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        try {
            // Persist user to database
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->save();

            return response()->json(['user' => $user], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
