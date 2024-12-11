<?php

namespace App\Policies;

use App\Models\Joke;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JokePolicy
{
    /**
     * Determine which  user can view any jokes.
     */
    public function viewAny(User $user): bool
    {
        return$user->can('joke-list');
    }

    /**
     * Determine which user can view jokes.
     */
    public function view(User $user, Joke $joke): bool
    {
        return $user->can('joke-show');
    }

    /**
     * Determine which user can create jokes.
     */
    public function create(User $user): bool
    {
        return $user->can('joke-create');
    }

    /**
     * Determine which  user can update a joke.
     */
    public function update(User $user, Joke $joke): bool
    {

        if ($user->hasRole('Client')) {
            return $user->id === $joke->author_id;
        }

        return $user->id === $joke->author_id || $user->can('joke-edit');
    }


    /**
     * Determine which  user can delete a joke.
     */
    public function delete(User $user, Joke $joke): bool
    {
        if ($user->hasRole('Client')) {
            return $user->id === $joke->author_id;
        }

        if ($user->hasRole('Staff')) {
            return $user->id === $joke->author_id || $joke->author->hasRole('Client');
        }

        return $user->id === $joke->author_id || $user->can('joke-delete');
    }

    /**
     * Determine which  user can restore a joke.
     */
    public function restore(User $user, Joke $joke): bool
    {
        // Client may restore their own jokes
        if ($user->hasRole('Client')) {
            return $user->id === $joke->author_id;
        }

        // Staff may restore their own jokes and client's jokes
        if ($user->hasRole('Staff')) {
            return $joke->author->hasAnyRole(['Client', 'Staff']) ;
        }

        // Super-Admin and Admin may restore any jokes
        return $user->id === $joke->author_id || $user->can('joke-restore');
    }

    /**
     * Determine which  user can permanetly delete a  joke.
     */

    public function forceDelete(User $user, Joke $joke): bool
    {

        if ($user->hasRole('Client')) {
            return $user->id === $joke->author_id;
        }

        if ($user->hasRole('Staff') && $joke->author->hasAnyRole(['Client', 'Staff']) && $joke->trashed()) {
            return true;
        }

        return $user->id === $joke->author_id || $user->can('joke-remove');
    }
}
