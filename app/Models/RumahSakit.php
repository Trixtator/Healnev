<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    use HasFactory;

    public function pakets()
    {
        return $this->hasMany(Paket::class, 'rumahsakit_id');
    }

    protected $fillable = [
    'nama',
    'alamat',
    'telepon',
    'link_gmaps',
    'deskripsi',
    'gambar',
];

}
