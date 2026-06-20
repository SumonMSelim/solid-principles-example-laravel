<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'password' => 'secret123',
        ];
    }

    public function test_api_register_creates_user(): void
    {
        $response = $this->postJson('/api/register', $this->validPayload());

        $response->assertCreated();
        $response->assertJsonPath('user.email', 'jane@example.com');
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }

    public function test_api_users_create_creates_user(): void
    {
        $response = $this->postJson('/api/users/create', $this->validPayload());

        $response->assertCreated();
        $response->assertJsonPath('user.email', 'jane@example.com');
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }

    public function test_api_registration_requires_valid_payload(): void
    {
        $response = $this->postJson('/api/register', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password']);
    }
}
