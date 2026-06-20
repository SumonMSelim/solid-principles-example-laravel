<?php

namespace Tests\Unit;

use App\Contracts\NotifiableInterface;
use App\Models\Subscriber;
use App\Services\NotificationService;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    public function test_send_accepts_notifiable_implementation(): void
    {
        $subscriber = new Subscriber(['email' => 'notify@example.com']);
        $service = new NotificationService;

        $service->send($subscriber);

        $this->assertSame('notify@example.com', $subscriber->getNotifyEmail());
        $this->assertInstanceOf(NotifiableInterface::class, $subscriber);
    }
}
