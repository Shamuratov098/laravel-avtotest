<?php

namespace App\Policies;

use App\Models\TestSession;
use App\Models\User;
class TestSessionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TestSession $testSession): bool
    {
        return $user->id === $testSession->user_id;
    }

    public function answer(User $user, TestSession $testSession): bool
    {
        return $user->id === $testSession->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TestSession $testSession): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TestSession $testSession): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TestSession $testSession): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TestSession $testSession): bool
    {
        return false;
    }
}
