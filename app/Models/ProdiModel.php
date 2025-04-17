<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'prodi_id';
    protected $fillable = [
        'prodi_id',
        'jurusan_id',
        'prodi_nama',
        'prodi_kode',
        'created_at',
        'updated_at'
    ];

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'jurusan_id', 'jurusan_id');
    }
}
