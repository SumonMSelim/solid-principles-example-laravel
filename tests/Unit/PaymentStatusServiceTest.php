<?php

namespace Tests\Unit;

use App\Contracts\PaymentStatusInterface;
use App\Services\CreditCardPaymentStatusService;
use App\Services\PayPalPaymentStatusService;
use App\Services\WireTransferPaymentStatusService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaymentStatusServiceTest extends TestCase
{
    #[DataProvider('statusServiceProvider')]
    public function test_status_service_returns_success(string $class): void
    {
        $service = new $class;

        $this->assertInstanceOf(PaymentStatusInterface::class, $service);
        $this->assertSame('SUCCESS', $service->getStatus());
    }

    public static function statusServiceProvider(): array
    {
        return [
            'PayPal' => [PayPalPaymentStatusService::class],
            'Credit Card' => [CreditCardPaymentStatusService::class],
            'Wire Transfer' => [WireTransferPaymentStatusService::class],
        ];
    }
}
