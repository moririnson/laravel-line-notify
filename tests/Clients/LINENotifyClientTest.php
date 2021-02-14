<?php

namespace Moririnson\LINENotify\Tests\Clients;

use GuzzleHttp\Client;
use Mockery;
use Moririnson\LINENotify\Clients\LINENotifyClient;
use Moririnson\LINENotify\Tests\Mock\TestNotifiable;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;

class LINENotifyClientTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
    }

    public function testNotify()
    {
        $message = 'test message.';
        $image_thumbnail = 'test1024.jpg';
        $image_fullsize = 'test2048.jpg';
        $sticker_package_id = 1;
        $sticker_id = 1;
        $notification_disabled = false;
        $response = new Response(200);
        $this->client->shouldReceive('post')
            ->once()
            ->with(Mockery::any(), [
                'headers' => [
                    'Authorization' => 'Bearer '. TestNotifiable::ACCESS_TOKEN,
                ],
                'multipart' => [
                    [
                        'name' => 'message',
                        'contents' => $message,
                    ], [
                        'name' => 'imageThumbnail',
                        'contents' => $image_thumbnail,
                    ], [
                        'name' => 'imageFullsize',
                        'contents' => $image_fullsize,
                    ], [
                        'name' => 'stickerPackageId',
                        'contents' => $sticker_package_id,
                    ], [
                        'name' => 'stickerId',
                        'contents' => $sticker_id,
                    ], [
                        'name' => 'notificationDisabled',
                        'contents' => $notification_disabled,
                    ]
                ],
            ])
            ->andReturn($response);
        
        $client = new LINENotifyClient($this->client);
        $client->notify(
            TestNotifiable::ACCESS_TOKEN,
            $message,
            $image_thumbnail,
            $image_fullsize,
            null,
            $sticker_package_id,
            $sticker_id,
            $notification_disabled
        );
    }
}
