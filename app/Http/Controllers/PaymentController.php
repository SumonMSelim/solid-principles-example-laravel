<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentStatusResolverInterface;
use App\Services\PaymentOrchestrator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(
        Request $request,
        PaymentOrchestrator $paymentOrchestrator,
    ): RedirectResponse {
        $response = $paymentOrchestrator->process($request);

        return redirect()->back()->with($response);
    }

    public function status(PaymentStatusResolverInterface $paymentStatusResolver): string
    {
        return $paymentStatusResolver->resolve()->getStatus();
    }
}
