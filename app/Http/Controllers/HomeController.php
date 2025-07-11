<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;
use App\Models\Paket; // Pastikan model di-import

class HomeController extends Controller
{
    public function index()
    {
        // 1. Kumpulkan SEMUA data yang dibutuhkan
        $testimonis = Testimoni::where('is_active', 1)->with('user')->latest()->get();
        $latestPakets = Paket::with('rumahsakit')->latest()->limit(8)->get();
        $totalPaketCount = Paket::count();

        // 2. Kirim SEMUA data ke view dalam satu kali return
        return view('index', [
            'testimonis' => $testimonis,      // Data testimoni
            'pakets' => $latestPakets,         // Data paket
            'totalPakets' => $totalPaketCount  // Jumlah total paket
        ]);
    }

    // METHOD INI SUDAH BENAR
    public function detailPaket($id)
    {
        // Cari paket di database berdasarkan ID
        $paket = Paket::with('rumahsakit')->findOrFail($id);

        // Kirim data satu paket tersebut ke view 'detail-paket'
        return view('detail-paket', compact('paket'));
    }
}