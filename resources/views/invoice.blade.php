@extends('layouts.shared')

@section('content')
<section class="section pt-5">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Invoice: {{ $order->order_code }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Detail Pesanan</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 160px;">Nama Paket</td>
                                        <td>: {{ $order->paket->nama_paket }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rumah Sakit</td>
                                        <td>: {{ $order->paket->rumahSakit->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Booking</td>
                                        <td>: {{ \Carbon\Carbon::parse($order->booking_date)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Harga</td>
                                        <td class="fw-bold text-success">: Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/' . $order->paket->gambar) }}" 
                                     alt="Gambar Paket" 
                                     class="img-fluid rounded shadow-sm"
                                     style="width: 100%; height: 230px; object-fit: cover; border: 1px solid #ddd;">
                            </div>
                        </div>

                        <hr>

                        @if ($order->payment_status !== 'paid')
                            <div class="text-center mb-3">
                                <p class="text-muted">Klik tombol di bawah untuk melanjutkan ke pembayaran.</p>
                            </div>
                            <div class="d-grid mt-2">
                                <button id="pay-button" class="btn btn-success btn-lg">Bayar Sekarang</button>
                            </div>
                        @else
                            <div class="alert alert-success mt-4 text-center">✅ Pesanan ini sudah dibayar.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const payButton = document.getElementById('pay-button');
    let isPaying = false;

    if (payButton) {
        payButton.addEventListener('click', function () {
            if (isPaying) return;
            isPaying = true;
            payButton.disabled = true;
            payButton.innerHTML = 'Memproses...';

            // Tampilkan alert loading
            Swal.fire({
                title: 'Meminta Sesi Pembayaran...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Request AJAX ke backend untuk mendapatkan Snap Token
            fetch('{{ route("invoice.pay", $order->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); // Tutup alert loading

                if (data.error) {
                    throw new Error(data.error);
                }

                // Gunakan token untuk membuka pop-up pembayaran Snap
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        /* Implementasi Anda, contoh: */
                        Swal.fire({
                            icon: 'success',
                            title: 'Pembayaran Berhasil!',
                            text: 'Terima kasih atas pembayaran Anda.',
                        }).then(() => {
                           // Arahkan ke halaman sukses atau halaman utama
                           window.location.href = "{{ route('home') }}"; 
                        });
                    },
                    onPending: function(result){
                        /* Implementasi Anda, contoh: */
                        Swal.fire({
                            icon: 'info',
                            title: 'Pembayaran Tertunda',
                            text: 'Silakan selesaikan pembayaran Anda.',
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    onError: function(result){
                        /* Implementasi Anda, contoh: */
                         Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: 'Terjadi kesalahan saat memproses pembayaran.',
                        });
                        isPaying = false; // Aktifkan lagi tombolnya
                        payButton.disabled = false;
                        payButton.innerHTML = 'Bayar Sekarang';
                    },
                    onClose: function(){
                        /* Dipanggil saat pelanggan menutup pop-up tanpa menyelesaikan pembayaran */
                        console.log('customer closed the popup without finishing the payment');
                        isPaying = false; // Aktifkan lagi tombolnya
                        payButton.disabled = false;
                        payButton.innerHTML = 'Bayar Sekarang';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Terjadi kesalahan. Silakan coba lagi.',
                });
                isPaying = false; // Aktifkan lagi tombolnya
                payButton.disabled = false;
                payButton.innerHTML = 'Bayar Sekarang';
            });
        });
    }
});
</script>
@endsection