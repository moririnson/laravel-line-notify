<?php

namespace Moririnson\LineNotify\Tests\Mock;

use Moririnson\LineNotify\Messages\LineNotifyMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    /** @var string */
    public $message;

    /** @var string */
    public $image_thumbnail;

    /** @var string */
    public $image_fullsize;

    /** @var int */
    public $sticker_package_id;

    /** @var int */
    public $sticker_id;

    /** @var bool */
    public $notification_disabled;

    /**
     * Create new TestNotification
     *
     * @param string $message
     */
    public function __construct(
        $message,
        $image_thumbnail = null,
        $image_fullsize = null,
        $sticker_package_id = null,
        $sticker_id = null,
        $notification_disabled = null
    ) {
        $this->message = $message;
        $this->image_thumbnail = $image_thumbnail;
        $this->image_fullsize = $image_fullsize;
        $this->sticker_package_id = $sticker_package_id;
        $this->sticker_id = $sticker_id;
        $this->notification_disabled = $notification_disabled;
    }

    /**
     * Notification with LINE Notify.
     *
     * @param mixed $notifiable
     * @return \Moririnson\LineNotify\Messages\LineNotifyMessage
     */
    public function toLINE($notifiable)
    {
        return (new LineNotifyMessage())
            ->message($this->message)
            ->imageThumbnail($this->image_thumbnail)
            ->imageFullsize($this->image_fullsize)
            ->stickerPackageId($this->sticker_package_id)
            ->stickerId($this->sticker_id)
            ->notificationDisabled($this->notification_disabled);
    }
}
