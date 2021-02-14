<?php

namespace Moririnson\LINENotify\Clients;

use GuzzleHttp\Client;
use Moririnson\LINENotify\Constants;

class LINENotifyClient
{
    /**
     * Http client.
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Create a new line notify client instance.
     *
     * @param  \GuzzleHttp\Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sends notifications to users or groups that are related to an access token.
     *
     * @param string $access_token
     * @param string $message
     * @param string|null $image_thumbnail
     * @param string|null $image_fullsize
     * @param string|null $image_file
     * @param int|null $sticker_package_id
     * @param int|null $sticker_id
     * @param bool|null $notification_disabled
     * @throws \Exception
     * @return void
     */
    public function notify(
        $access_token,
        $message,
        $image_thumbnail = null,
        $image_fullsize = null,
        $image_file = null,
        $sticker_package_id = null,
        $sticker_id = null,
        $notification_disabled = null
    ) {
        $response = $this->client->post(Constants::API_NOTIFY_ENDPOINT, [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'multipart' => self::buildNotifyMultipart(
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

    private static function buildNotifyMultipart(
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
