<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [

            [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'status' => 'aktif',
            'role' => 'admin',
            ],
            [
            'name' => 'Mitra',
            'email' => 'mitra@gmail.com',
            'password' => bcrypt('123'),
            'status' => 'aktif',
            'role' => 'mitra',
            ],

        ];

        DB::table('users')->insert($users);


    }
}
