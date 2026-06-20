<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_status_endpoint_returns_success(): void
    {
        $response = $this->get('/status');

        $response->assertOk();
        $response->assertSee('SUCCESS');
    }

    public function test_pay_processes_payment_and_creates_subscriber(): void
    {
        $response = $this->post('/pay', [
            'payment_type' => 'PayPal',
            'email' => 'payer@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'OK');
        $response->assertSessionHas('gateway', 'PayPal');
        $this->assertDatabaseHas('subscribers', ['email' => 'payer@example.com']);
    }
}
