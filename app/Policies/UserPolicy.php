<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(config('settings.roles.names.adminRole'));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $otherUser)
    {
        return $user->hasRole(config('settings.roles.names.adminRole'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole(config('settings.roles.names.adminRole'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $otherUser)
    {
        return $user->hasRole(config('settings.roles.names.adminRole'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $otherUser)
    {
        return $user->hasRole(config('settings.roles.names.adminRole'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $otherUser)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $otherUser)
    {
        return false;
    }

    /**
     * Determine whether the user can export the model's data from datatable.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function exportDatatable(User $user)
    {
        return $user->hasRole(config('settings.roles.names.adminRole'));
    }
}
