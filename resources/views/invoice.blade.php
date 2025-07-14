@extends('layouts.shared')

@section('content')
<section class="section pt-5">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Invoice: {{ $order->order_code }}</h4>
                        <small>Status:
                            @if($order->payment_status === 'paid')
                            <span class="badge bg-success">PAID</span>
                            @elseif($order->payment_status === 'pending')
                            <span class="badge bg-warning">PENDING PAYMENT</span>
                            @else
                            <span class="badge bg-danger">UNPAID</span>
                            @endif
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Order Details</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 160px;">Package Name</td>
                                        <td>: {{ $order->paket->nama_paket }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hospital</td>
                                        <td>: {{ $order->paket->rumahSakit->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Booking Date</td>
                                        <td>: {{ \Carbon\Carbon::parse($order->booking_date)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Booking Time</td>
                                        <td>: {{ $order->booking_time ?? '08:00 WIB' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td class="fw-bold text-success">: {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @if($order->paid_at)
                                    <tr>
                                        <td>Paid At</td>
                                        <td>: {{ $order->paid_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    @endif
                                    @if($order->payment_method)
                                    <tr>
                                        <td>Payment Method</td>
                                        <td>: {{ ucfirst($order->payment_method) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/' . $order->paket->gambar) }}"
                                    alt="Package Image"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 230px; object-fit: cover; border: 1px solid #ddd;">
                            </div>
                        </div>

                        <hr>

                        @if ($order->payment_status !== 'paid')
                        <div class="text-center mb-3">
                            <p class="text-muted">Click the button below to proceed with the payment.</p>
                        </div>
                        <div class="d-grid mt-2">
                            <button id="pay-button" class="btn btn-success btn-lg">Pay Now</button>
                        </div>
                        @else
                        <div class="alert alert-success mt-4 text-center">
                            ✅ This order has been paid
                            @if($order->payment_method)
                            <br><small>Method: {{ ucfirst($order->payment_method) }}</small>
                            @endif
                        </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const payButton = document.getElementById('pay-button');
        let isPaying = false;

        if (payButton) {
            payButton.addEventListener('click', function() {
                if (isPaying) return;
                isPaying = true;
                payButton.disabled = true;
                payButton.innerHTML = 'Processing...';

                Swal.fire({
                    title: 'Requesting Payment Session...',
                    text: 'Please wait a moment.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('{{ route("invoice.pay", $order->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                console.log('Payment success:', result);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful!',
                                    text: 'Thank you for your payment.',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            onPending: function(result) {
                                console.log('Payment pending:', result);
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Payment Pending',
                                    text: 'Please complete your payment.',
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            onError: function(result) {
                                console.log('Payment error:', result);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Payment Failed',
                                    text: 'An error occurred while processing the payment.',
                                });
                                resetButton();
                            },
                            onClose: function() {
                                console.log('Payment popup closed');
                                resetButton();
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message || 'Something went wrong. Please try again.',
                        });
                        resetButton();
                    });

                function resetButton() {
                    isPaying = false;
                    payButton.disabled = false;
                    payButton.innerHTML = 'Pay Now';
                }
            });
        }
    });
</script>
@endsection
