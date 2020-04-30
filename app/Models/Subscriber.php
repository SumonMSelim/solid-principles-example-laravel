<?php

namespace App\Models;

use App\Contracts\NotifiableInterface;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model implements NotifiableInterface
{
    public function  subscribe()
    {
        // logic goes here
    }

    public function unsubscribe()
    {
        // logic goes here
    }

    public function getNotifyEmail()
    {
        // gets email address for sending notification
    }
}
