<?php

namespace Tests\Unit;

use App\Payment\BrainTreePayment;
use App\Payment\CreditCardPayment;
use App\Payment\PayPalPayment;
use App\Payment\WireTransferPayment;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    #[DataProvider('gatewayProvider')]
    public function test_gateway_returns_expected_response(string $class, string $gatewayName): void
    {
        $gateway = new $class;

        $this->assertSame([
            'status' => 'OK',
            'gateway' => $gatewayName,
        ], $gateway->pay());
    }

    public static function gatewayProvider(): array
    {
        return [
            'PayPal' => [PayPalPayment::class, 'PayPal'],
            'Credit Card' => [CreditCardPayment::class, 'Credit Card'],
            'BrainTree' => [BrainTreePayment::class, 'BrainTree'],
            'Wire Transfer' => [WireTransferPayment::class, 'Wire Transfer'],
        ];
    }
}
