<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\CommonModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    protected $appends = ['role', 'full_name'];

    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'updated_at',
    ];

    public function scopeActive($query)
    {
        return $query->status(Status::ACTIVE);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function getRoleAttribute()
    {
        return $this->roles()->first()?->name;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function agentInfo()
    {
        return $this->hasOne(AgentInfo::class);
    }

    public function ScopeAgents($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'agent');
        });
    }

    /**
     * Scope users where "status"
     *
     * @param Builder $query
     * @param int $status
     * @return void
     */
    public function scopeWhereStatus(Builder $query, int $status): void
    {
        $query->where('status', $status);
    }

    /**
     * Order users by first role
     *
     * @param Builder $query
     * @param string $direction
     * @return void
     */
    public function scopeOrderByRole(Builder $query, string $direction = 'asc'): void
    {
        $rolesTable = (new Role())->getTable();
        $pivotTable = 'model_has_roles';

        $query->orderByRaw(
            "(SELECT " . $rolesTable . ".name FROM " . $rolesTable . " JOIN " . $pivotTable . " p ON p.role_id = " . $rolesTable . ".id AND p.model_id = users.id AND p.model_type = 'App\\\Models\\\User') " . $direction
        );
    }

    /**
     * Get the status name
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        return Status::ALL[$this->status] ?? 'Not Found';
    }
}
