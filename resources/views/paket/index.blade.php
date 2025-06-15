@extends('layouts.loglayout')

@section('title', 'Data Paket Rumah Sakit')

@section('content')
@include('layouts.sidebar')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        margin-right: -50px;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .table-container {
        margin-left: 140px;
        margin-top: 30px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .table thead {
        background-color: #f1f1f1;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .img-thumbnail {
        max-width: 80px;
        border-radius: 8px;
    }
    .pagination {
        justify-content: center;
    }

    .modal-lg {
  max-width: 1000px; /* Lebar modal besar */
}

/* Container CKEditor */
.ck-editor__editable_inline {
  min-height: 180px; /* tinggi area editor yang besar */
  max-height: 200px; /* maksimal tinggi */
  overflow-y: auto;  /* scroll hanya di editor kalau isi panjang */
}

</style>

<div class="table-container">
    <h2 class="mb-4">Data Paket Rumah Sakit</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Paket</button>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="text-center">
                <tr>
                    <th>Nama Paket</th>
                    <th>Rumah Sakit</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pakets as $paket)
                <tr data-bs-toggle="modal" data-bs-target="#actionModal{{ $paket->id }}">
                    <td>{{ $paket->nama_paket }}</td>
                    <td>{{ $paket->rumahsakit->nama }}</td>
                    <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                    <td>{{ Str::limit(strip_tags($paket->deskripsi), 100) }}</td>
                    <td class="text-center">
                        @if ($paket->gambar)
                            <img src="{{ asset('storage/' . $paket->gambar) }}" class="img-thumbnail">
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $pakets->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content p-3" method="POST" action="{{ route('paket.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 mb-3">
                    <label for="nama_paket" class="form-label">Nama Paket</label>
                    <input type="text" class="form-control" name="nama_paket" value="{{ old('nama_paket') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="rumahsakit_id" class="form-label">Rumah Sakit</label>
                    <select name="rumahsakit_id" class="form-control" required>
                        <option value="">-- Pilih Rumah Sakit --</option>
                        @foreach ($rumahsakit as $rs)
                            <option value="{{ $rs->id }}" {{ old('rumahsakit_id') == $rs->id ? 'selected' : '' }}>{{ $rs->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" name="harga" value="{{ old('harga') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" name="gambar" accept="image/*">
                </div>
                <div class="col-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi">{{ old('deskripsi') }}</textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Tambah</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Action & Edit -->
@foreach ($pakets as $paket)
<!-- Action Modal -->
<div class="modal fade" id="actionModal{{ $paket->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Aksi untuk "{{ $paket->nama_paket }}"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $paket->id }}" data-bs-dismiss="modal">Update</button>
                <form action="{{ route('paket.destroy', $paket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $paket->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content p-3" method="POST" action="{{ route('paket.update', $paket->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $paket->id }}">
            <div class="modal-header">
                <h5 class="modal-title">Edit Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Paket</label>
                    <input type="text" class="form-control" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rumah Sakit</label>
                    <select name="rumahsakit_id" class="form-control" required>
                        @foreach ($rumahsakit as $rs)
                            <option value="{{ $rs->id }}" {{ $paket->rumahsakit_id == $rs->id ? 'selected' : '' }}>{{ $rs->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="harga" value="{{ old('harga', $paket->harga) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gambar (Opsional)</label>
                    <input type="file" class="form-control" name="gambar" accept="image/*">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi{{ $paket->id }}">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Simpan Perubahan</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Tutup</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    // SweetAlert untuk sukses
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // SweetAlert untuk error
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    // Inisialisasi semua textarea dengan ID yang diawali "deskripsi"
    document.querySelectorAll('textarea[id^="deskripsi"]').forEach((textarea) => {
        ClassicEditor.create(textarea).catch(error => {
            console.error('CKEditor initialization error:', error);
        });
    });

    // Tampilkan modal Tambah jika validasi gagal pada form Tambah
    @if ($errors->any() && (!old('_method') || old('_method') === 'POST'))
        new bootstrap.Modal(document.getElementById('tambahModal')).show();
    @endif

    // Tampilkan modal Edit jika validasi gagal pada form Edit
    @if ($errors->any() && old('_method') === 'PUT')
        const id = '{{ old("id") }}';
        new bootstrap.Modal(document.getElementById('editModal' + id)).show();
    @endif
</script>

@endsection
