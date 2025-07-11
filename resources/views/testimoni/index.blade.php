@extends('layouts.loglayout')

@section('title', 'Data Testimoni')

@section('content')
@include('layouts.sidebar')

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .table-container {
        margin-left: 200px;
        margin-top: 30px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .table thead {
        background-color: #f1f1f1;
    }

    .pagination {
        justify-content: center;
    }

    tr.clickable-row {
        cursor: pointer;
    }
</style>

<div class="table-container">
    <h2 class="mb-4">Data Testimoni</h2>

    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="text-center">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($testimonis as $testimoni)
                    <tr class="clickable-row"
                        data-nama="{{ $testimoni->user->name ?? '-' }}"
                        data-email="{{ $testimoni->user->email ?? '-' }}"
                        data-rating="{{ $testimoni->rating }}"
                        data-pesan="{{ addslashes($testimoni->message) }}">
                        <td>{{ $testimoni->user->name ?? '-' }}</td>
                        <td>{{ $testimoni->user->email ?? '-' }}</td>
                        <td class="text-center">{{ $testimoni->rating }} ⭐</td>
                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($testimoni->message), 80) }}</td>
                        <td class="text-center" onclick="event.stopPropagation();">
                            <form action="{{ route('admin.testimoni.toggle', $testimoni->id) }}" method="POST">
                                @csrf
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           onchange="this.form.submit()"
                                           {{ $testimoni->is_active ? 'checked' : '' }}>
                                </div>
                            </form>
                        </td>
                        <td class="text-center" onclick="event.stopPropagation();">
                            <form id="delete-form-{{ $testimoni->id }}" action="{{ route('admin.testimoni.destroy', $testimoni->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $testimoni->id }})">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada testimoni.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $testimonis->links() }}
    </div>
</div>

<script>
    // Konfirmasi hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Testimoni?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Klik baris
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', function () {
            const nama = this.getAttribute('data-nama');
            const email = this.getAttribute('data-email');
            const rating = this.getAttribute('data-rating');
            const pesan = this.getAttribute('data-pesan');

            Swal.fire({
                title: 'Detail Testimoni',
                html: `
                    <strong>Nama:</strong> ${nama}<br>
                    <strong>Email:</strong> ${email}<br>
                    <strong>Rating:</strong> ${rating} ⭐<br><br>
                    <strong>Pesan:</strong><br>${pesan}
                `,
                icon: 'info',
                confirmButtonText: 'Tutup'
            });
        });
    });
</script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
