<?php

namespace Tests\Unit;

use App\Contracts\PayableInterface;
use App\Contracts\PaymentGatewayResolverInterface;
use App\Contracts\PaymentStatusInterface;
use App\Contracts\PaymentStatusResolverInterface;
use App\Payment\BrainTreePayment;
use App\Payment\CreditCardPayment;
use App\Payment\PayPalPayment;
use App\Payment\WireTransferPayment;
use App\Services\CreditCardPaymentStatusService;
use App\Services\PaymentGatewayResolver;
use App\Services\PaymentStatusResolver;
use App\Services\PayPalPaymentStatusService;
use App\Services\WireTransferPaymentStatusService;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaymentResolverTest extends TestCase
{
    #[DataProvider('gatewayTypeProvider')]
    public function test_payment_gateway_resolver_returns_expected_gateway(string $type, string $expectedClass): void
    {
        $resolver = app(PaymentGatewayResolverInterface::class);

        $gateway = $resolver->resolve($type);

        $this->assertInstanceOf(PayableInterface::class, $gateway);
        $this->assertInstanceOf($expectedClass, $gateway);
    }

    public static function gatewayTypeProvider(): array
    {
        return [
            'PayPal' => ['PayPal', PayPalPayment::class],
            'Credit Card' => ['Credit Card', CreditCardPayment::class],
            'BrainTree' => ['BrainTree', BrainTreePayment::class],
            'Wire Transfer' => ['Wire Transfer', WireTransferPayment::class],
        ];
    }

    public function test_unknown_gateway_falls_back_to_default(): void
    {
        $resolver = app(PaymentGatewayResolverInterface::class);

        $gateway = $resolver->resolve('Unknown Gateway');

        $this->assertInstanceOf(WireTransferPayment::class, $gateway);
    }

    #[DataProvider('statusTypeProvider')]
    public function test_payment_status_resolver_returns_expected_service(string $type, string $expectedClass): void
    {
        $resolver = app(PaymentStatusResolverInterface::class);

        $statusService = $resolver->resolve($type);

        $this->assertInstanceOf(PaymentStatusInterface::class, $statusService);
        $this->assertInstanceOf($expectedClass, $statusService);
        $this->assertSame('SUCCESS', $statusService->getStatus());
    }

    public static function statusTypeProvider(): array
    {
        return [
            'PayPal' => ['PayPal', PayPalPaymentStatusService::class],
            'Credit Card' => ['Credit Card', CreditCardPaymentStatusService::class],
            'BrainTree' => ['BrainTree', CreditCardPaymentStatusService::class],
            'Wire Transfer' => ['Wire Transfer', WireTransferPaymentStatusService::class],
        ];
    }

    public function test_new_gateway_can_be_registered_without_changing_resolver(): void
    {
        config([
            'payments.gateways.Demo Gateway' => PayPalPayment::class,
        ]);

        $resolver = new PaymentGatewayResolver(app());

        $this->assertInstanceOf(PayPalPayment::class, $resolver->resolve('Demo Gateway'));
    }

    public function test_resolver_throws_when_no_gateway_is_configured(): void
    {
        config([
            'payments.gateways' => [],
            'payments.default_gateway' => null,
        ]);

        $resolver = new PaymentGatewayResolver(app());

        $this->expectException(InvalidArgumentException::class);

        $resolver->resolve('PayPal');
    }
}
