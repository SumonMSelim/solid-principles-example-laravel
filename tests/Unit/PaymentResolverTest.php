<?php

namespace Tests\Unit;

use App\Contracts\PayableInterface;
use App\Contracts\PaymentGatewayResolverInterface;
use App\Contracts\PaymentStatusInterface;
use App\Contracts\PaymentStatusResolverInterface;
use App\Payment\PayPalPayment;
use App\Services\PaymentGatewayResolver;
use App\Services\PaymentStatusResolver;
use App\Services\WireTransferPaymentStatusService;
use Tests\TestCase;

class PaymentResolverTest extends TestCase
{
    public function test_payment_gateway_resolver_returns_payable_implementation(): void
    {
        $resolver = app(PaymentGatewayResolverInterface::class);

        $gateway = $resolver->resolve('PayPal');

        $this->assertInstanceOf(PayableInterface::class, $gateway);
        $this->assertInstanceOf(PayPalPayment::class, $gateway);
        $this->assertSame('OK', $gateway->pay()['status']);
    }

    public function test_payment_status_resolver_returns_status_service(): void
    {
        $resolver = app(PaymentStatusResolverInterface::class);

        $statusService = $resolver->resolve('Wire Transfer');

        $this->assertInstanceOf(PaymentStatusInterface::class, $statusService);
        $this->assertInstanceOf(WireTransferPaymentStatusService::class, $statusService);
        $this->assertSame('SUCCESS', $statusService->getStatus());
    }

    public function test_new_gateway_can_be_registered_without_changing_resolver(): void
    {
        config([
            'payments.gateways.Demo Gateway' => PayPalPayment::class,
        ]);

        $resolver = new PaymentGatewayResolver(app());

        $this->assertInstanceOf(PayPalPayment::class, $resolver->resolve('Demo Gateway'));
    }
}
