<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentStatusResolverInterface;
use App\Http\Requests\CreateUserRequest;
use App\Contracts\UserRepositoryInterface;
use App\Services\PaymentOrchestrator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request, UserRepositoryInterface $userRepository): RedirectResponse
    {
        try {
            $userRepository->create($request);

            notify_success('Account registered');

            return redirect('/');
        } catch (Throwable $e) {
            notify_error($e->getMessage());

            return redirect()->back();
        }
    }
}
