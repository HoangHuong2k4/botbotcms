<?php

namespace Dev\OneSignalChannel\Channels;

use Illuminate\Notifications\Notification;
use Dev\OneSignalChannel\Messages\OneSignalMessage;

class OneSignalChannel extends OneSignalBaseClient
{

    /**
     * constructor
     *
     * @return void
     */
    public function __construct(string $appId, string $restApiKey, string $userAuthKey)
    {
        parent::__construct($appId, $restApiKey, $userAuthKey);
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return \Message\Message
     */
    public function send($notifiable, Notification $notification)
    {
        $content = $notification->toOneSignal($notifiable);

        if (is_array($content))
            $content = new OneSignalMessage($content);
        else
            return;

        return $this->sendNotificationUsingTags($content->getContent(), $content->getTags(), $content->getHeading(), $content->getSubtitle(), $content->getArrayArgs());
    }
}
