<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\McuRegistration;
use PDF;

class RegistrationController extends Controller
{
    public function submitRegistration(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'passport' => 'required|string|max:20', // Add passport field validation
            'address' => 'required|string',
            'reservation_date' => 'required|date',
            'time' => 'required|string',
            'package' => 'required|string',
            'destination' => 'required|string',
        ]);

        // Simpan data ke dalam database
        $registration = McuRegistration::create($validatedData);

        // Simpan data ke dalam session
        session(['registration_data' => $registration]);

        return redirect()->route('verify-registration');
    }

    public function verifyRegistration()
    {
        // Retrieve data from session
        $registrationData = session('registration_data');

        // Check if registration data exists
        if (!$registrationData) {
            return redirect()->route('submit-registration')->with('error', 'No registration data found.');
        }

        return view('verify-registration', compact('registrationData'));
    }

    public function confirmRegistration(Request $request)
    {
        $registrationData = session('registration_data');
    
        if (!$registrationData) {
            return redirect()->route('submit-registration')->with('error', 'No registration data found.');
        }
    
        // Generate PDF
        $pdf = PDF::loadView('pdf.registration', compact('registrationData'));
    
        // Clear data from session after confirmation
        session()->forget('registration_data');
    
        // Return the generated PDF to the browser
        return $pdf->stream('registration.pdf');
    }
    

    public function createPDF(Request $request)
    {
        $registrationData = session('registration_data');
        $pdf = PDF::loadView('pdf.registration', compact('registrationData'));
        return $pdf->download('registration.pdf');
    }

    public function backToMain()
    {
        return redirect()->route('main')->with('success', 'Registration successful!');
    }
    
}
