<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $mitraUsers = User::where('role', 'mitra')->get();

        foreach ($mitraUsers as $user) {
            DB::table('mitra')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'nama_mitra' => 'Mitra ' . $user->id,
                'nik' => $this->generateNumberString(16),
                'tgl_lahir' => now()->subYears(rand(20, 50)),
                'alamat' => 'Alamat Mitra ID ' . $user->id,
                'alamat_usaha' => 'Alamat Usaha Mitra ID ' . $user->id,
                'nama_brand' => 'Brand Mitra ' . $user->id,
                'no_nib' => $this->generateNumberString(13),
                'no_sertif_standar' => $this->generateNumberString(10),
                'tikor' => '-6.' . rand(100000, 999999) . ', 110.' . rand(100000, 999999),
                'bandwidth' => rand(10, 100) . ' Mbps',
                'jml_karyawan' => rand(1, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate angka random dalam bentuk STRING
     */
    private function generateNumberString(int $length): string
    {
        return collect(range(1, $length))
            ->map(fn() => rand(0, 9))
            ->implode('');
    }
}
