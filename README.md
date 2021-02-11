## Laravel Notifications for LINE Notify  ![Build Status](https://github.com/moririnson/laravel-line-notify/workflows/PHP%20Composer/badge.svg)

#### Requirement

- PHP 7.0+
- Laravel 5.3+

#### Installation

```bash
composer require moririnson/laravel-line-notify
```

#### Usage

```php
/**
* @return string token
*/
public function routeNotificationForLINE()
{
    return 'ACCESS_TOKEN_HERE';
}
```

```php

use Illuminate\Notifications\Notification;
use Moririnson\LINENotify\Channels\LINENotifyChannel;
use Moririnson\LINENotify\Messages\LINENotifyMessage;

class LineNotify extends Notification
{
    private $message;

    public function __construct($message)
    {
    	$this->message = $message;    
    }

    public function via($notifiable)
    {
        return [LINENotifyChannel::class]
    }

    public function toLINE($notifiable)
    {
        return (new LINENotifyMessage())->message($this->message);
    }
}
```

#### Testing

```bash
composer test
```

#### License

The MIT License (MIT), Please see [License File](./LICENSE.md) for more information.