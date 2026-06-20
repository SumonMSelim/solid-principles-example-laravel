<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayResolverInterface;
use App\Contracts\PaymentStatusResolverInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repository\UserRepository;
use App\Services\PaymentGatewayResolver;
use App\Services\PaymentStatusResolver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PaymentGatewayResolverInterface::class, PaymentGatewayResolver::class);
        $this->app->bind(PaymentStatusResolverInterface::class, PaymentStatusResolver::class);
    }

    public function boot(): void
    {
        //
    }
}
