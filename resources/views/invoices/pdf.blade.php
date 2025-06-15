<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_code }}</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>INVOICE</h1>
    <p>Kode: <strong>{{ $order->order_code }}</strong></p>
    <p>Nama: {{ $order->user->name }}</p>
    <p>Paket: {{ $order->paket->nama_paket }}</p>
    <p>Tanggal Booking: {{ \Carbon\Carbon::parse($order->booking_date)->format('d F Y') }}</p>
    <p>Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
</body>
</html>
