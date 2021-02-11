<?php

namespace Moririnson\LineNotify\Test;

use Moririnson\LINENotify\LINENotifyException;
use Moririnson\LineNotify\Channels\LINENotifyChannel;
use Moririnson\LineNotify\Tests\Mock\TestNotifiable;
use Moririnson\LineNotify\Tests\Mock\TestNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Orchestra\Testbench\TestCase;

class LINENotifyChannelTest extends TestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
    }

    public function testSuccess()
    {
        $message = 'test message.';
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
                    ]
                ],
            ])
            ->andReturn($response);

        $channel = new LINENotifyChannel($this->client);
        $channel->send(new TestNotifiable(), new TestNotification($message));
    }

    public function testStatus500()
    {
        $message = 'test message.';
        $response = new Response(500);
        $this->client->shouldReceive('post')
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
        $this->client->shouldReceive('post')
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
        $this->client->shouldReceive('post')
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
