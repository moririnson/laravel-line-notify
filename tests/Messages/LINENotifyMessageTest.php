<?php

namespace Moririnson\LINENotify\Tests\Messages;

use Moririnson\LINENotify\Messages\LINENotifyMessage;
use Orchestra\Testbench\TestCase;

class LineMessageTest extends TestCase
{
    public function testMessage()
    {
        $expected = 'test';
        $message = (new LINENotifyMessage())->message($expected);
        $this->assertEquals($expected, $message->message);

        $this->message = new LINENotifyMessage($expected);
        $this->assertEquals($expected, $message->message);
    }
}
