<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.subAdminRole'));
    }

       /**
     * Determine whether the user can edit models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.subAdminRole'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.subAdminRole')) ||  $user?->hasRole(config('settings.roles.names.department6Role'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole'));
    }

    /**
     * Determine whether the user can export the model's data from datatable.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function exportDatatable(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.subAdminRole'));
    }
}
