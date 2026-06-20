<?php

namespace App\Services;

use App\Contracts\PayableInterface;
use App\Contracts\PaymentGatewayResolverInterface;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class PaymentGatewayResolver implements PaymentGatewayResolverInterface
{
    public function __construct(
        private readonly Container $container,
    ) {}

    public function resolve(string $paymentType): PayableInterface
    {
        $gateways = config('payments.gateways', []);
        $class = $gateways[$paymentType] ?? $gateways[config('payments.default_gateway')] ?? null;

        if ($class === null) {
            throw new InvalidArgumentException("Unsupported payment type [{$paymentType}].");
        }

        $gateway = $this->container->make($class);

        if (! $gateway instanceof PayableInterface) {
            throw new InvalidArgumentException("Payment gateway [{$class}] must implement PayableInterface.");
        }

        return $gateway;
    }
}
