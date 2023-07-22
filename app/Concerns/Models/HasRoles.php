<?php

namespace App\Concerns\Models;

use App\Models\User;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

/**
 * @method User assignRole(BackedEnum $role)
 */
trait HasRoles
{
    use SpatieHasRoles {
        scopeRole as traitScopeRole;
        getStoredRole as traitGetStoredRole;
        hasRole as traitHasRole;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<User>  $query
     * @param  string|int|array<mixed>|BackedEnum|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection<string>  $roles
     * @param  string  $guard
     * @return \Illuminate\Database\Eloquent\Builder<User>
     */
    public function scopeRole(Builder $query, $roles, $guard = null): Builder
    {
        if ($roles instanceof BackedEnum) {
            $roles = $roles->value;
        }

        return $this->traitScopeRole($query, $roles, $guard);
    }

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param  string|int|array<mixed>|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection  $roles
     */
    public function hasRole($roles, string $guard = null): bool
    {
        if ($roles instanceof BackedEnum) {
            $roles = $roles->value;
        }

        return $this->traitHasRole($roles, $guard);
    }

    /**
     * @param  string|int|Role  $role
     */
    protected function getStoredRole($role): Role
    {
        if ($role instanceof BackedEnum) {
            $role = $role->value;
        }

        return $this->traitGetStoredRole($role);
    }
}
