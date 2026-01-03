<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Banyak Mitra
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'name' => 'Mitra ' . $i,
                'email' => 'mitra' . $i . '@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'mitra',
                'status' => 'aktif',
                'no_hp' => '08' . str_pad((string) rand(0, 999999999), 9, '0', STR_PAD_LEFT),
                'alamat' => 'Alamat Mitra ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
