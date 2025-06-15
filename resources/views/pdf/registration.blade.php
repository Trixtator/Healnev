<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header, .footer {
            text-align: center;
            padding: 15px;
            background-color: #4a90e2; /* Bright blue */
            color: #fff;
        }
        .header h2 {
            font-size: 26px;
            margin: 0;
        }
        .header p {
            font-size: 14px;
            margin: 5px 0;
        }
        .container {
            margin: 20px auto;
            padding: 15px;
            max-width: 700px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4a90e2;
            font-size: 28px;
            margin-bottom: 15px;
        }
        p, ul {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        .strong {
            font-weight: bold;
            color: #4a90e2;
        }
        .official {
            margin-top: 20px;
            font-size: 14px;
            color: #2980b9;
            text-align: center;
            font-style: italic;
        }
        ol {
            margin: 15px 0;
            padding-left: 20px;
        }
        ol li {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        ul {
            list-style-type: square;
            padding-left: 20px;
        }
        .ul-item {
            margin: 4px 0;
        }
        .highlight {
            background-color: #eaf0f8;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #d6e4f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
        }
        .highlight h2 {
            color: #4a90e2;
            font-size: 18px;
            margin-top: 0;
        }
        .footer p {
            font-size: 12px;
            margin: 5px 0;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Siloam Hospital Yogyakarta</h2>
        <p>Jl. Laksda Adisucipto No.10, Yogyakarta, Indonesia</p>
        <p>Phone: +62 274 1234567 | Email: info@siloamhospitals.com</p>
    </div>
    <div class="container">
        <h1>Registration Details</h1>
        <p><span class="strong">Name:</span> {{ $registrationData['name'] }}</p>
        <p><span class="strong">Email:</span> {{ $registrationData['email'] }}</p>
        <p><span class="strong">Phone:</span> {{ $registrationData['phone'] }}</p>
        <p><span class="strong">Birthdate:</span> {{ $registrationData['birthdate'] }}</p>
        <p><span class="strong">Passport Number:</span> {{ $registrationData['passport'] }}</p>
        <p><span class="strong">Address in Indonesia:</span> {{ $registrationData['address'] }}</p>
        <p><span class="strong">Reservation Date:</span> {{ $registrationData['reservation_date'] }}</p>
        <p><span class="strong">Package:</span> {{ $registrationData['package'] }}</p>
        
       <!-- Destinations and Validity -->
<div class="highlight">
    <h2>Your Exciting Tourist Destinations Await!</h2>
    <p>Congratulations on choosing our exclusive package! With your selected package, you have the opportunity to explore a range of breathtaking destinations:</p>
    <ul>
        <?php if ($registrationData['package'] == 'Basic'): ?>
            <li class="ul-item">Glistening Beach Paradise</li>
            <li class="ul-item">Historic Cultural Village</li>
        <?php elseif ($registrationData['package'] == 'Standard'): ?>
            <li class="ul-item">Glistening Beach Paradise</li>
            <li class="ul-item">Historic Cultural Village</li>
            <li class="ul-item">Majestic Mountain Retreat</li>
        <?php elseif ($registrationData['package'] == 'Premium'): ?>
            <li class="ul-item">Glistening Beach Paradise</li>
            <li class="ul-item">Historic Cultural Village</li>
            <li class="ul-item">Majestic Mountain Retreat</li>
            <li class="ul-item">Exclusive Private Island</li>
        <?php endif; ?>
    </ul>
    <p><strong>Important:</strong> Your access to these fantastic destinations is valid for up to 7 days from the moment of purchase. Make the most of your experience, as the package will expire after this period.</p>
</div>

        <p><strong>Inspection Flow:</strong></p>
        <ol>
            <li>After registering, save this page or print proof of registration.</li>
            <li>Come to Siloam Hospital, Yogyakarta on the scheduled date for Medical Check-Up (MCU).</li>
            <li>Show proof of this registration to the registration officer at the hospital.</li>
            <li>The officer will verify your registration and direct you to the MCU section to continue the inspection process.</li>
        </ol>
        <p class="official"><strong>This document is official and issued by Siloam Hospital, Yogyakarta.</strong></p>
    </div>
    <div class="footer">
        <p>&copy; 2024 Siloam Hospital Yogyakarta. All rights reserved.</p>
        <p>Visit our website: <a href="https://www.siloamhospitals.com">www.siloamhospitals.com</a></p>
    </div>
</body>
</html>
