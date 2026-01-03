<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $tagihan = DB::table('tagihan')
            ->whereIn('status_pembayaran', ['lunas', 'cicilan'])
            ->get();

        $banks = DB::table('account_bank')->get();

        if ($banks->isEmpty() || $tagihan->isEmpty()) {
            return;
        }

        foreach ($tagihan as $item) {
            $jumlahBayar = $item->status_pembayaran === 'lunas'
                ? $item->total_tagihan
                : rand(100000, (int) ($item->total_tagihan / 2));

            // Nama bank pengirim contoh
            $bankPengirims = ['BCA', 'BNI', 'BRI', 'Mandiri', 'CIMB Niaga', 'Permata', 'Danamon'];

            $statusVerifikasi = collect(['pending', 'diterima', 'ditolak'])->random();
            $tanggalVerifikasi = $statusVerifikasi === 'pending' ? null : now()->subDays(rand(0, 10));

            DB::table('pembayaran')->insert([
                'id' => Str::uuid(),
                'tagihan_id' => $item->id,
                'account_bank_id' => $banks->random()->id,
                'no_pembayaran' => 'PAY/' . date('Y') . '/' . rand(10000, 99999),
                'jenis_pembayaran' => $item->status_pembayaran === 'lunas' ? 'full' : 'cicilan',
                'jumlah_bayar' => $jumlahBayar,
                'tanggal_bayar' => now()->subDays(rand(1, 10)),
                // bukti_bayar dibiarkan null sesuai permintaan
                'bukti_bayar' => null,
                'nama_pengirim' => 'Pengirim ' . substr((string) Str::uuid(), 0, 8),
                'bank_pengirim' => $bankPengirims[array_rand($bankPengirims)],
                'status_verifikasi' => $statusVerifikasi,
                'tanggal_verifikasi' => $tanggalVerifikasi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
