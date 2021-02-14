<?php

namespace Moririnson\LINENotify\Tests\Channels;

use Moririnson\LINENotify\Channels\LINENotifyChannel;
use Moririnson\LINENotify\Clients\LINENotifyClient;
use Moririnson\LINENotify\Tests\Mock\TestNotifiable;
use Moririnson\LINENotify\Tests\Mock\TestNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Orchestra\Testbench\TestCase;

class LINENotifyChannelTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(LINENotifyClient::class);
    }

    public function testSuccess()
    {
        $message = 'test message.';
        $image_thumbnail = 'test1024.jpg';
        $image_fullsize = 'test2048.jpg';
        $sticker_package_id = 1;
        $sticker_id = 1;
        $notification_disabled = false;
        $response = new Response(200);
        $this->client->shouldReceive('notify')
            ->once()
            ->with(
                TestNotifiable::ACCESS_TOKEN,
                $message,
                $image_thumbnail,
                $image_fullsize,
                null,
                $sticker_package_id,
                $sticker_id,
                $notification_disabled
            )->andReturn($response);

        $channel = new LINENotifyChannel($this->client);
        $notification = new TestNotification(
            $message,
            $image_thumbnail,
            $image_fullsize,
            $sticker_package_id,
            $sticker_id,
            $notification_disabled
        );
        $channel->send(new TestNotifiable(), $notification);
    }

    public function testStatus500()
    {
        $message = 'test message.';
        $response = new Response(500);
        $this->client->shouldReceive('notify')
            ->once()
            ->andReturn($response);

        $channel = new LINENotifyChannel($this->client);
        try {
            $channel->send(new TestNotifiable(), new TestNotification($message));
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function testStatus400()
    {
        $message = 'test message.';
        $response = new Response(400);
        $this->client->shouldReceive('notify')
            ->once()
            ->andReturn($response);

        $channel = new LINENotifyChannel($this->client);
        try {
            $channel->send(new TestNotifiable(), new TestNotification($message));
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function testStatus401()
    {
        $message = 'test message.';
        $response = new Response(401);
        $this->client->shouldReceive('notify')
            ->once()
            ->andReturn($response);

        $channel = new LINENotifyChannel($this->client);
        try {
            $channel->send(new TestNotifiable(), new TestNotification($message));
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
