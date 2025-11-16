<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'produk';

    protected $fillable = [
        'mitra_id',
        'nama_produk',
        'bandwidth',
        'harga',
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

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class);
    }
}
