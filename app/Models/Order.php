<?php

// File: app/Models/Order.php

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
        'hospital_id', // <-- Tambahkan
        'order_code',
        'booking_date',
        'booking_time', // <-- Tambahkan
        'total_price',
        'payment_method', // <-- Tambahkan
        'payment_status',
        'snap_token',
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
