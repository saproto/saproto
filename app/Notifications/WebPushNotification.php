<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class WebPushNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public function __construct(public string $messageTitle, public string $messageText, public string $onConnection = "low")
    {
        $this->onConnection($onConnection);
    }

    /**
     * @return array<class-string>
     */
    public function via(): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(): WebPushMessage
    {
        return (new WebPushMessage)
            ->title($this->messageTitle)
            ->icon('/images/logo/svg/protons/proton_6.svg')
            ->body($this->messageText)
            ->options(['TTL' => 1000]);
        // ->data(['id' => $notification->id])
        // ->badge()
        // ->dir()
        // ->image()
        // ->lang()
        // ->renotify()
        // ->requireInteraction()
        // ->tag()
        // ->vibrate()
    }
}
