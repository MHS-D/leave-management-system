<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveRequestPolicy
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
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.employeeRole')) ;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leave_request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LeaveRequest $leave_request)
    {
        return $leave_request->user_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.employeeRole'));
    }

       /**
     * Determine whether the user can edit models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.employeeRole'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leave_request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LeaveRequest $leave_request)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.employeeRole'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leave_request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LeaveRequest $leave_request)
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
        return $user?->hasRole(config('settings.roles.names.adminRole')) || $user?->hasRole(config('settings.roles.names.employeeRole'));
    }

    public function getRequestInfo(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole'));
    }

    public function updateStatus(User $user)
    {
        return $user?->hasRole(config('settings.roles.names.adminRole'));
    }
}
