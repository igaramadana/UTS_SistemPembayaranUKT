<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'role_id' => 1,
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password'),
            ],
        ];
        DB::table('users')->insert($data);
    }
}
