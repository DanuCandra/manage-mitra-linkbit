<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tagihan_id',
        'account_bank_id',
        'no_pembayaran',
        'jenis_pembayaran',
        'jumlah_bayar',
        'tanggal_bayar',
        'bukti_bayar',
        'nama_pengirim',
        'bank_pengirim',
        'catatan',
        'status_verifikasi',
        'alasan_ditolak',
        'tanggal_verifikasi',
        'verified_by',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'tanggal_verifikasi' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

            // Auto generate nomor pembayaran
            if (empty($model->no_pembayaran)) {
                $model->no_pembayaran = self::generateNoPembayaran();
            }
        });
    }

    // Generate nomor pembayaran otomatis (PAY/2025/001)
    public static function generateNoPembayaran()
    {
        $year = date('Y');
        $lastPembayaran = self::whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->first();

        $number = $lastPembayaran ? (int) substr($lastPembayaran->no_pembayaran, -3) + 1 : 1;

        return 'PAY/' . $year . '/' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    // Relasi: Pembayaran untuk satu tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }

    // Relasi: Pembayaran ke account bank
    public function accountBank()
    {
        return $this->belongsTo(AccountBank::class, 'account_bank_id');
    }

    // Relasi: Admin yang verifikasi
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relasi: Pembayaran punya riwayat cicilan
    public function riwayatCicilan()
    {
        return $this->hasMany(RiwayatCicilan::class, 'pembayaran_id');
    }

    // Accessor: Format jumlah bayar
    public function getJumlahFormatAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_bayar, 0, ',', '.');
    }

    // Accessor: Status badge color
    public function getStatusBadgeAttribute()
    {
        return match ($this->status_verifikasi) {
            'pending' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger',
            default => 'secondary'
        };
    }

    // Scope: Filter by status verifikasi
    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status_verifikasi', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', 'ditolak');
    }
}
