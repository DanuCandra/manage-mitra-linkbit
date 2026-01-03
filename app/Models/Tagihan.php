<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mitra_id',
        'no_tagihan',
        'keterangan',
        'harga_bandwidth',
        'total_tagihan',
        'total_dibayar',
        'sisa_tagihan',
        'tanggal_tagihan',
        'tanggal_jatuh_tempo',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_tagihan' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'harga_bandwidth' => 'decimal:2',
        'total_tagihan' => 'decimal:2',
        'total_dibayar' => 'decimal:2',
        'sisa_tagihan' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

            if (empty($model->no_tagihan)) {
                $model->no_tagihan = self::generateNoTagihan();
            }
        });
    }

    // Generate nomor tagihan otomatis (INV/2025/001)
    public static function generateNoTagihan()
    {
        $year  = now()->format('Y');
        $month = now()->format('m');
        $day   = now()->format('d');

        $base = "INV/{$year}/{$month}/{$day}";

        $length = 4; // mulai dari 4 digit
        $maxAttempts = 50; // batas percobaan per digit

        while (true) {
            for ($i = 0; $i < $maxAttempts; $i++) {

                // generate angka random sesuai panjang digit
                $randomNumber = random_int(
                    pow(10, $length - 1),
                    pow(10, $length) - 1
                );

                $invoiceNumber = "{$base}/{$randomNumber}";

                // cek ke database
                $exists = self::where('no_tagihan', $invoiceNumber)->exists();

                if (!$exists) {
                    return $invoiceNumber;
                }
            }

            // jika 4 digit "penuh"/banyak bentrok → naikkan digit
            $length++;
        }
    }


    // Relasi: Tagihan milik satu mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    // Relasi: Tagihan punya banyak pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_id');
    }

    // Relasi: Tagihan punya banyak riwayat cicilan
    public function riwayatCicilan()
    {
        return $this->hasMany(RiwayatCicilan::class, 'tagihan_id');
    }

    // Accessor: Ambil bandwidth dari mitra
    public function getBandwidthAttribute()
    {
        return $this->mitra->bandwidth ?? '-';
    }

    // Accessor: Format harga
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_bandwidth, 0, ',', '.');
    }

    public function getTotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->total_tagihan, 0, ',', '.');
    }

    public function getSisaFormatAttribute()
    {
        return 'Rp ' . number_format($this->sisa_tagihan, 0, ',', '.');
    }

    // Check apakah sudah jatuh tempo
    public function isJatuhTempo()
    {
        return now()->greaterThan($this->tanggal_jatuh_tempo) && $this->status_pembayaran !== 'lunas';
    }

    // Scope: Filter by status
    public function scopeBelumBayar($query)
    {
        return $query->where('status_pembayaran', 'belum_bayar');
    }

    public function scopeCicilan($query)
    {
        return $query->where('status_pembayaran', 'cicilan');
    }

    public function scopeLunas($query)
    {
        return $query->where('status_pembayaran', 'lunas');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status_pembayaran', 'terlambat');
    }
}
