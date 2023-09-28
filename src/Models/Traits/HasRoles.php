<?php

namespace Lcloss\SimplePermission\Models\Traits;
use Lcloss\SimplePermission\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
