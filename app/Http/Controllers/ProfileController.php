<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    
    /**
     * Menampilkan halaman profil pengguna (opsional).
     */
    public function show()
{
    $user = Auth::user();
    $orders = $user->orders()->with('paket.rumahSakit')->latest()->get();

    return view('profile.show', compact('user', 'orders'));
}


    /**
     * Menampilkan form untuk mengedit profil pengguna.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Mengupdate data profil pengguna (HANYA DATA PRIBADI DARI FORM UTAMA).
     * Email dan Password diupdate melalui method AJAX terpisah.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi HANYA untuk field yang ada di form utama update data pribadi
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' TIDAK DIVALIDASI DI SINI LAGI karena ditangani oleh updateEmail() via AJAX
            'passport_name' => 'nullable|string|max:255', // Pastikan nama field ini sesuai dengan input di form Anda
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Validasi untuk 'current_password' dan 'new_password' juga TIDAK ADA DI SINI
            // karena password hanya diubah via AJAX modal melalui updatePassword()
        ], [
            // Pesan error kustom jika diperlukan
            'name.required' => 'Nama lengkap wajib diisi.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format gambar yang didukung: jpeg, png, jpg, gif, svg.',
            'profile_photo.max' => 'Ukuran gambar maksimal 2MB.',
            // Tambahkan pesan kustom lain jika perlu untuk field di atas
        ]);

        // Siapkan data untuk diupdate (HANYA DATA PRIBADI)
        $userDataToUpdate = [
            'name' => $request->name,
            // 'email' TIDAK DIUPDATE DI SINI LAGI
            'passport_name' => $request->passport_name, // Pastikan nama field ini sesuai
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ];

        // Handle upload foto profil jika ada file baru
        // ... di dalam method update() ...
// Handle upload foto profil jika ada file baru
if ($request->hasFile('profile_photo')) { // 'profile_photo' adalah nama input di form, ini sudah benar
    // Hapus foto lama jika ada, gunakan nama kolom yang benar
    if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
        Storage::disk('public')->delete($user->profile_picture);
    }
    // Simpan foto baru
    $path = $request->file('profile_photo')->store('profile-photos', 'public'); // Menyimpan file ke 'storage/app/public/profile-photos'
    $userDataToUpdate['profile_picture'] = $path; // Simpan path ke kolom 'profile_picture'
}
// ...
$user->update($userDataToUpdate);
// ...

        return redirect()->route('profile.edit')->with('success', 'Data pribadi berhasil diperbarui!');
    }


    /**
     * Update the authenticated user's password via AJAX.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string', 'current_password'],
            'new_password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini salah.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal :min karakter.',
            'new_password.symbols' => 'Password baru harus mengandung simbol.',
            'new_password.mixedCase' => 'Password baru harus mengandung huruf besar dan kecil.',
            'new_password.numbers' => 'Password baru harus mengandung angka.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            if (!$user) {
                 return response()->json(['success' => false, 'message' => 'User tidak ditemukan atau tidak terautentikasi.'], 401);
            }
            $user->forceFill(['password' => Hash::make($request->input('new_password'))])->save();
            return response()->json(['success' => true, 'message' => 'Password berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('AJAX Error update password user ID ' . ($request->user() ? $request->user()->id : 'Unknown') . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui password karena kesalahan server.'], 500);
        }
    }

    /**
     * Update the authenticated user's email via AJAX.
     */
    public function updateEmail(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak terautentikasi.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        try {
            $user->forceFill(['email' => $request->input('email')])->save();
            return response()->json(['success' => true, 'message' => 'Email berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('AJAX Error update email user ID ' . $user->id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui email karena kesalahan server.'], 500);
        }
    }
}