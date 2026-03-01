<?php

namespace App\Events\Events;

use App\Models\Event;
use App\Models\User;
use App\Models\WallstreetEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Override;

class UserSignedOutEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $event,
        public User $user
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, PrivateChannel>
     */
    #[Override]
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('events.'.$this->event->id),
        ];
    }

    /**
     * The name of the queue on which to place the broadcasting job.
     */
    public function broadcastQueue(): string
    {
        return 'medium';
    }

    /**
     * @return array<string, WallstreetEvent>
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
        ];
    }
}
