<?php

namespace App\Http\Controllers;

use App\Contracts\NotifiableInterface;
use App\Models\Subscriber;
use App\Models\User;
use App\Payment\BrainTreePayment;
use App\Services\CreditCardPaymentStatusService;
use App\Services\NotificationService;
use App\Services\PaymentService;
use App\Services\PayPalPaymentStatusService;
use App\Services\WireTransferPaymentStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @param  Request  $request
     * @param  PaymentService  $paymentService
     * @param  NotificationService  $notificationService
     * @return RedirectResponse
     */
    public function pay(Request $request, PaymentService $paymentService, NotificationService $notificationService)
    {
        $payment_type = $request->input('payment_type');

        $payment = $paymentService->initialize($payment_type);
        $response = $payment->pay();

        // create a subscriber with this user data
        $subscriber = User::create();

        // send notification
        $notificationService->send($subscriber);

        return redirect()->back()->with($response);
    }

    /**
     * @return string
     */
    public function status()
    {

        $status = new WireTransferPaymentStatusService();

        return $status->getStatus();
    }
}
