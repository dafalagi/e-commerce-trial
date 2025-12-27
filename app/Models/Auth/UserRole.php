<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'auth_user_roles';
    protected $primaryKey = null;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    protected $hidden = [
        'user_id',
        'role_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
