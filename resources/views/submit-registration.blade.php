@extends('layouts.loglayout')

@section('title', 'Submit Registration')

@section('content')
<h1>Submit Registration Form</h1>
<form id="registration-form" method="POST">
    @csrf
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">Phone:</label><br>
    <input type="tel" id="phone" name="phone" required><br><br>

    <label for="birthdate">Birthdate:</label><br>
    <input type="date" id="birthdate" name="birthdate" required><br><br>

    <label for="passport">Passport Number:</label><br>
    <input type="text" id="passport" name="passport" required><br><br>

    <label for="address">Address in Indonesia:</label><br>
    <textarea id="address" name="address" required></textarea><br><br>

    <label for="reservation_date">Reservation Date:</label><br>
    <input type="date" id="reservation_date" name="reservation_date" required><br><br>

    <label for="time">Time:</label><br>
    <select id="time" name="time" required>
        <option value="09.00 AM">09.00 AM</option>
        <option value="13.00 PM">13.00 PM</option>
        <option value="16.00 PM">16.00 PM</option>
        <option value="20.00 PM">20.00 PM</option>
    </select><br><br>

    <label for="package">Package:</label><br>
    <select id="package" name="package" required>
        <option value="basic">Basic</option>
        <option value="standard">Standard</option>
        <option value="premium">Premium</option>
    </select><br><br>

    <label for="destination">Destination:</label><br>
    <input type="text" id="destination" name="destination" required><br><br>

    <button type="submit">Submit</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#registration-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('submit-registration') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: $("#name").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    birthdate: $("#birthdate").val(),
                    passport: $("#passport").val(),
                    address: $("#address").val(),
                    reservation_date: $("#reservation_date").val(),
                    time: $("#time").val(),
                    package: $("#package").val(), // Tambahkan koma di sini
                    destination: $("#destination").val() // Tambahkan destination
                },
                success: function (response) {
                    window.location.href = "{{ route('verify-registration') }}";
                },
                error: function (xhr) {
                    // Handle error
                    console.log(xhr.responseText); // Tambahkan untuk debug
                }
            });
        });
    });
</script>
@endsection
