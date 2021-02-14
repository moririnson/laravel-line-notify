## Laravel Notifications for LINE Notify  ![Build Status](https://github.com/moririnson/laravel-line-notify/workflows/PHP%20Composer/badge.svg)

### Requirement

- PHP 7.0+
- Laravel 5.5+

### Installation

```bash
composer require moririnson/laravel-line-notify
```

### Usage

#### Notification

Add token to your notifiable.

```php
/**
* @return string token
*/
public function routeNotificationForLINE()
{
    return 'ACCESS_TOKEN_HERE';
}
```

Create your notification by `make:notification` and impl like this.

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

Then you can call `notify()`.

```
$notifiable->notify(new LINENotify('test message'));
```


#### Logging

Add this config to `logging.php`.

```
        'stack' => [
            'driver' => 'stack',
            'channels' => ['line'],
        ],

        'line' => [
            'driver' => 'custom',
            'token' => env('LOG_LINE_NOTIFY_ACCESS_TOKEN'),
            'via' => \Moririnson\LINENotify\Logging\LINENotifyLogger::class,
            'level' => 'error',
        ],
```

### Testing

```bash
composer test
```

### License

The MIT License (MIT), Please see [License File](./LICENSE.md) for more information.