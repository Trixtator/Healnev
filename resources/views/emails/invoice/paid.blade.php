@component('mail::message')
# Pembayaran Berhasil 🎉

Halo {{ $order->user->name }},

Pembayaran untuk pesanan **{{ $order->order_code }}** telah berhasil!

### Detail:
- **Paket**: {{ $order->paket->nama_paket }}
- **Rumah Sakit**: {{ $order->paket->rumahSakit->nama }}
- **Tanggal Booking**: {{ \Carbon\Carbon::parse($order->booking_date)->format('d F Y') }}
- **Total**: Rp {{ number_format($order->total_price, 0, ',', '.') }}

🧾 Invoice terlampir di email ini.

@component('mail::button', ['url' => route('invoice.download', $order->id)])
📄 Download Invoice PDF
@endcomponent

Terima kasih telah memesan melalui layanan kami!

Salam,  
{{ config('app.name') }}
@endcomponent
