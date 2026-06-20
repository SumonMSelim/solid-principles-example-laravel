<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_payment_status_endpoint_returns_success(): void
    {
        $response = $this->get('/status');

        $response->assertOk();
        $response->assertSee('SUCCESS');
    }

    public function test_api_user_registration_creates_user(): void
    {
        $response = $this->postJson('/api/users/create', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'password' => 'secret123',
        ]);

        $response->assertCreated();
        $response->assertJsonPath('user.email', 'jane@example.com');
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }
}
