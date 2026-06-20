<?php

namespace App\Services;

use App\Contracts\PaymentGatewayResolverInterface;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class PaymentOrchestrator
{
    public function __construct(
        private readonly PaymentGatewayResolverInterface $paymentGatewayResolver,
        private readonly NotificationService $notificationService,
    ) {}

    public function process(Request $request): array
    {
        $paymentType = (string) $request->input('payment_type', config('payments.default_gateway'));
        $gateway = $this->paymentGatewayResolver->resolve($paymentType);
        $response = $gateway->pay();

        $subscriber = Subscriber::create([
            'email' => (string) $request->input('email', 'subscriber@example.com'),
        ]);

        $this->notificationService->send($subscriber);

        return $response;
    }
}
