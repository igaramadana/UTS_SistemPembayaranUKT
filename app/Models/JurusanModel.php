<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanModel extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'jurusan_id';
    protected $fillable = [
        'jurusan_id',
        'jurusan_nama',
        'jurusan_kode',
        'created_at',
        'updated_at',
    ];
}
