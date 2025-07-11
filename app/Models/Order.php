<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'paket_id',
        'hospital_id',
        'order_code',
        'booking_date',
        'booking_time',
        'total_price',
        'payment_method',
        'payment_status',
        'snap_token',
        'paid_at', // Tambahkan ini
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'paid_at' => 'datetime', // Tambahkan ini
    ];

    public function paket()
    {
        // Method ini memberitahu Laravel bahwa sebuah 'Order' adalah 'milik' satu 'Paket'.
        // Laravel akan secara otomatis menggunakan kolom 'paket_id' untuk mencari hubungannya.
        return $this->belongsTo(Paket::class);
    }
    
    /**
     * (Praktik yang baik) Definisikan juga relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi baru ke RumahSakit
    public function hospital()
    {
        return $this->belongsTo(RumahSakit::class);
    }
}
