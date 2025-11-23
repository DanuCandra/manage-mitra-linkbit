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

    // Helper untuk mendapatkan bandwidth dalam Mbps
    public function getBandwidthInMbps()
    {
        if (empty($this->bandwidth)) {
            return 0;
        }

        // Format: "100 Mbps" atau "1 Gbps"
        preg_match('/(\d+(?:\.\d+)?)\s*(Mbps|Gbps)/i', $this->bandwidth, $matches);

        if (empty($matches)) {
            return 0;
        }

        $value = floatval($matches[1]);
        $unit = strtolower($matches[2]);

        if ($unit === 'gbps') {
            return $value * 1000; // Convert to Mbps
        }

        return $value;
    }

    // Helper untuk format bandwidth
    public function getFormattedBandwidth()
    {
        return $this->bandwidth ?? '0 Mbps';
    }
}
