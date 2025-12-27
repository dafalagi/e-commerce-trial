<?php

namespace App\Models\Auth;

use App\Models\BaseModel;

class Role extends BaseModel
{
    protected $table = 'auth_roles';

    protected $hidden = [
        'id',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getRestrictOnDeleteRelations()
    {
        return [
            'userRoles',
            'rolePermissions',
        ];
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserRole::class, 'role_id', 'id', 'id', 'user_id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id');
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, RolePermission::class, 'role_id', 'id', 'id', 'permission_id');
    }
}
