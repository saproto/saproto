<?php

namespace App\Models;

use App\Enums\MembershipTypeEnum;
use Database\Factories\EmailFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

/**
 * Email Model.
 *
 * @property int $id
 * @property string $description
 * @property string $subject
 * @property string $sender_name
 * @property string $sender_address
 * @property string $body
 * @property bool $to_user
 * @property bool $to_member
 * @property bool $to_pending
 * @property bool $to_list
 * @property bool $to_event
 * @property bool $to_backup
 * @property bool $to_active
 * @property int|null $sent_to
 * @property int $sent
 * @property bool $ready
 * @property int $time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, StorageEntry> $attachments
 * @property-read int|null $attachments_count
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 * @property-read Collection<int, EmailList> $lists
 * @property-read int|null $lists_count
 *
 * @method static EmailFactory factory($count = null, $state = [])
 * @method static Builder<static>|Email newModelQuery()
 * @method static Builder<static>|Email newQuery()
 * @method static Builder<static>|Email query()
 * @method static Builder<static>|Email whereBody($value)
 * @method static Builder<static>|Email whereCreatedAt($value)
 * @method static Builder<static>|Email whereDescription($value)
 * @method static Builder<static>|Email whereId($value)
 * @method static Builder<static>|Email whereReady($value)
 * @method static Builder<static>|Email whereSenderAddress($value)
 * @method static Builder<static>|Email whereSenderName($value)
 * @method static Builder<static>|Email whereSent($value)
 * @method static Builder<static>|Email whereSentTo($value)
 * @method static Builder<static>|Email whereSubject($value)
 * @method static Builder<static>|Email whereTime($value)
 * @method static Builder<static>|Email whereToActive($value)
 * @method static Builder<static>|Email whereToBackup($value)
 * @method static Builder<static>|Email whereToEvent($value)
 * @method static Builder<static>|Email whereToList($value)
 * @method static Builder<static>|Email whereToMember($value)
 * @method static Builder<static>|Email whereToPending($value)
 * @method static Builder<static>|Email whereToUser($value)
 * @method static Builder<static>|Email whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Email extends Model
{
    /** @use HasFactory<EmailFactory>*/
    use HasFactory;

    protected $table = 'emails';

    protected $guarded = ['id'];

    /**
     * @return BelongsToMany<EmailList, $this>
     */
    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(EmailList::class, 'emails_lists', 'email_id', 'list_id');
    }

    /**
     * @return BelongsToMany<Event, $this>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'emails_events', 'email_id', 'event_id');
    }

    /**
     * @return BelongsToMany<StorageEntry, $this>
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(StorageEntry::class, 'emails_files', 'email_id', 'file_id');
    }

    /**
     * @throws Exception
     */
    public function destinationForBody(): string
    {
        if ($this->to_user) {
            return 'users';
        }

        if ($this->to_member) {
            return 'members';
        }

        if ($this->to_pending) {
            return 'pending';
        }

        if ($this->to_active) {
            return 'active members';
        }

        if ($this->to_list) {
            return 'list';
        }

        if ($this->to_event) {
            if ($this->to_backup) {
                return 'event with backup';
            }

            return 'event';
        }

        throw new Exception('Email has no destination');
    }

    /** @return Collection<int, User> */
    public function recipients(): SupportCollection
    {
        if ($this->to_user) {
            return User::query()->orderBy('name')->get();
        }

        if ($this->to_member) {
            return User::query()->whereHas('member', static function ($q) {
                $q->whereNot('membership_type', MembershipTypeEnum::PENDING);
            })->orderBy('name')->get();
        }

        if ($this->to_pending) {
            return User::query()->whereHas('member', static function ($q) {
                $q->whereMembershipType(MembershipTypeEnum::PENDING);
            })->orderBy('name')->get();
        }

        if ($this->to_active) {
            return User::query()->whereHas('committees')->orderBy('name')->get();
        }

        if ($this->to_list) {
            return User::query()->whereHas('lists', function ($q) {
                $q->whereIn('users_mailinglists.list_id', $this->lists->pluck('id')->toArray());
            })->orderBy('name')->get();
        }


        if ($this->to_event) {
            return User::whereHas('activities', function($q){
                $q->whereHas('event', function ($q){
                    $q->whereHas('emails', function ($q){
                        $q->where('emails.id', $this->id);
                    });
                });
            })->orderBy('name')->get();
        }

        return collect();
    }

    public function hasRecipientList(EmailList $list): bool
    {
        return DB::table('emails_lists')->where('email_id', $this->id)->where('list_id', $list->id)->exists();
    }

    /**
     * @return string Email body with variables parsed.
     */
    public function parseBodyFor(User $user): string
    {
        $variable_from = ['$calling_name', '$name'];
        $variable_to = [$user->calling_name, $user->name];

        if ($this->to_member || $this->to_active || $this->to_pending) {
            $variable_from[] = '$username';
            $variable_to[] = $user->member->proto_username ?? '(no username found)';
        }

        return str_replace($variable_from, $variable_to, $this->body);
    }

    public function getEventName(): string
    {
        $events = [];
        if (! $this->to_event) {
            return '';
        }

        foreach ($this->events as $event) {
            $events[] = $event->title;
        }

        return implode(', ', $events);
    }

    public static function getListUnsubscribeFooter(int $user_id, int $email_id): string
    {
        $footer = [];
        $lists = self::whereId($email_id)->firstOrFail()->lists;
        foreach ($lists as $list) {
            $footer[] = sprintf('%s (<a href="%s" style="color: #00aac0;">unsubscribe</a>)', $list->name, route('unsubscribefromlist', ['hash' => EmailList::generateUnsubscribeHash($user_id, $list->id)]));
        }

        return implode(', ', $footer);
    }

    protected function casts(): array
    {
        return [
            'to_user' => 'boolean',
            'to_member' => 'boolean',
            'to_pending' => 'boolean',
            'to_list' => 'boolean',
            'to_event' => 'boolean',
            'to_backup' => 'boolean',
            'to_active' => 'boolean',
            'ready' => 'boolean',
        ];
    }
}
