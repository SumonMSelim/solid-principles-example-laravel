<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_index_returns_users_from_yesterday(): void
    {
        User::factory()->create([
            'email' => 'recent@example.com',
            'created_at' => now()->subDay(),
        ]);

        $response = $this->get('/users/index');

        $response->assertOk();
        $response->assertJsonPath('users.0.email', 'recent@example.com');
    }

    public function test_users_create_persists_user(): void
    {
        $response = $this->post('/users/create', [
            'first_name' => 'Grace',
            'last_name' => 'Hopper',
            'email' => 'grace@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('type', 'success');
        $this->assertDatabaseHas('users', ['email' => 'grace@example.com']);
    }
}
