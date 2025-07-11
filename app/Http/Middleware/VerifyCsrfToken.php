<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        // 'https://041b-117-20-60-69.ngrok-free.app/midtrans/notification',
        '/botman',
        '/midtrans/notification',
        'api/midtrans/webhook',

    ];
}
