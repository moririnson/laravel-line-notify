<?php

namespace Moririnson\LINENotify\Messages;

class LINENotifyMessage
{
    /** @var string */
    public $message;

    /** @var string|null */
    public $image_thumbnail;

    /** @var string|null */
    public $image_fullsize;

    /** @var string|null */
    public $image_file;

    /** @var int|null */
    public $sticker_package_id;

    /** @var int|null */
    public $sticker_id;

    /** @var bool|null */
    public $notification_disabled;

    /**
     * Set message.
     * 1000 characters max.
     *
     * @param string $message
     * @return this
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set image_thumbnail.
     * Maximum size of 240×240px JPEG.
     *
     * @param string $image_thumbnail
     * @return this
     */
    public function imageThumbnail($image_thumbnail)
    {
        $this->image_thumbnail = $image_thumbnail;
        return $this;
    }

    /**
     * Set image_fullsize.
     * Maximum size of 2048×2048px JPEG.
     *
     * @param string $image_fullsize
     * @return this
     */
    public function imageFullsize($image_fullsize)
    {
        $this->image_fullsize = $image_fullsize;
        return $this;
    }

    /**
     * set image_file
     * Upload a image file to the LINE server.
     * Supported image format is png and jpeg.
     * If you specified imageThumbnail ,imageFullsize and imageFile, imageFile takes precedence.
     * There is a limit that you can upload to within one hour.
     * For more information, please see the section of the API Rate Limit.
     *
     * @param string $image_file
     * @return this
     */
    public function imageFile($image_file)
    {
        $this->image_file = $image_file;
        return $this;
    }

    /**
     * Package ID.
     * https://developers.line.biz/media/messaging-api/sticker_list.pdf
     *
     * @param int $sticker_package_id
     * @return this
     */
    public function stickerPackageId($sticker_package_id)
    {
        $this->sticker_package_id = $sticker_package_id;
        return $this;
    }

    /**
     * Sticker ID.
     *
     * @param int $sticker_id
     * @return this
     */
    public function stickerId($sticker_id)
    {
        $this->sticker_id = $sticker_id;
        return $this;
    }

    /**
     * Set notification_disabled.
     * true: The user doesn't receive a push notification when the message is sent.
     * false: The user receives a push notification when the message is sent.
     * (Unless they have disabled push notification in LINE and/or their device.)
     * If omitted, the value defaults to false.
     *
     * @param bool $notification_disabled
     * @return this
     */
    public function notificationDisabled($notification_disabled)
    {
        $this->notification_disabled = $notification_disabled;
        return $this;
    }
}
