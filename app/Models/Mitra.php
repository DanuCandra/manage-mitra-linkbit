<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = "mitra";

    // ⚡ WAJIB tambahkan ini agar Laravel tahu id bukan integer
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    protected $fillable = [
        'user_id',
        'nama_mitra',
        'nik',
        'tgl_lahir',
        'npwp',
        'alamat',
        'alamat_usaha',
        'nama_brand',
        'no_nib',
        'no_sertif_standar',
        'tikor',
        'bandwidth',
        'jml_karyawan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class);
    }

    public function getBandwidthFormattedAttribute()
    {
        $bandwidth = $this->bandwidth ?? 0;

        if ($bandwidth >= 1000) {
            // Convert to Gbps
            $gbps = $bandwidth / 1000;

            // Format: hapus .0 jika bulat, tampilkan 1 desimal jika ada
            if ($gbps == floor($gbps)) {
                return number_format($gbps, 0) . ' Gbps';
            } else {
                return number_format($gbps, 1) . ' Gbps';
            }
        }

        return $bandwidth . ' Mbps';
    }

    /**
     * Get bandwidth value dalam Mbps (raw value)
     *
     * @return int
     */
    public function getBandwidthMbpsAttribute()
    {
        return $this->bandwidth ?? 0;
    }
}
