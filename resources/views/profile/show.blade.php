@extends('layouts.shared')

@section('content')
<style>
    .dashboard-banner {
        background: url('{{ asset("assets/images/apa.jpg") }}') no-repeat center;
        background-size: cover;
        height: 300px;
        color: black;
        position: relative;
        padding: 5rem;
    }

    .dashboard-banner h1 {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 0;
    }

    .dashboard-banner .user-info {
        font-size: 1.2rem;
        font-weight: italic;
        margin-top: -0.5rem;
    }

    .settings-container {
        position: absolute;
        bottom: 1.5rem;
        right: 2rem;
    }

    .settings-btn {
        background: transparent;
        border: 1px solid black;
        border-radius: 20px;
        padding: 0.4rem 1rem;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .settings-btn:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .card-custom {
        position: relative;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        height: 100%;
    }

    .card-custom:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .ribbon {
        position: absolute;
        top: 0;
        right: 0;
        width: 90px;
        height: 90px;
        overflow: hidden;
    }

    .ribbon span {
        position: absolute;
        display: block;
        width: 140px;
        padding: 5px 0;
        background: #28a745;
        color: white;
        text-align: center;
        font-weight: bold;
        transform: rotate(45deg);
        top: 20px;
        right: -40px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .ribbon-unpaid span {
        background: #dc3545;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.2rem;
    }

    .card-body .info-item {
        margin-bottom: 0.4rem;
        color: #555;
    }

    .card-body .info-item span {
        font-weight: bold;
    }

    .text-muted.small {
        font-size: 0.875rem;
    }
</style>

<div class="dashboard-banner">
    <div>
        <h1>Welcome!</h1>
        <div class="user-info">{{ $user->name }}</div>
    </div>
    <div class="settings-container">
        <a href="{{ route('profile.edit') }}" class="settings-btn">
            <i class="bi bi-gear"></i> Settings
        </a>
    </div>
</div>

<div class="container py-4">
    <h3 class="mb-4">Riwayat Pemesanan</h3>
    <div class="row g-3">
        @forelse ($orders as $order)
            <div class="col-md-4 d-flex">
                <div class="card card-custom w-100">
                    <div class="ribbon {{ $order->payment_status !== 'paid' ? 'ribbon-unpaid' : '' }}">
                        <span>{{ strtoupper($order->payment_status) }}</span>
                    </div>

                    <div class="card-body">
                        <div class="card-title">{{ $order->order_code }}</div>
                        <div style="border-bottom: 1.5px solid #000; margin-bottom: 1rem;"></div>
                        <div class="fw-semibold text-dark mb-2" style="font-size: 1.3rem;">{{ $order->paket->nama_paket }}</div>
                        <div class="info-item">📅 <span>{{ \Carbon\Carbon::parse($order->booking_date)->format('d F Y') }}</span></div>
                        <div class="info-item">🏥 <span>{{ $order->paket->rumahSakit->nama }}</span></div>
                        <div class="info-item">💰 <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>

                        <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-outline-primary btn-sm mt-3 w-100">Lihat Invoice</a>

                        <!-- @if ($order->payment_status !== 'paid')
                            <a href="{{ route('invoice.pay', $order->id) }}" class="btn btn-success btn-sm mt-2 w-100">Bayar Sekarang</a>
                        @endif -->
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/images/empty-history.png') }}" alt="No History" style="max-width: 200px; opacity: 0.6;">
                <h5 class="mt-4 text-muted">Belum ada histori pemesanan</h5>
                <p class="text-secondary">Ayo lakukan pemesanan untuk melihat riwayat Anda di sini.</p>
                <!-- <a href="{{ route('paket.index') }}" class="btn btn-primary mt-3">Pesan Paket Sekarang</a> -->
            </div>
        @endforelse
    </div>
</div>
@endsection
