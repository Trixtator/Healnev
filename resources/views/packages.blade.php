@extends('layouts.shared')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <h1 class="text-capitalize mb-5 text-lg">Our Packages</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <!-- <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 style="color: #26355D; font-size: 3em; font-weight: bold;">Daftar Paket Layanan</h2>
            <p style="font-size: 1.2em; color: #555;">Pilih paket layanan kesehatan yang sesuai dengan kebutuhan Anda.</p>
        </div>
    </div> -->

    <div class="row">
        @forelse($pakets as $paket)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                <a href="{{ route('detail-paket', $paket->id) }}" class="paket-card w-100">
                    <div class="card-image">
                        @if($paket->gambar)
                            <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->nama_paket }}">
                        @else
                            <div class="image-placeholder">
                                <i class="icofont-image"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="mb-auto">
                            <h5 class="card-title">{{ $paket->nama_paket }}</h5>
                            <p class="card-provider">{{ $paket->rumahsakit->nama ?? '' }}</p>
                        </div>
                        <div class="card-price">
                            Rp {{ number_format($paket->harga, 0, ',', '.') }}
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Saat ini belum ada paket layanan yang tersedia.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $pakets->onEachSide(1)->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

<style>
    .paket-card {
        display: block;
        background-color: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 15px;
        overflow: hidden;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .paket-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
    }

    .paket-card .card-image {
        position: relative;
    }

    .paket-card .card-image img {
        width: 100%;
        height: 190px;
        object-fit: cover;
    }

    .image-placeholder {
        width: 100%;
        height: 190px;
        background-color: #e9ecef;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #adb5bd;
    }

    .image-placeholder .icofont-image {
        font-size: 50px;
    }

    .paket-card .card-body {
        padding: 20px 25px;
    }

    .paket-card .card-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .paket-card .card-provider {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .paket-card .card-price {
        font-size: 1.75rem;
        font-weight: 700;
        color: #d9534f;
    }

    /* Custom pagination */
    .custom-pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin-top: 30px;
        gap: 8px;
    }

    .custom-pagination li {
        display: inline-block;
    }

    .custom-pagination a,
    .custom-pagination span {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        color: #223a66;
        background-color: #f2f2f2;
        font-weight: 600;
        font-size: 14px;
        border: 1px solid #dcdcdc;
        transition: all 0.2s ease;
    }

    .custom-pagination a:hover {
        background-color: #e12454;
        color: #fff;
        border-color: #e12454;
    }

    .custom-pagination .active span {
        background-color: #223a66;
        color: #fff;
        border-color: #223a66;
    }

    .custom-pagination .disabled span {
        background-color: #e9ecef;
        color: #adb5bd;
        cursor: not-allowed;
    }
</style>

@endsection
