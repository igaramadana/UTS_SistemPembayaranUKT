<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UktSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'prodi_id' => 7,
                'jenis_masuk' => 'SNBP/SNBT',
                'nominal_ukt' => 5000000
            ],
            [
                'prodi_id' => 7,
                'jenis_masuk' => 'Mandiri',
                'nominal_ukt' => 6250000
            ]
        ];

        DB::table('ukt')->insert($data);
    }
}
