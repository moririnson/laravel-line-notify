<?php

namespace Moririnson\LINENotify\Logging;

use GuzzleHttp\Client;
use Monolog\Logger;
use Moririnson\LINENotify\Clients\LINENotifyClient;

class LINENotifyLogger
{
    const LOGGER_NAME = 'LINENotify';
    const KEY_ACCESS_TOKEN = 'token';
    const KEY_LOG_LEVEL = 'level';

    /**
     * Create new Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $client = new LINENotifyClient(new Client);
        $level = Logger::toMonologLevel($config[self::KEY_LOG_LEVEL]);
        $handler = new LINENotifyHandler($client, $config[self::KEY_ACCESS_TOKEN], $level);

        $logger = new Logger(self::LOGGER_NAME);
        $logger->pushHandler($handler);
        return $logger;
    }
}
