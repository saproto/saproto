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

class UserSignedupEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $event,
        public User $user,
        public bool $backup = false
    ) {}

    /**
     * Determine if this event should broadcast.
     */
    public function broadcastWhen(): bool
    {
        // do not broadcast if the event hides its participants, so they do not get leaked
        return ! $this->event->activity?->hide_participants;
    }

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
     * @return array<string, string|int|bool>
     */
    public function broadcastWith(): array
    {
        return [
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'user_avatar' => $this->user->getFirstMediaUrl('profile_picture', 'preview'),
            'user_remove_link' => route('event::deleteparticipation', ['event' => $this->event, 'user' => $this->user]),
            'user_profile_link' => route('user::profile', ['id' => $this->user->getPublicId()]),
            'backup' => $this->backup,
        ];
    }
}
