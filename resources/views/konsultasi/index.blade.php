@extends('layouts.loglayout')

@section('title', 'Jadwal Konsultasi')

@section('content')
<div class="table-container">
    <h2>Tambah Jadwal Konsultasi</h2>
    <form action="{{ route('konsultasi.store') }}" method="POST">
        @csrf
        <input type="text" name="layanan" placeholder="Layanan" required>
        <input type="date" name="tanggal" required>
        <input type="time" name="jam" required>
        <input type="text" name="dokter" placeholder="Nama Dokter" required>
        <button type="submit">Tambah Jadwal</button>
    </form>
</div>
@endsection