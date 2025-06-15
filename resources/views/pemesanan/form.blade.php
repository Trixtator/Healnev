@extends('layouts.shared')

@section('content')
<div class="container mt-5">
  <h3>Pesan: {{ $paket->nama_paket }}</h3>

  <form method="POST" action="{{ route('pemesanan.proses') }}">
    @csrf
    <input type="hidden" name="paket_id" value="{{ $paket->id }}">

    <div class="mb-3">
      <label for="tanggal" class="form-label">Pilih Tanggal (H+1 sampai H+10)</label>
      <input type="date" name="tanggal" id="tanggal" class="form-control" required
        min="{{ now()->addDay()->format('Y-m-d') }}"
        max="{{ now()->addDays(10)->format('Y-m-d') }}">
    </div>

    <button class="btn btn-success">Lanjut ke Pembayaran</button>
  </form>
</div>
@endsection
