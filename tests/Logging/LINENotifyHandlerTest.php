<?php

namespace Moririnson\LINENotify\Tests\Clients;

use Moririnson\LINENotify\Clients\LINENotifyClient;
use Moririnson\LINENotify\Logging\LINENotifyHandler;
use Moririnson\LINENotify\Tests\Mock\TestNotifiable;
use Mockery;
use Orchestra\Testbench\TestCase;

class LINENotifyHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(LINENotifyClient::class);
    }

    public function testHandle()
    {
        $level = 'error';
        $datetime = new \DateTime('2020-01-01T00:00:00Z');
        $datetime_string = $datetime->format('U');
        $formated = 'test';
        $expected = "[$level][$datetime_string]$formated";
        $this->client->shouldReceive('notify')
            ->with(TestNotifiable::ACCESS_TOKEN, $expected);
        
        $handler = new LINENotifyHandler($this->client, TestNotifiable::ACCESS_TOKEN);
        $handler->handle([
            'level' => $level,
            'datetime' => $datetime,
            'expected' => $expected,
        ]);
    }
}
