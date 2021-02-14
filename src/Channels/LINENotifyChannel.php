<?php

namespace Moririnson\LINENotify\Channels;

use Moririnson\LINENotify\Clients\LINENotifyClient;
use Illuminate\Notifications\Notification;
use Moririnson\LINENotify\Constants;
use Moririnson\LINENotify\Messages\LINENotifyMessage;

class LINENotifyChannel
{
    /**
     * Http client.
     *
     * @var \Moririnson\LINENotify\Clients\LINENotifyClient
     */
    private $client;

    /**
     * Create a new line channel instance.
     *
     * @param  \Moririnson\LINENotify\Clients\LINENotifyClient $client
     * @return void
     */
    public function __construct(LINENotifyClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $access_token = $notifiable->routeNotificationFor('LINE');
        if (!isset($access_token)) {
            return;
        }

        $params = $notification->toLINE($notifiable);
        $this->client->notify(
            $access_token,
            $params->message,
            $params->image_thumbnail,
            $params->image_fullsize,
            $params->image_file,
            $params->sticker_package_id,
            $params->sticker_id,
            $params->notification_disabled
        );
    }
}
