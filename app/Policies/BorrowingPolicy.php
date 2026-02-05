<?php

namespace App\Policies;

use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BorrowingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Borrowing $borrowing): bool
    {
        return $user->is_admin || $user->id === $borrowing->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Borrowing $borrowing): bool
    {
        return $user->is_admin || $user->id === $borrowing->user_id;
    }

    public function delete(User $user, Borrowing $borrowing): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Borrowing $borrowing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Borrowing $borrowing): bool
    {
        return false;
    }
}
