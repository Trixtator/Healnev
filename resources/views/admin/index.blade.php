@extends('layouts.loglayout')

@section('title', 'Dashboard')

@section('content')
@include('layouts.sidebar')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .admin-container {
        margin-left: 140px;
        margin-top: 20px;
        padding: 20px;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .admin-header h1 {
        margin: 0;
        color: #333;
        font-size: 24px;
        font-weight: bold;
    }

    .search-bar {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .search-bar input {
        width: 80%;
        padding: 10px;
        border-radius: 5px 0 0 5px;
        border: 1px solid #ddd;
        font-size: 16px;
        outline: none;
    }

    .search-bar button {
        width: 20%;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-bar button:hover {
        background-color: #0056b3;
    }

    .table-container {
        overflow-x: auto;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border: 1px solid #ddd;
        word-wrap: break-word;
        white-space: normal;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
        transition: background-color 0.3s ease;
    }

    /* Hide default pagination text */
    nav+div {
        display: none !important;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>Registered Users</h1>
    </div>

    <div class="search-bar">
        <form method="GET" action="{{ route('admin.index') }}" style="display: flex; width: 100%;">
            <input type="text" name="search" placeholder="Search by name" value="{{ request('search') }}">
            <button type="submit">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>

    <div class="table-container">
        <h2>Data User Terdaftar</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Passport</th>
                    <th>Reservation Date</th>
                    <th>Package</th>
                    <th>Hospital</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ $order->user->email ?? '-' }}</td>
                    <td>{{ $order->user->passport_name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->booking_date)->format('d M Y') }}</td>
                    <td>{{ $order->paket->nama_paket ?? '-' }}</td>
                    <td>{{ $order->paket->rumahsakit->nama ?? '-' }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} HealthNav. All rights reserved.</p>
    </div>
</div>
@endsection