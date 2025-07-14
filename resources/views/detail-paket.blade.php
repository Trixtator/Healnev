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
                                        <td class="fw-bold text-success">: Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
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
        let paymentInProgress = false;

        if (payButton) {
            // Prevent multiple event listeners
            payButton.removeEventListener('click', handlePayment);
            payButton.addEventListener('click', handlePayment);
        }

        function handlePayment(event) {
            event.preventDefault();
            event.stopPropagation();

            // Prevent double click
            if (isPaying || paymentInProgress) {
                console.log('Payment already in progress, ignoring click');
                return false;
            }

            // Check if order is already paid
            if ('{{ $order->payment_status }}' === 'paid') {
                Swal.fire({
                    icon: 'info',
                    title: 'Already Paid',
                    text: 'This order has already been paid.',
                });
                return false;
            }

            isPaying = true;
            paymentInProgress = true;
            payButton.disabled = true;
            payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';

            Swal.fire({
                title: 'Requesting Payment Session...',
                text: 'Please wait a moment.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route("invoice.pay", $order->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    // Add timeout
                    signal: AbortSignal.timeout(30000)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close();

                    if (data.error) {
                        throw new Error(data.error);
                    }

                    if (!data.snap_token) {
                        throw new Error('No payment token received');
                    }

                    // Initialize Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            paymentInProgress = false;
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Payment Successful!',
                                text: 'Thank you for your payment.',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Force reload to update payment status
                                window.location.reload();
                            });
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            paymentInProgress = false;
                            
                            Swal.fire({
                                icon: 'info',
                                title: 'Payment Pending',
                                text: 'Please complete your payment. We will check the status automatically.',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Start checking payment status
                                startPaymentStatusCheck();
                            });
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            paymentInProgress = false;
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment Failed',
                                text: 'An error occurred while processing the payment. Please try again.',
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            });
                            resetButton();
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                            paymentInProgress = false;
                            resetButton();
                        }
                    });
                })
                .catch(error => {
                    console.error('Payment request error:', error);
                    paymentInProgress = false;
                    
                    Swal.close();
                    
                    let errorMessage = 'Something went wrong. Please try again.';
                    if (error.name === 'AbortError') {
                        errorMessage = 'Request timed out. Please try again.';
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    });
                    resetButton();
                });
        }

        function resetButton() {
            isPaying = false;
            paymentInProgress = false;
            if (payButton) {
                payButton.disabled = false;
                payButton.innerHTML = 'Pay Now';
            }
        }

        // Function to start payment status checking
        function startPaymentStatusCheck() {
            resetButton();
            checkPaymentStatus();
        }

        // Function to check payment status
        function checkPaymentStatus() {
            console.log('Checking payment status...');
            
            fetch('{{ route("invoice.status", $order->id) }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                signal: AbortSignal.timeout(10000)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Payment status check result:', data);
                
                if (data.payment_status === 'paid') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: 'Thank you for your payment.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload();
                    });
                } else if (data.payment_status === 'pending') {
                    // Continue checking if still pending
                    setTimeout(checkPaymentStatus, 5000);
                } else {
                    // Payment failed or cancelled
                    console.log('Payment not successful:', data.payment_status);
                    resetButton();
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
                // Stop checking and reset button
                resetButton();
            });
        }

        // Handle page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                // Reset payment state when page becomes visible again
                if (isPaying || paymentInProgress) {
                    setTimeout(function() {
                        resetButton();
                    }, 2000);
                }
            }
        });

        // Handle beforeunload to prevent navigation during payment
        window.addEventListener('beforeunload', function(e) {
            if (paymentInProgress) {
                e.preventDefault();
                e.returnValue = 'Payment is in progress. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
    });
</script>
@endsection