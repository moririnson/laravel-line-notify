<?php

namespace Moririnson\LINENotify;

class Constants
{
    const API_DOMAIN_NAME = 'notify-api.line.me';
    const API_BASE_URL = 'https://' . self::API_DOMAIN_NAME;
    const API_NOTIFY_PATH = '/api/notify';
    const API_NOTIFY_ENDPOINT = self::API_BASE_URL . self::API_NOTIFY_PATH;
    const SOCKET_BASE_URL = 'ssl://' . self::API_DOMAIN_NAME . ':443';
}