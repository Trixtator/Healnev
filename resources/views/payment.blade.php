@extends('layouts.loglayout')

@section('title', 'Payment Page')

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

    .payment-form {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        text-align: center;
    }

    .payment-form label {
        display: block;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .payment-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .payment-form button {
        width: 100%;
        padding: 12px;
        background-color: #1a73e8;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .payment-form button:hover {
        background-color: #1558b6;
    }

    .bank-details {
        text-align: left;
        margin-top: 20px;
    }

    .qr-code {
        margin: 20px 0;
    }

    .qr-code img {
        max-width: 50%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .back-button {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        background-color: #ddd;
        color: #000;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #bbb;
    }
</style>

@section('content')
<div class="container">
    <h1>Payment Page</h1>
    <form method="POST" action="{{ route('process.payment') }}" class="payment-form">
        @csrf

        <!-- Display selected package and its price -->
        <p><strong>Selected Package:</strong> {{ $registrationData['package'] ?? 'N/A' }}</p>
        <p><strong>Package Price:</strong> {{ $packagePrice }}</p>

        <!-- Bank Account Selection for Bank Transfer -->
        <label for="bank-account">Select Bank Account:</label>
        <select id="bank-account" name="bank_account" required>
            <option value="hsbc">HSBC - Account Number: 123456789</option>
            <option value="citibank">Citibank - Account Number: 987654321</option>
            <option value="standard_chartered">Standard Chartered - Account Number: 1122334455</option>
            <option value="dbs">DBS Bank - Account Number: 2233445566</option>
            <option value="bank_of_america">Bank of America - Account Number: 3344556677</option>
            <option value="jp_morgan_chase">JP Morgan Chase - Account Number: 4455667788</option>
            <option value="bca">BCA - Account Number: 5566778899</option>
            <option value="mandiri">Bank Mandiri - Account Number: 6677889900</option>
            <option value="bni">BNI - Account Number: 7788990011</option>
            <option value="bri">BRI - Account Number: 8899001122</option>
            <!-- Add more bank accounts as needed -->
        </select>

        <div class="qr-code">
            <img src="{{ asset('/assets/images/QR.png') }}" alt="QR Code">
        </div>

        <div class="bank-details">
            <p>Please transfer the total amount to the selected bank account. Include your registration ID in the payment description for verification purposes.</p>
        </div>
    </form>

    <!-- Add Back to Main button -->
    <form method="GET" action="{{ route('verify-registration') }}">
        @csrf
        <button type="submit" class="back-button">Back to Main</button>
    </form>
</div>
@endsection
