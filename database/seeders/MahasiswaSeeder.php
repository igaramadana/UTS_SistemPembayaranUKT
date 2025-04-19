<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 2,
                'nim' => '2341760083',
                'mahasiswa_nama' => 'Iga Ramadana Sahputra',
                'angkatan' => '2023',
                'mahasiswa_alamat' => 'Jl. Raya No. 123',
                'no_telepon' => '081234567890',
                'Jenis_kelamin' => 'Laki-laki',
                'prodi_id' => 7,
            ]
        ];

        DB::table('mahasiswa')->insert($data);
    }
}
