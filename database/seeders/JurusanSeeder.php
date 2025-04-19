<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jurusan_kode' => 'JTE',
                'jurusan_nama' => 'Jurusan Teknik Elektro',
            ],

            [
                'jurusan_kode' => 'JTM',
                'jurusan_nama' => 'Jurusan Teknik Mesin',
            ],
            [
                'jurusan_kode' => 'JTI',
                'jurusan_nama' => 'Jurusan Teknologi Informasi',
            ]

        ];

        DB::table('jurusan')->insert($data);
    }
}
