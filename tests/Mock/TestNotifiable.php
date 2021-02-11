<?php

namespace Moririnson\LINENotify\Tests\Mock;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    const ACCESS_TOKEN = 'access token for test.';

    /**
     * Route notifications for the LINE Notify channel.
     *
     * @return string
     */
    public function routeNotificationForLINE()
    {
        return self::ACCESS_TOKEN;
    }
}
