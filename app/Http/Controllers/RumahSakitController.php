<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;
use Illuminate\Support\Facades\Storage;

class RumahSakitController extends Controller
{
    /**
     * Tampilkan semua data rumah sakit.
     */
    public function index()
    {
        $rumahsakit = RumahSakit::paginate(10);
        return view('rumahsakit.index', compact('rumahsakit'));
    }

    /**
     * Simpan data rumah sakit baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'link_gmaps' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('rumahsakit', 'public');
            }

            RumahSakit::create($validated);

            return redirect()->route('rumahsakit.index')
                ->with('success', 'Rumah Sakit berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Update data rumah sakit.
     */
    public function update(Request $request, $id)
    {
        $rumahsakit = RumahSakit::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'link_gmaps' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($rumahsakit->gambar && Storage::disk('public')->exists($rumahsakit->gambar)) {
                    Storage::disk('public')->delete($rumahsakit->gambar);
                }

                $validated['gambar'] = $request->file('gambar')->store('rumahsakit', 'public');
            }

            $rumahsakit->update($validated);

            return redirect()->route('rumahsakit.index')
                ->with('success', 'Rumah Sakit berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data rumah sakit.
     */
    public function destroy($id)
    {
        $rumahsakit = RumahSakit::findOrFail($id);

        try {
            // Hapus file gambar jika ada
            if ($rumahsakit->gambar && Storage::disk('public')->exists($rumahsakit->gambar)) {
                Storage::disk('public')->delete($rumahsakit->gambar);
            }

            $rumahsakit->delete();

            return redirect()->route('rumahsakit.index')
                ->with('success', 'Rumah Sakit berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    public function publicIndex()
{
    // Ambil data dengan paginasi, misal 12 per halaman, dan urutkan berdasarkan nama
    $rumahsakit = RumahSakit::orderBy('nama', 'asc')->paginate(12);
    return view('hospital', compact('rumahsakit'));
}

public function show($id)
{
    $rumahsakit = RumahSakit::findOrFail($id);
    return view('detail-hospital', compact('rumahsakit'));
}


}
