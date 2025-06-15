@extends('layouts.loglayout')

@section('title', 'Data Rumah Sakit')

@section('content')
@include('layouts.sidebar')

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
    .img-thumbnail {
        max-width: 80px;
        border-radius: 8px;
    }
    .pagination {
        justify-content: center;
    }
    .modal-lg {
      max-width: 1000px;
    }
    .ck-editor__editable_inline {
      min-height: 180px;
      max-height: 200px;
      overflow-y: auto;
    }
    .clickable-row {
        cursor: pointer;
    }
</style>

<div class="table-container">
    <h2 class="mb-4">Data Rumah Sakit</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Rumah Sakit</button>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="text-center">
                <tr>
                    <th>Nama RS</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Gmaps</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rumahsakit as $rs)
                    <tr class="clickable-row" data-id="{{ $rs->id }}">
                        <td>{{ $rs->nama }}</td>
                        <td>{{ $rs->alamat }}</td>
                        <td>{{ $rs->telepon }}</td>
                        <td class="text-center">
                            @if ($rs->link_gmaps)
                                <a href="{{ $rs->link_gmaps }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                            @endif
                        </td>
                        <td>{{ Str::limit(strip_tags($rs->deskripsi), 100) }}</td>
                        <td class="text-center">
                            @if ($rs->gambar)
                                <img src="{{ asset('storage/' . $rs->gambar) }}" class="img-thumbnail" alt="Gambar RS">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $rumahsakit->links() }}
    </div>
</div>

@foreach ($rumahsakit as $rs)
<div class="modal fade" id="actionModal{{ $rs->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Aksi untuk "{{ $rs->nama }}"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $rs->id }}" data-bs-dismiss="modal">Update</button>
                <form action="{{ route('rumahsakit.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal{{ $rs->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content p-3" method="POST" action="{{ route('rumahsakit.update', $rs->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $rs->id }}">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rumah Sakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama{{ $rs->id }}" class="form-label">Nama Rumah Sakit</label>
                        <input type="text" class="form-control" name="nama" id="nama{{ $rs->id }}" value="{{ old('nama', $rs->nama) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alamat{{ $rs->id }}" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat{{ $rs->id }}" value="{{ old('alamat', $rs->alamat) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telepon{{ $rs->id }}" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telepon" id="telepon{{ $rs->id }}" value="{{ old('telepon', $rs->telepon) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="link_gmaps{{ $rs->id }}" class="form-label">Link Google Maps</label>
                        <input type="text" class="form-control" name="link_gmaps" id="link_gmaps{{ $rs->id }}" value="{{ old('link_gmaps', $rs->link_gmaps) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gambar{{ $rs->id }}" class="form-label">Gambar (opsional)</label>
                        <input type="file" class="form-control" name="gambar" id="gambar{{ $rs->id }}" accept="image/*">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="deskripsi{{ $rs->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi{{ $rs->id }}" rows="6">{{ old('deskripsi', $rs->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Simpan Perubahan</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Tutup</button>
            </div>
        </form>
    </div>
</div>
@endforeach
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content p-3" method="POST" action="{{ route('rumahsakit.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rumah Sakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="nama" class="form-label">Nama Rumah Sakit</label><input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required></div>
                    <div class="col-md-6 mb-3"><label for="alamat" class="form-label">Alamat</label><input type="text" class="form-control" name="alamat" id="alamat" value="{{ old('alamat') }}" required></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="telepon" class="form-label">Telepon</label><input type="text" class="form-control" name="telepon" id="telepon" value="{{ old('telepon') }}"></div>
                    <div class="col-md-6 mb-3"><label for="link_gmaps" class="form-label">Link Google Maps</label><input type="text" class="form-control" name="link_gmaps" id="link_gmaps" value="{{ old('link_gmaps') }}"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="gambar" class="form-label">Gambar</label><input type="file" class="form-control" name="gambar" id="gambar" accept="image/*"></div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3"><label for="deskripsi" class="form-label">Deskripsi</label><textarea class="form-control" name="deskripsi" id="deskripsi" rows="6">{{ old('deskripsi') }}</textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Tambah</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/ckeditor5-build-classic-with-alignment@latest/build/ckeditor.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@36.0.1/build/ckeditor.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // --- LOGIKA BARU UNTUK KLIK BARIS ---
    const rows = document.querySelectorAll('.clickable-row');
    rows.forEach(row => {
        row.addEventListener('click', function (event) {
            // Cek apakah elemen yang diklik atau parent-nya adalah sebuah link <a>
            // Jika iya, jangan lakukan apa-apa (biarkan link bekerja normal)
            if (event.target.closest('a')) {
                return;
            }

            // Jika yang diklik bukan link, tampilkan modal
            const hospitalId = this.dataset.id; // Ambil ID dari atribut data-id
            const actionModal = new bootstrap.Modal(document.getElementById('actionModal' + hospitalId));
            actionModal.show();
        });
    });

    // Inisialisasi CKEditor untuk modal tambah
    const tambahDeskripsi = document.querySelector('#deskripsi');
    if (tambahDeskripsi) {
        ClassicEditor.create(tambahDeskripsi).catch(error => console.error(error));
    }

    // Inisialisasi CKEditor saat modal edit dibuka
    const editModals = document.querySelectorAll('div[id^="editModal"]');
    editModals.forEach(modal => {
        const textarea = modal.querySelector('textarea[id^="deskripsi"]');
        if (textarea) {
            modal.addEventListener('shown.bs.modal', () => {
                if (!textarea.classList.contains('ckeditor-initialized')) {
                    ClassicEditor.create(textarea)
                        .then(editor => {
                            textarea.editorInstance = editor;
                            textarea.classList.add('ckeditor-initialized');
                        })
                        .catch(error => console.error(error));
                }
            });

            modal.addEventListener('hidden.bs.modal', () => {
                if (textarea.editorInstance) {
                    textarea.editorInstance.destroy().then(() => {
                        textarea.editorInstance = null;
                        textarea.classList.remove('ckeditor-initialized');
                    }).catch(error => console.error(error));
                }
            });
        }
    });
    
    // Menampilkan modal jika ada error validasi
    @if ($errors->any())
        @if (old('_method') === 'PUT')
            // Error pada form update
            const editId = '{{ old("id") }}';
            if (editId) {
                const editModal = new bootstrap.Modal(document.getElementById('editModal' + editId));
                editModal.show();
            }
        @else
            // Error pada form tambah
            const tambahModal = new bootstrap.Modal(document.getElementById('tambahModal'));
            tambahModal.show();
        @endif
    @endif

    // Notifikasi SweetAlert
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Sukses!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 2500, showConfirmButton: false });
    @endif
});
</script>

@endsection