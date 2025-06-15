<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Jika belum login, redirect ke login
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'admin') {
            // Jika bukan admin, balik ke halaman sebelumnya
            return redirect()->back();
        }

        return $next($request);
    }
}
