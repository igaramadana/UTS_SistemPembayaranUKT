<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'mahasiswa_id';
    protected $fillable = [
        'user_id',
        'nim',
        'mahasiswa_nama',
        'angkatan',
        'mahasiswa_alamat',
        'no_telepon',
        'jenis_kelamin',
        'prodi_id'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id');
    }
}
