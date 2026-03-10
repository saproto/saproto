<?php

namespace App\Events\Stickers;

use App\Models\Sticker;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Override;

class StickerPlacedEvent implements ShouldBroadcastNow
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
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->sticker->id,
            'lat' => $this->sticker->lat,
            'lng' => $this->sticker->lng,
            'user' => $this->sticker->user?->calling_name ?? 'Unknown',
            'image' => $this->sticker->getImageUrl(),
            'is_owner' => false,
            'date' => $this->sticker->created_at->format('Y-m-d'),
            'stickerType' => $this->sticker->sticker_type_id,
        ];
    }
}
