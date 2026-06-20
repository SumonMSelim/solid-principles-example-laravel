<?php

namespace App\Services;

use App\Contracts\NotifiableInterface;

class NotificationService
{
    public function send(NotifiableInterface $subscriber): void
    {
        $subscriber->getNotifyEmail();
    }
}
