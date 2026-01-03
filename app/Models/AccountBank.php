<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccountBank extends Model
{
    use HasFactory;

    protected $table = 'account_bank';

    // Primary key menggunakan UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'status',
    ];

    // Auto generate UUID
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi: Bank ini digunakan di banyak pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'account_bank_id');
    }

    // Scope: Hanya bank aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
