<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiwayatCicilanSeeder extends Seeder
{
    public function run(): void
    {
        $pembayaran = DB::table('pembayaran')
            ->where('jenis_pembayaran', 'cicilan')
            ->get();

        foreach ($pembayaran as $i => $pay) {
            DB::table('riwayat_cicilan')->insert([
                'id' => Str::uuid(),
                'tagihan_id' => $pay->tagihan_id,
                'pembayaran_id' => $pay->id,
                'cicilan_ke' => 1,
                'jumlah_cicilan' => $pay->jumlah_bayar,
                'tanggal_cicilan' => $pay->tanggal_bayar,
                'status' => collect(['pending', 'diterima'])->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
