<?php

namespace App\Events;

use App\Models\Sticker;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Override;

class StickerRemovedEvent implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Sticker $sticker) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    #[Override]
    public function broadcastOn(): array
    {
        return [
            new Channel('stickers'),
        ];
    }

    /**
     *@return array{
     *     id: int
     *}
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->sticker->id,
        ];
    }
}
