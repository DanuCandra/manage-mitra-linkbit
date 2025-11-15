<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    // UUID bukan auto increment
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'mitra_id',
        'nib',
        'sertif_standar',
        'kso',
        'foto_ktp',
        'foto_usaha',
        'foto_brosur',
        'tahun',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi ke tabel mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
