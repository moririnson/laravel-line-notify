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
        $this->notify(
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

    /**
     * Sends notifications to users or groups that are related to an access token.
     *
     * @param string $access_token
     * @param string $message
     * @param string $image_thumbnail
     * @param string $image_fullsize
     * @param string $image_file
     * @param int $sticker_package_id
     * @param int $sticker_id
     * @param bool $notification_disabled
     * @throws \Exception
     * @return void
     */
    private function notify(
        $access_token,
        $message,
        $image_thumbnail,
        $image_fullsize,
        $image_file,
        $sticker_package_id,
        $sticker_id,
        $notification_disabled
    ) {
        $url = self::API_BASE_URL . self::API_NOTIFY_ENDPOINT;
        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'multipart' => self::buildMultipart(
                $message,
                $image_thumbnail,
                $image_fullsize,
                $image_file,
                $sticker_package_id,
                $sticker_id,
                $notification_disabled
            ),
        ]);

        $status_code = $response->getStatusCode();
        $body = \json_decode($response->getBody()->getContents());
        if ($status_code >= 300 || $status_code < 200) {
            throw new \Exception($body->message);
        }
    }

    private static function buildMultipart(
        $message,
        $image_thumbnail,
        $image_fullsize,
        $image_file,
        $sticker_package_id,
        $sticker_id,
        $notification_disabled
    ) {
        $multipart = [
            [
                'name' => 'message',
                'contents' => $message,
            ]
        ];
        if (isset($image_thumbnail)) {
            $multipart[] = [
                'name' => 'imageThumbnail',
                'contents' => $image_thumbnail,
            ];
        }
        if (isset($image_fullsize)) {
            $multipart[] = [
                'name' => 'imageFullsize',
                'contents' => $image_fullsize,
            ];
        }
        if (isset($image_file)) {
            $multipart[] = [
                'name' => 'imageFile',
                'contents' => \fopen($image_file, 'r'),
            ];
        }
        if (isset($sticker_package_id)) {
            $multipart[] = [
                'name' => 'stickerPackageId',
                'contents' => $sticker_package_id,
            ];
        }
        if (isset($sticker_id)) {
            $multipart[] = [
                'name' => 'stickerId',
                'contents' => $sticker_id,
            ];
        }
        if (isset($notification_disabled)) {
            $multipart[] = [
                'name' => 'notificationDisabled',
                'contents' => $notification_disabled,
            ];
        }
        return $multipart;
    }
}
