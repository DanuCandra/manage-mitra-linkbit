<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Here you can define the roles you want to seed
        $roles = [
            ['role_name' => 'superadmin'],
            ['role_name' => 'admin'],
            ['role_name' => 'mitra'],
        ];

        // Insert roles into the database
        DB::table('roles')->insert($roles);
    }
}
