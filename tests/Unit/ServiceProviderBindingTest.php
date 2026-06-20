<?php

namespace Tests\Unit;

use App\Contracts\PaymentGatewayResolverInterface;
use App\Contracts\PaymentStatusResolverInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repository\UserRepository;
use App\Services\PaymentGatewayResolver;
use App\Services\PaymentStatusResolver;
use Tests\TestCase;

class ServiceProviderBindingTest extends TestCase
{
    public function test_container_resolves_interface_bindings(): void
    {
        $this->assertInstanceOf(UserRepository::class, app(UserRepositoryInterface::class));
        $this->assertInstanceOf(PaymentGatewayResolver::class, app(PaymentGatewayResolverInterface::class));
        $this->assertInstanceOf(PaymentStatusResolver::class, app(PaymentStatusResolverInterface::class));
    }
}
