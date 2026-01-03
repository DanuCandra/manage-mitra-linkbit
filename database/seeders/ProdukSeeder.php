<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $mitras = DB::table('mitra')->get();

        foreach ($mitras as $mitra) {
            $jumlahProduk = rand(2, 3);

            for ($i = 1; $i <= $jumlahProduk; $i++) {
                DB::table('produk')->insert([
                    'id' => Str::uuid(),
                    'mitra_id' => $mitra->id,
                    'nama_produk' => 'Paket Internet ' . $i,
                    'bandwidth' => rand(10, 100) . ' Mbps',
                    'harga' => rand(150000, 1000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
