<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
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

    public function view(User $user, Transaction $transaction): bool
    {
        return $user->role === 'organizer'
            && (int) $user->organization_id === (int) $transaction->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'organizer' && (bool) $user->organization_id;
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return $user->role === 'organizer'
            && (int) $user->organization_id === (int) $transaction->organization_id;
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->role === 'organizer'
            && (int) $user->organization_id === (int) $transaction->organization_id;
    }
}