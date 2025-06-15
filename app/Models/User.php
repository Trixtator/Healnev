<?php

namespace App\Models;

// ... use statements ...
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Jika menggunakan Sanctum

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Tambahkan HasApiTokens jika pakai Sanctum

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'passport_name',    // Jika ada field ini
        'address',          // Jika ada field ini
        'birth_date',       // Jika ada field ini
        'profile_picture',  // << PASTIKAN INI ADA
        // tambahkan field lain yang ingin bisa diisi secara massal
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Otomatis hash jika menggunakan Laravel 9+
        'birth_date' => 'date',  // Jika birth_date adalah tipe date
    ];
    public function orders()
{
    return $this->hasMany(Order::class);
}

}