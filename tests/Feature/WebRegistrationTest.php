<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_register_creates_user_and_redirects(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Alan',
            'last_name' => 'Turing',
            'email' => 'alan@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('type', 'success');
        $this->assertDatabaseHas('users', ['email' => 'alan@example.com']);
    }
}
