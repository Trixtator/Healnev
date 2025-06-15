@extends('layouts.loglayout')

@section('title', 'Verify Registration')

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f7f9fc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
    }

    h1 {
        color: #1a73e8;
        text-align: center;
        margin-bottom: 20px;
    }

    .details,
    .hospital {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }

    .details p,
    .hospital p {
        margin: 10px 0;
        font-size: 16px;
    }

    strong {
        color: #333;
    }

    .confirm-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #1a73e8;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .confirm-btn:hover {
        background-color: #1558b6;
    }

    .note {
        text-align: center;
        color: #666;
        font-size: 14px;
        margin-top: 20px;
    }
</style>

@section('content')
<div class="container">
    <h1>Verify Your Registration Details</h1>
    <div class="details">
        @if(isset($registrationData))
            <p><strong>Name:</strong> {{ $registrationData['name'] ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $registrationData['email'] ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $registrationData['phone'] ?? 'N/A' }}</p>
            <p><strong>Birthdate:</strong> {{ $registrationData['birthdate'] ?? 'N/A' }}</p>
            <p><strong>Passport Number:</strong> {{ $registrationData['passport'] ?? 'N/A' }}</p>
            <p><strong>Address in Indonesia:</strong> {{ $registrationData['address'] ?? 'N/A' }}</p>
            <p><strong>Reservation Date:</strong> {{ $registrationData['reservation_date'] ?? 'N/A' }}</p>
            <p><strong>Time:</strong> {{ $registrationData['time'] ?? 'N/A' }}</p>
            <p><strong>Package:</strong> {{ $registrationData['package'] ?? 'N/A' }}</p>
            <p><strong>Destination:</strong> {{ $registrationData['destination'] ?? 'N/A' }}</p>
        @else
            <p>No registration data available.</p>
        @endif
    </div>
    <p><strong>🌟 Inspection Flow for Your Medical Check-Up (MCU) 🌟</strong></p>
    <ol>
        <li>Confirm Your Registration: After completing your registration, either save this page or print out your proof of registration.</li>
        <li>Visit Siloam Hospital, Yogyakarta: On your scheduled date, head to Siloam Hospital for your Medical Check-Up (MCU).</li>
        <li>Present Your Proof: Show your registration proof to the registration officer upon arrival.</li>
        <li>Verification & Direction: The officer will verify your details and guide you to the MCU section to proceed with your check-up.</li>
        <li>Important Note: Your tourist package is valid for 7 days from the date of purchase. After 7 days, the package will expire.</li>
    </ol>
    <div class="hospital">
        <h2>Recommended Hospital</h2>
        <p><strong>Hospital:</strong> Siloam Hospital, Yogyakarta</p>
        <p><strong>Address:</strong> Jl. Rear Admiral Adisucipto No.32-34, Demangan, Kec. Gondokusuman, Yogyakarta City, Yogyakarta Special Region 55221</p>
    </div>
    <form method="POST" action="{{ route('payment') }}">
        @csrf
        <button type="submit" class="confirm-btn" onclick="setPaymentStatus(true)">Payment</button>
    </form>
    <form method="POST" action="{{ route('create-pdf') }}">
        @csrf
        <button type="submit" class="confirm-btn">Cetak PDF</button>
    </form>
    <form id="registrationForm" method="GET" action="{{ route('back-to-main') }}">
        <button type="submit" class="confirm-btn" onclick="showSuccessPopup(event)">Back to Main</button>
    </form>
    <p class="note">Note: This is a fictional example for demonstration purposes.</p>
</div>

<script>
    function setPaymentStatus(status) {
        document.getElementById('paymentStatus').value = status;
    }

    function checkPaymentStatus(event) {
        const paymentStatus = document.getElementById('paymentStatus').value;
        if (paymentStatus === 'false') {
            event.preventDefault();
            alert('You must complete the payment before you can print the PDF.');
        }
    }

    function showSuccessPopup(event) {
        event.preventDefault();
        alert('Registration successful!');
        document.getElementById('registrationForm').submit();
    }
</script>
@endsection
