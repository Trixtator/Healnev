<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\RumahSakit;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::with('rumahsakit')->latest()->paginate(10);
        $rumahsakit = RumahSakit::all(); // untuk dropdown di modal

        return view('paket.index', compact('pakets', 'rumahsakit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'rumahsakit_id' => 'required|exists:rumah_sakits,id',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('gambar_paket', 'public');
        }

        Paket::create([
            'nama_paket' => $request->nama_paket,
            'rumahsakit_id' => $request->rumahsakit_id,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'rumahsakit_id' => 'required|exists:rumah_sakits,id',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $paket = Paket::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($paket->gambar) {
                Storage::disk('public')->delete($paket->gambar);
            }

            $paket->gambar = $request->file('gambar')->store('gambar_paket', 'public');
        }

        $paket->update([
            'nama_paket' => $request->nama_paket,
            'rumahsakit_id' => $request->rumahsakit_id,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        if ($paket->gambar) {
            Storage::disk('public')->delete($paket->gambar);
        }
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
    }
    
    public function show($id)
{
    $paket = Paket::with('rumahsakit')->findOrFail($id); // include relasi rumahsakit
    return view('detail-paket', compact('paket'));
}

 public function publicIndex()
    {
        // Logika untuk User (lebih simpel)
        // Kita set 16 paket per halaman seperti permintaan Anda sebelumnya
        $pakets = Paket::with('rumahsakit')->latest()->paginate(12);

        // Mengirim data ke view 'packages.blade.php' yang sudah kita buat
        return view('packages', compact('pakets'));
    }




}
