<?php

namespace Moririnson\LineNotify\Tests\Mock;

use Moririnson\LineNotify\Messages\LineNotifyMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function toLINE($notifiable)
    {
        return (new LineNotifyMessage())->message($this->message);
    }
}
