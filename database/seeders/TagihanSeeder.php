<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        $mitras = DB::table('mitra')->get();

        foreach ($mitras as $mitra) {
            $jumlahTagihan = rand(2, 4);

            for ($i = 1; $i <= $jumlahTagihan; $i++) {
                $harga = rand(300000, 2000000);
                $status = collect(['belum_bayar', 'cicilan', 'lunas', 'terlambat'])->random();

                DB::table('tagihan')->insert([
                    'id' => Str::uuid(),
                    'mitra_id' => $mitra->id,
                    'no_tagihan' => 'INV/' . date('Y') . '/' . rand(10000, 99999),
                    'keterangan' => 'Tagihan Internet Bulan ' . $i,
                    'harga_bandwidth' => $harga,
                    'total_tagihan' => $harga,
                    'total_dibayar' => $status === 'lunas' ? $harga : 0,
                    'sisa_tagihan' => $status === 'lunas' ? 0 : $harga,
                    'tanggal_tagihan' => now()->subMonths($i),
                    'tanggal_jatuh_tempo' => now()->subMonths($i)->addDays(30),
                    'status_pembayaran' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
