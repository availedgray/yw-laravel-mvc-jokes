<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $targetUser): bool
    {
        if ($authUser->hasRole('Super-Admin')) {
            return true;
        }

        if ($authUser->hasRole('Admin')) {
            return $authUser->id === $targetUser->id || $targetUser->hasAnyRole(['Staff', 'Client']);
        }

        if ($authUser->hasRole('Staff')) {
            return $authUser->id === $targetUser->id ||
                $targetUser->hasRole('Client');
        }

        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasAnyRole(['Super-Admin', 'Admin', 'Staff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $targetUser)
    {
        if ($authUser->hasRole('Super-Admin')) {
            return true;
        }

        if ($authUser->hasRole('Admin')) {
            return $authUser->id === $targetUser->id || $targetUser->hasAnyRole(['Staff', 'Client']);
        }

        if ($authUser->hasRole('Staff')) {
            return $authUser->id === $targetUser->id ||
                $targetUser->hasRole('Client');
        }

        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $targetUser)
    {
        if ($authUser->hasRole('Super-Admin')) {
            return $authUser->id !== $targetUser->id;
        }

        if ($authUser->hasRole('Admin')) {
            return $authUser->id === $targetUser->id || $targetUser->hasAnyRole(['Staff', 'Client']);
        }

        if ($authUser->hasRole('Staff')) {
            return $authUser->id === $targetUser->id || $targetUser->hasRole('Client');
        }

        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $authUser, User $targetUser): bool
    {
        //Super-Admin and Admin may restore any user's trash
        if ($authUser->hasAnyRole(['Super-Admin', 'Admin'])) {
            return true;
        }

        // Staff may restore their own trash and client's
        if ($authUser->hasRole('Staff')) {
            return $authUser->id === $targetUser->id || $targetUser->hasRole('Client');
        }

        // Client can't perform the feature
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $authUser, User $targetUser): bool
    {
        // Super-Admin may force delete any data
        if ($authUser->hasRole('Super-Admin')) {
            return true;
        }

        if ($authUser->hasRole('Admin')) {
            return $authUser->id === $targetUser->id || $targetUser->hasAnyRole(['Staff', 'Client']) ;
        }

        if ($authUser->hasRole('Staff')) {
            return $authUser->id === $targetUser->id || $targetUser->hasRole('Client');
        }

        // Client can't perform the feature
        return false;
    }
}
