@extends('layouts.shared')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <h1 class="text-capitalize mb-5 text-lg">Our Hospital</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <!-- <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 style="color: #26355D; font-size: 3em; font-weight: bold;">Daftar Rumah Sakit</h2>
            <p style="font-size: 1.2em; color: #555;">Lihat rumah sakit rekanan kami untuk layanan terbaik.</p>
        </div>
    </div> -->

    <div class="row">
        @forelse($rumahsakit as $rs)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
            <a href="{{ route('detail-hospital', $rs->id) }}" class="hospital-card w-100">
                <div class="card-image">
                    @if($rs->gambar)
                    <img src="{{ asset('storage/' . $rs->gambar) }}" alt="{{ $rs->nama }}">
                    @else
                    <div class="image-placeholder">
                        <i class="icofont-hospital" style="font-size: 50px;"></i>
                    </div>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $rs->nama }}</h5>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                There is no hospital data to display at this time.
            </div>
        </div>
        @endforelse
    </div>

    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $rumahsakit->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

<style>
    .hospital-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        display: block;
        padding: 0;
    }

    .hospital-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
    }

    .card-image {
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        width: 100%;
        height: 180px;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #999;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin: 0;
        text-align: left;
    }

    .custom-pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        gap: 8px;
        padding-left: 0;
    }

    .custom-pagination li {
        display: inline-block;
    }

    .custom-pagination a,
    .custom-pagination span {
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        color: #223a66;
        background-color: #f2f2f2;
        font-weight: 600;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .custom-pagination .active span {
        background-color: #223a66;
        color: #fff;
        border-color: #223a66;
    }

    .custom-pagination a:hover {
        background-color: #e12454;
        color: #fff;
        border-color: #e12454;
    }

    .custom-pagination .disabled span {
        background-color: #e9ecef;
        color: #adb5bd;
    }
</style>

@endsection