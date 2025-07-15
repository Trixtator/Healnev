<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered; // Pastikan ini ada

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ✅ PERIKSA APAKAH EMAIL SUDAH DIVERIFIKASI
            if (!$user->hasVerifiedEmail()) {
                Auth::logout(); // Logout pengguna jika belum
                // Redirect kembali dengan pesan untuk SweetAlert
                return back()->with('unverified', 'Akun Anda belum terverifikasi. Silakan periksa email Anda.');
            }

            // Jika login berhasil dan terverifikasi, arahkan ke dashboard
            $request->session()->regenerate();
            return redirect()->route('admin.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    // Kirim email verifikasi TANPA login user
    event(new Registered($user));

    // ✅ Jangan login di sini!
    // Auth::login($user); ← HAPUS ATAU JANGAN DIPAKAI

    return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Silakan periksa email Anda untuk verifikasi.');
}


    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // DIUBAH: Mengarahkan ke rute 'home' setelah logout
        return redirect()->route('home');
    }

    public function showRegistrationForm()
{
    // Pastikan path view ini benar
    return view('auth.register'); 
}

public function showLoginForm()
{
    // Pastikan path view ini benar
    return view('auth.login');
}
}