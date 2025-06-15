<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = ['nama_paket', 'rumahsakit_id', 'harga', 'deskripsi', 'gambar'];

    public function rumahsakit()
    {
        return $this->belongsTo(RumahSakit::class, 'rumahsakit_id', 'id');
    }
}
