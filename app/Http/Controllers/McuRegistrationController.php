<?php

namespace App\Http\Controllers;

use App\Models\McuRegistration;
use Illuminate\Http\Request;

class McuRegistrationController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'birthdate' => 'required|date',
            'passport' => 'required',
            'address' => 'required',
            'reservation_date' => 'required|date',
            'time' => 'required|string',
            'package' => 'required',
            'destination' => 'required',
        ]);

        // Simpan data ke database
        $mcuRegistration = McuRegistration::create($validatedData);

        // Tambahkan pesan sukses ke dalam sesi
        $request->session()->flash('success', 'Pendaftaran berhasil!');

        // Redirect kembali ke halaman pendaftaran
        return redirect()->back();
    }

    public function showVerification(Request $request)
    {
    $name = $request->input('name');
    $phone = $request->input('phone');
    $email = $request->input('email');
    $birthdate = $request->input('birthdate');
    $passport = $request->input('passport');
    $address = $request->input('address');
    $reservation_date = $request->input('reservation_date');
    $time = $request->input('time');
    $package = $request->input('package');
    $destination = $request->input('destination');
    $notes = $request->input('notes');

    return view('verification', compact('name', 'phone', 'email', 'birthdate','passport', 'address','reservation_date','time' ,'package', 'destination', 'notes'));
    }

}
