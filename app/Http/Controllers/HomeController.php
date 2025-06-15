<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket; // Pastikan model di-import

class HomeController extends Controller
{
     public function index()
    {
        // 1. Ambil HANYA 8 paket terbaru untuk ditampilkan di homepage
        // Diurutkan berdasarkan yang paling baru dibuat
        $latestPakets = Paket::with('rumahsakit')->latest()->limit(8)->get();

        // 2. Hitung jumlah TOTAL semua paket yang ada di database
        // Ini untuk logika menampilkan tombol "View More"
        $totalPaketCount = Paket::count();

        // 3. Kirim kedua variabel tersebut ke view 'index.blade.php'
        return view('index', [
            'pakets' => $latestPakets,
            'totalPakets' => $totalPaketCount
        ]);
    }

    // TAMBAHKAN METHOD INI
    public function detailPaket($id)
    {
        // 1. Cari paket di database berdasarkan ID yang dikirim dari URL.
        //    findOrFail() akan otomatis menampilkan halaman 404 Not Found jika ID tidak ada.
        $paket = Paket::with('rumahsakit')->findOrFail($id);

        // 2. Kirim data satu paket tersebut ke sebuah view baru.
        //    Kita akan membuat view bernama 'detail-paket.blade.php'
        return view('detail-paket', compact('paket'));
    }
}