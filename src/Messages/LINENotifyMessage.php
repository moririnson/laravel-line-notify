<?php

namespace Moririnson\LINENotify\Messages;

class LINENotifyMessage
{
    /**
     * message
     *
     * @var string
     */
    public $message;

    /**
     * Set message.
     *
     * @param string $message
     * @return this
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }
}
