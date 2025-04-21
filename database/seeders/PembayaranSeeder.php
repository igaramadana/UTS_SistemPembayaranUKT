<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'pembayaran_id' => 1,
            'mahasiswa_id' => 3,
            'ukt_id' => 1,
            'semester' => 4,
            'tanggal_pembayaran' => '2023-05-24',
            'status_pembayaran' => 'Selesai',
            'order_id' => 1
        ];
        DB::table('pembayaran')->insert($data);
    }
}
