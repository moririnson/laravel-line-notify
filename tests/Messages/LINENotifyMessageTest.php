<?php

namespace Moririnson\LineNotify\Test;

use Moririnson\LineNotify\Messages\LineNotifyMessage;
use Orchestra\Testbench\TestCase;

class LineMessageTest extends TestCase
{
    public function testMessage()
    {
        $expected = 'test';
        $message = (new LineNotifyMessage())->message($expected);
        $this->assertEquals($expected, $message->message);

        $this->message = new LineNotifyMessage($expected);
        $this->assertEquals($expected, $message->message);
    }
}
