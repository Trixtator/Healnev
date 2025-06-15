<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;

class KonsultasiController extends Controller
{
    public function index()
    {
        return view('konsultasi.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'dokter' => 'required|string|max:255',
        ]);

        Konsultasi::create($request->all());

        return redirect()->route('konsultasi.index')->with('success', 'Jadwal konsultasi berhasil ditambahkan.');
    }
}
