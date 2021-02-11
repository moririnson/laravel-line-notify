<?php

namespace Moririnson\LINENotify\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Moririnson\LINENotify\Messages\LINENotifyMessage;

class LINENotifyChannel
{
    const API_BASE_URL = 'https://notify-api.line.me';
    const API_NOTIFY_ENDPOINT = '/api/notify';

    /**
     * Http client.
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Create a new line channel instance.
     *
     * @param  \GuzzleHttp\Client $client
     * @return void
     */
    public function __construct(Client $client)
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
        $this->notify($access_token, $params->message);
    }

    /**
     * Sends notifications to users or groups that are related to an access token.
     *
     * @param string $access_token
     * @param string $message
     * @throws \Exception
     * @return void
     */
    private function notify($access_token, $message)
    {
        $url = self::API_BASE_URL . self::API_NOTIFY_ENDPOINT;
        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'multipart' => [
                [
                    'name' => 'message',
                    'contents' => $message,
                ]
            ],
        ]);

        $status_code = $response->getStatusCode();
        $body = \json_decode($response->getBody()->getContents());
        if ($status_code >= 300 || $status_code < 200) {
            throw new \Exception($body->message);
        }
    }
}
