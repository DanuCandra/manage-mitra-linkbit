<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Mitra;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'status',
        'nama_lengkap',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mitra()
    {
        return $this->hasOne(Mitra::class);
    }

    // Accessor untuk mendapatkan URL foto profil
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && Storage::disk('public')->exists('profile-foto/' . $this->profile_photo)) {
            return asset('storage/profile-foto/' . $this->profile_photo);
        }
        return asset('assets/images/profile/user-1.jpg');
    }

    // Event untuk menghapus foto saat user dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->profile_photo && Storage::disk('public')->exists('profile-foto/' . $user->profile_photo)) {
                Storage::disk('public')->delete('profile-foto/' . $user->profile_photo);
            }
        });
    }
}
