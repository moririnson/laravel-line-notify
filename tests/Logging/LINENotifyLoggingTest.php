<?php

namespace Moririnson\LINENotify\Tests\Clients;

use Moririnson\LINENotify\Clients\LINENotifyClient;
use Moririnson\LINENotify\Logging\LINENotifyHandler;
use Moririnson\LINENotify\Logging\LINENotifyLogger;
use Moririnson\LINENotify\Tests\Mock\TestNotifiable;
use Mockery;
use Orchestra\Testbench\TestCase;

class LINENotifyLoggingTest extends TestCase
{
    public function testInvoke()
    {
        $level = 'error';
        $line_notify_logger = new LINENotifyLogger;
        $logger = $line_notify_logger([
            LINENotifyLogger::KEY_ACCESS_TOKEN => TestNotifiable::ACCESS_TOKEN,
            LINENotifyLogger::KEY_LOG_LEVEL => $level,
        ]);

        $this->assertEquals(LINENotifyLogger::LOGGER_NAME, $logger->getName());
    }
}