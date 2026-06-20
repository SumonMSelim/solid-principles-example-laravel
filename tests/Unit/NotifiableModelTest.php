<?php

namespace Tests\Unit;

use App\Models\Subscriber;
use App\Models\User;
use Tests\TestCase;

class NotifiableModelTest extends TestCase
{
    public function test_user_returns_notify_email(): void
    {
        $user = new User(['email' => 'user@example.com']);

        $this->assertSame('user@example.com', $user->getNotifyEmail());
    }

    public function test_subscriber_returns_notify_email(): void
    {
        $subscriber = new Subscriber(['email' => 'subscriber@example.com']);

        $this->assertSame('subscriber@example.com', $subscriber->getNotifyEmail());
    }
}
