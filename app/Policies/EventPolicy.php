<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'superadmin') {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->role === 'organizer' && (bool) $user->organization_id;
    }

    public function view(User $user, Event $event): bool
    {
        return $user->role === 'organizer'
            && (int) $user->organization_id === (int) $event->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'organizer' && (bool) $user->organization_id;
    }

    public function update(User $user, Event $event): bool
    {
        return $user->role === 'organizer'
            && (int) $user->organization_id === (int) $event->organization_id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->role === 'organizer'
            && (int) $user->organization_id === (int) $event->organization_id;
    }
}