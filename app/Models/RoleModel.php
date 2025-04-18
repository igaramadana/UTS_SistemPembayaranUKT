<?php

namespace App\Models;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_code',
        'role_nama',
    ];

    public function user()
    {
        return $this->hasMany(UserModel::class, 'role_id');
    }
}
