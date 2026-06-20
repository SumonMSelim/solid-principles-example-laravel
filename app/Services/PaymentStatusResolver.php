<?php

namespace App\Services;

use App\Contracts\PaymentStatusInterface;
use App\Contracts\PaymentStatusResolverInterface;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class PaymentStatusResolver implements PaymentStatusResolverInterface
{
    public function __construct(
        private readonly Container $container,
    ) {}

    public function resolve(?string $paymentType = null): PaymentStatusInterface
    {
        $paymentType ??= config('payments.default_status_gateway');
        $services = config('payments.status_services', []);
        $class = $services[$paymentType] ?? $services[config('payments.default_status_gateway')] ?? null;

        if ($class === null) {
            throw new InvalidArgumentException("Unsupported payment status type [{$paymentType}].");
        }

        $service = $this->container->make($class);

        if (! $service instanceof PaymentStatusInterface) {
            throw new InvalidArgumentException("Payment status service [{$class}] must implement PaymentStatusInterface.");
        }

        return $service;
    }
}
