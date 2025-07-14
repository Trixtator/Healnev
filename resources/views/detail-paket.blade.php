@extends('layouts.shared')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <h1 class="text-capitalize mb-5 text-lg">Package Details</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section pt-5">
    <div class="container">
        <div class="row align-items-center">
            {{-- Package information section --}}
            <div class="col-md-5 mb-4 mb-md-0">
                <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->nama_paket }}" class="img-fluid rounded" style="height: 300px; width: 100%; object-fit: cover;">
            </div>
            <div class="col-md-7">
                <h2 class="mb-2">{{ $paket->nama_paket }}</h2>
                @if($paket->rumahsakit)
                    <span class="badge bg-secondary mb-3 px-3 py-1 fs-6" style="border-radius: 8px; color: white;">{{ $paket->rumahsakit->nama }}</span>
                @endif

                <h3 class="text-warning fw-bold mb-3">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h3>

                {{-- Booking button logic --}}
                @auth
                    {{-- IF LOGGED IN: Show modal trigger --}}
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#orderModal">
                        Book Now
                    </button>
                @endauth

                @guest
                    {{-- IF GUEST: Link to login --}}
                    <a href="{{ route('login') }}" class="btn btn-primary mt-3">
                        Book Now
                    </a>
                @endguest
            </div>
        </div>

        {{-- Description section --}}
        <div class="row mt-5">
            <div class="col-md-8">
                <h5>Checkup Details</h5>
                <div>{!! $paket->deskripsi !!}</div>
            </div>
        </div>
    </div>
</section>

{{-- Booking Modal --}}
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Booking Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="orderForm">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                    {{-- Non-editable info --}}
                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        <input type="text" class="form-control" value="{{ $paket->nama_paket }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hospital</label>
                        <input type="text" class="form-control" value="{{ $paket->rumahsakit->nama ?? 'N/A' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($paket->harga, 0, ',', '.') }}" readonly>
                    </div>

                    <hr>

                    {{-- User input --}}
                    <div class="mb-3">
                        <label for="tanggal_booking" class="form-label fw-bold">Select Booking Date</label>
                        <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" required>
                        <div id="quotaInfo" class="form-text mt-2"></div>
                    </div>

                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                    <div class="mb-3">
                        <label for="booking_time" class="form-label fw-bold">Select Booking Time</label>
                        <select class="form-control" id="booking_time" name="booking_time" required>
                            <option value="08:00:00">08:00 AM</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitOrder" disabled>Continue to Payment</button>
            </div>
        </div>
    </div>
</div>

{{-- Midtrans Script --}}
<script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('Mid-client-tsGJe31nWvY18Npe') }}"></script>
@endsection

{{-- ===================================================
     JAVASCRIPT LOGIC
====================================================== --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        const paketId = $('input[name="paket_id"]').val();
        const bookingDateInput = $('#tanggal_booking');
        const quotaInfo = $('#quotaInfo');
        const submitButton = $('#submitOrder');
        let isSubmitting = false;

        // Restrict booking date (D+1 to D+10)
        const today = new Date();
        const minDate = new Date(today.setDate(today.getDate() + 1));
        const maxDate = new Date();
        maxDate.setDate(minDate.getDate() + 9);

        const formatDate = (date) => date.toISOString().split('T')[0];
        bookingDateInput.attr('min', formatDate(minDate));
        bookingDateInput.attr('max', formatDate(maxDate));

        bookingDateInput.on('change', function () {
            const selectedDate = $(this).val();
            quotaInfo.text('Checking availability...').removeClass('text-success text-danger');
            submitButton.prop('disabled', true).text('Continue to Payment');

            if (!selectedDate) {
                quotaInfo.text('Please select a booking date.');
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
                        quotaInfo.text(`Quota available: ${response.sisa_kuota} slot(s).`).addClass('text-success');
                        submitButton.prop('disabled', false);
                    } else {
                        quotaInfo.text('Fully booked. Please choose another date.').addClass('text-danger');
                    }
                },
                error: function () {
                    quotaInfo.text('Failed to check quota.').addClass('text-danger');
                }
            });
        });

        submitButton.on('click', function () {
            if (isSubmitting) return;

            isSubmitting = true;
            submitButton.prop('disabled', true); // No text change

            $.ajax({
                url: '{{ route("api.order.create") }}',
                type: 'POST',
                data: $('#orderForm').serialize(),
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert('An error occurred while placing your order.');
                        resetButton();
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Please try again.'));
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
