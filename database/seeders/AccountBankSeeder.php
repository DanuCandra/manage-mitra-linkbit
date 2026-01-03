<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountBankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['BCA', '1234567890', 'PT Linkbit Network'],
            ['Mandiri', '9876543210', 'PT Linkbit Network'],
            ['BNI', '1112223334', 'PT Linkbit Network'],
            ['BRI', '5556667778', 'PT Linkbit Network'],
        ];

        foreach ($banks as $bank) {
            DB::table('account_bank')->insert([
                'id' => Str::uuid(),
                'nama_bank' => $bank[0],
                'nomor_rekening' => $bank[1],
                'atas_nama' => $bank[2],
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
