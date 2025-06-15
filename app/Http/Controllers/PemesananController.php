<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Paket;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
public function form($id)
{
    $paket = Paket::findOrFail($id);
    return view('pemesanan.form', compact('paket'));
}

public function proses(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date|after_or_equal:'.now()->addDay()->format('Y-m-d'),
    ]);

    // Batasi hanya bisa pesan sampai H+10
    $batasTanggal = now()->addDays(10)->format('Y-m-d');
    if ($request->tanggal > $batasTanggal) {
        return back()->with('error', 'Tanggal melebihi batas pemesanan.');
    }

    // Cek kuota
    $jumlah = Pemesanan::where('paket_id', $request->paket_id)
        ->where('tanggal', $request->tanggal)
        ->whereNotIn('status', ['expired'])
        ->count();

    if ($jumlah >= 5) {
        return back()->with('error', 'Kuota tanggal ini sudah penuh.');
    }

    $pemesanan = Pemesanan::create([
        'paket_id' => $request->paket_id,
        'tanggal' => $request->tanggal,
        'status' => 'pending',
        'dibuat_pada' => now()
    ]);

    return redirect()->route('bayar.midtrans', $pemesanan->id);
}
}