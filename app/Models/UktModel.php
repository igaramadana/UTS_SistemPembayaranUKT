<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UktModel extends Model
{
    use HasFactory;

    protected $table = 'ukt';
    protected $primaryKey = 'ukt_id';
    protected $fillable = [
        'ukt_id',
        'prodi_id',
        'jenis_masuk',
        'nominal_ukt'
    ];
    protected $casts = [
        'nominal_ukt' => 'decimal:2'
    ];

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }
}
