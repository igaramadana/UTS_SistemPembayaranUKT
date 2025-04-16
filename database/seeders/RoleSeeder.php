<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['role_code' => 'ADM', 'role_nama' => 'Administrator'],
            ['role_code' => 'MHS', 'role_nama' => 'Mahasiswa'],
        ];

        DB::table('role')->insert($data);
    }
}
