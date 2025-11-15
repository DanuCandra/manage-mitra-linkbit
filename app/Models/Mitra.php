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
        'bandwith',
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
}
