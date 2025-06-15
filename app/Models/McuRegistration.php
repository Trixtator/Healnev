<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuRegistration extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'birthdate', 'passport', 'address', 'reservation_date', 'time', 'package', 'status', 'destination', 'notes'];
}
