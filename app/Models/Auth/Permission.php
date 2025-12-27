<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'auth_permissions';
    protected $guarded = ['id'];
    protected $fillable = [];

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'permission_id');
    }

    public function roles()
    {
        return $this->hasManyThrough(Role::class, RolePermission::class, 'permission_id', 'id', 'id', 'role_id');
    }
}
