<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pelanggan extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'pelanggan';

    protected $fillable = [
        'id_pelanggan',
        'mitra_id',
        'produk_id',
        'nama',
        'nik',
        'alamat',
        'mulai_berlangganan',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
