@extends('layouts.shared')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <h1 class="text-capitalize mb-5 text-lg">Detail Rumah Sakit</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            @if($rumahsakit->gambar)
                <img src="{{ asset('storage/' . $rumahsakit->gambar) }}" alt="{{ $rumahsakit->nama }}" class="img-fluid rounded" style="height: 300px; width: 100%; object-fit: cover;">
            @else
                <div class="image-placeholder text-center py-5 bg-light rounded">
                    <i class="icofont-hospital" style="font-size: 3em;"></i>
                    <p class="mt-2">Tidak ada gambar</p>
                </div>
            @endif
        </div>

        <div class="col-lg-6">
            <h2>{{ $rumahsakit->nama }}</h2>
            <!-- <p>
                <i class="icofont-location-pin"></i>
                {{ $rumahsakit->alamat }}
            </p>
            @if($rumahsakit->telepon)
                <p >
                    <i class="icofont-phone"></i>
                    {{ $rumahsakit->telepon }}
                </p>
            @endif -->

            @if($rumahsakit->deskripsi)
                <div class="mt-3">
                    <!-- <strong>Deskripsi:</strong> -->
                    <div>{!! $rumahsakit->deskripsi !!}</div>
                </div>
            @endif

            <!-- @if($rumahsakit->link_gmaps)
                <div class="mt-4">
                    <a href="{{ $rumahsakit->link_gmaps }}" target="_blank" class="btn btn-outline-primary">
                        Lihat di Google Maps
                    </a>
                </div>
            @endif -->
        </div>
    </div>

    @if($rumahsakit->link_gmaps)
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-container bg-white p-3 rounded shadow-sm">
                    <iframe class="w-100 rounded" height="400" frameborder="0"
                        src="{{ $rumahsakit->link_gmaps }}"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
