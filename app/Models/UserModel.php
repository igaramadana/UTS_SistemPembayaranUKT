<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'role_id',
        'email',
        'password',
        'foto_profile',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'role_id');
    }

    public function hasRole($roleCode)
    {
        return $this->role->role_code === $roleCode;
    }
}
