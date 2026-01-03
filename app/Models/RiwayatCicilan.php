<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RiwayatCicilan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_cicilan';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tagihan_id',
        'pembayaran_id',
        'cicilan_ke',
        'jumlah_cicilan',
        'tanggal_cicilan',
        'status',
    ];

    protected $casts = [
        'tanggal_cicilan' => 'date',
        'jumlah_cicilan' => 'decimal:2',
        'cicilan_ke' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi: Cicilan untuk satu tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }

    // Relasi: Cicilan dari satu pembayaran
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }

    // Accessor: Format jumlah cicilan
    public function getJumlahFormatAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_cicilan, 0, ',', '.');
    }

    // Accessor: Status badge color
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger',
            default => 'secondary'
        };
    }

    // Scope: Filter by status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}
