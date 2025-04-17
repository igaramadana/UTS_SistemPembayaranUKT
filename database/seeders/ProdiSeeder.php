<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jurusan_id' => 3,
                'prodi_kode' => 'TI',
                'prodi_nama' => 'DIV - Teknik Informatika',
            ],
            [
                'jurusan_id' => 3,
                'prodi_kode' => 'SIB',
                'prodi_nama' => 'DIV - Sistem Informasi Bisnis',
            ],
        ];

        DB::table('prodi')->insert($data);
    }
}
