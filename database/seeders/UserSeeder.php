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
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123'),
            'status' => 'active',
            'role_id' => 1,
            ],
            [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'status' => 'active',
            'role_id' => 2,
            ],
            [
            'name' => 'Mitra',
            'email' => 'mitra@gmail.com',
            'password' => bcrypt('123'),
            'status' => 'active',
            'role_id' => 3,
            ],
            
        ];

        DB::table('users')->insert($users);


    }
}
