@extends('layouts.shared')

@section('content')

<section class="section pt-5">
    <div class="container">
        <div class="row align-items-center">
            {{-- Bagian informasi paket (tidak berubah) --}}
            <div class="col-md-5 mb-4 mb-md-0">
                <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->nama_paket }}" class="img-fluid rounded" style="height: 300px; width: 100%; object-fit: cover;">
            </div>
            <div class="col-md-7">
                <h2 class="mb-2">{{ $paket->nama_paket }}</h2>
                @if($paket->rumahsakit)
                    <span class="badge bg-secondary mb-3 px-3 py-1 fs-6" style="border-radius: 8px; color: white;">{{ $paket->rumahsakit->nama }}</span>
                @endif
                
                <h3 class="text-warning fw-bold mb-3">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h3>

                {{-- Ganti tombol lama Anda di file detail.blade.php dengan blok logika ini --}}

@auth
    {{-- JIKA SUDAH LOGIN: Tampilkan tombol "Pesan Sekarang" yang akan membuka modal --}}
    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#orderModal">
        Pesan Sekarang
    </button>
@endauth

@guest
    {{-- JIKA BELUM LOGIN (TAMU): Tampilkan tombol yang mengarahkan ke halaman login --}}
    {{-- Pastikan Anda memiliki rute dengan nama 'login' di routes/web.php --}}
    <a href="{{ route('login') }}" class="btn btn-primary mt-3">
        Pesan Sekarang
    </a>
@endguest
            </div>
        </div>

        {{-- Bagian deskripsi (tidak berubah) --}}
        <div class="row mt-5">
            <div class="col-md-8">
                <h5>Detail Pemeriksaan</h5>
                <div>{!! $paket->deskripsi !!}</div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Form Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Form yang akan diisi pengguna --}}
                <form id="orderForm">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                    {{-- Info yang tidak bisa diubah --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" value="{{ $paket->nama_paket }}" readonly>
                    </div>

                    {{-- === TAMBAHAN BARU: Menampilkan Rumah Sakit === --}}
                    <div class="mb-3">
                        <label class="form-label">Rumah Sakit</label>
                        <input type="text" class="form-control" value="{{ $paket->rumahsakit->nama ?? 'N/A' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($paket->harga, 0, ',', '.') }}" readonly>
                    </div>
                    <hr>
                    {{-- Input dari pengguna --}}
                    <div class="mb-3">
                        <label for="tanggal_booking" class="form-label fw-bold">Pilih Tanggal Booking</label>
                        <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" required>
                        <div id="quotaInfo" class="form-text mt-2"></div>
                    </div>
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">
<!-- <input type="hidden" name="hospital_id" value="{{ $paket->rumahsakit->id }}"> -->

<div class="mb-3">
    <label for="booking_time" class="form-label fw-bold">Pilih Jam Booking</label>
    <select class="form-control" id="booking_time" name="booking_time" required>
        <option value="08:00:00">08:00 WIB</option>
        </select>
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitOrder" disabled>Lanjut ke Pembayaran</button>
            </div>
        </div>
    </div>
</div>

{{-- Script Midtrans (pastikan client key Anda benar di .env) --}}
<script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('Mid-client-tsGJe31nWvY18Npe') }}"></script>
@endsection


{{-- =================================================================
     JAVASCRIPT LOGIC
================================================================== --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        const paketId = $('input[name="paket_id"]').val();
        const bookingDateInput = $('#tanggal_booking');
        const quotaInfo = $('#quotaInfo');
        const submitButton = $('#submitOrder');
        let isSubmitting = false;

        // Batasi tanggal booking (H+1 s/d H+10)
        const today = new Date();
        const minDate = new Date(today.setDate(today.getDate() + 1));
        const maxDate = new Date();
        maxDate.setDate(minDate.getDate() + 9);

        const formatDate = (date) => date.toISOString().split('T')[0];
        bookingDateInput.attr('min', formatDate(minDate));
        bookingDateInput.attr('max', formatDate(maxDate));

        bookingDateInput.on('change', function () {
            const selectedDate = $(this).val();
            quotaInfo.text('Mengecek kuota...').removeClass('text-success text-danger');
            submitButton.prop('disabled', true).text('Lanjut ke Pembayaran');

            if (!selectedDate) {
                quotaInfo.text('Silakan pilih tanggal booking.');
                return;
            }

            $.ajax({
                url: `/api/paket/${paketId}/check-quota`,
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({ tanggal: selectedDate }),
                success: function (response) {
                    if (response.available) {
                        quotaInfo.text(`Kuota tersedia: ${response.sisa_kuota} slot.`).addClass('text-success');
                        submitButton.prop('disabled', false);
                    } else {
                        quotaInfo.text('Kuota habis. Silakan pilih tanggal lain.').addClass('text-danger');
                    }
                },
                error: function () {
                    quotaInfo.text('Gagal mengecek kuota.').addClass('text-danger');
                }
            });
        });

        // Submit order hanya sekali
        submitButton.on('click', function () {
            if (isSubmitting) return;

            isSubmitting = true;
            submitButton.prop('disabled', true); // TANPA ubah teks tombol

            $.ajax({
                url: '{{ route("api.order.create") }}',
                type: 'POST',
                data: $('#orderForm').serialize(),
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert('Terjadi kesalahan saat membuat pesanan.');
                        resetButton();
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Silakan coba lagi.'));
                    resetButton();
                }
            });

            function resetButton() {
                isSubmitting = false;
                submitButton.prop('disabled', false);
            }
        });
    });
</script>
@endpush
