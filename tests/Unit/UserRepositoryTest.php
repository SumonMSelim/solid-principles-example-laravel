<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_persists_user_from_request(): void
    {
        $repository = app(UserRepository::class);

        $user = $repository->create(new Request([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => 'secret123',
        ]));

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
        ]);
    }

    public function test_get_users_from_yesterday_returns_recent_users_only(): void
    {
        $repository = app(UserRepository::class);

        User::factory()->create([
            'email' => 'recent@example.com',
            'created_at' => now()->subDay(),
        ]);

        User::factory()->create([
            'email' => 'old@example.com',
            'created_at' => now()->subDays(5),
        ]);

        $users = $repository->getUsersFromYesterday();

        $this->assertTrue($users->contains('email', 'recent@example.com'));
        $this->assertFalse($users->contains('email', 'old@example.com'));
    }
}
