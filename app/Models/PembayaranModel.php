<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranModel extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaran_id';
    protected $fillable = [
        'order_id',
        'mahasiswa_id',
        'ukt_id',
        'semester',
        'tanggal_pembayaran',
        'snap_token',
        'status_pembayaran'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    public function ukt()
    {
        return $this->belongsTo(UktModel::class, 'ukt_id', 'ukt_id');
    }
}
