<?php

namespace Tests\Unit;

use App\Models\Subscriber;
use App\Services\PaymentOrchestrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PaymentOrchestratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_resolves_payment_and_creates_subscriber(): void
    {
        $orchestrator = app(PaymentOrchestrator::class);

        $response = $orchestrator->process(new Request([
            'payment_type' => 'PayPal',
            'email' => 'payer@example.com',
        ]));

        $this->assertSame('OK', $response['status']);
        $this->assertSame('PayPal', $response['gateway']);
        $this->assertDatabaseHas('subscribers', ['email' => 'payer@example.com']);
    }

    public function test_process_uses_default_gateway_and_email_when_not_provided(): void
    {
        $orchestrator = app(PaymentOrchestrator::class);

        $response = $orchestrator->process(new Request);

        $this->assertSame('Wire Transfer', $response['gateway']);
        $this->assertDatabaseHas('subscribers', ['email' => 'subscriber@example.com']);
    }
}
