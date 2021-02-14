<?php

namespace Moririnson\LINENotify\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Moririnson\LINENotify\Constants;
use Moririnson\LINENotify\Clients\LINENotifyClient;

class LINENotifyHandler extends AbstractProcessingHandler
{
    /** @var \Moririnson\LINENotify\Clients\LINENotifyClient */
    private $client;

    /** @var string */
    private $token;

    /**
     * Create new Monolog instance.
     *
     * @param \Moririnson\LINENotify\Clients\LINENotifyClient $client
     * @param string $level
     * @param boolean $bubble
     */
    public function __construct(LINENotifyClient $client, $token, $level = Logger::DEBUG, $bubble = true)
    {
        $this->token = $token;
        $this->client = $client;
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record): void
    {
        $message = '[' . $record['level'] . '][' . $record['datetime']->format('U') . ']' . $record['formatted'];
        $this->client->notify($this->token, $message);
    }
}
