<?php

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

/** @typescript */
class AuthUserData extends Data
{
    public function __construct(
        public int $id,
        public string $calling_name,
        /** @var array<string> $roles */
        public array $roles,
        public bool $is_member,
        public string $avatar,
        public string $email,
    ) {}

    public static function fromModel(?User $user): ?self
    {
        return $user instanceof User ? new self(
            $user->id,
            $user->calling_name,
            $user->getRoleNames()->toArray(), // Get role names
            $user->is_member,
            $user->getFirstMediaUrl('profile_picture', 'preview'),
            $user->email
        ) : null;
    }
}
