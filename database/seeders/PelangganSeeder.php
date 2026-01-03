<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $produk = DB::table('produk')->get();

        foreach ($produk as $item) {
            $jumlah = rand(3, 8);

            for ($i = 1; $i <= $jumlah; $i++) {
                DB::table('pelanggan')->insert([
                    'id' => Str::uuid(),
                    'mitra_id' => $item->mitra_id,
                    'produk_id' => $item->id,
                    'id_pelanggan' => 'PLG-' . rand(1000, 9999),
                    'nama' => 'Pelanggan ' . $i,
                    'alamat' => 'Alamat Pelanggan ' . $i,
                    'mulai_berlangganan' => now()->subMonths(rand(1, 12)),
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
