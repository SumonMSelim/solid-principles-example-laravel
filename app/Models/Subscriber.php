<?php

namespace App\Models;

use App\Contracts\NotifiableInterface;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model implements NotifiableInterface
{
    protected $fillable = [
        'email',
    ];

    public function subscribe(): void
    {
        // subscription logic goes here
    }

    public function unsubscribe(): void
    {
        // unsubscription logic goes here
    }

    public function getNotifyEmail(): string
    {
        return $this->email;
    }
}
