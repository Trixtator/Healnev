@extends('layouts.loglayout')

@section('title', 'Users')

@section('content')
@include('layouts.sidebar')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    .user-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .profile-photo-preview {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e9ecef;
        background-color: #ccc;
    }
    .profile-photo-previeww {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e9ecef;
        background-color: #ccc;
    }
</style>

<div class="table-container">
    <h2>Daftar User</h2>

    <div class="row mt-4">
        @foreach($users as $user)
        <div class="col-md-6">
            <div class="user-card d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://placehold.co/100x100/EFEFEF/AAAAAA&text=Foto' }}"
                         alt="Profile Photo" class="profile-photo-preview me-3">
                    <div>
                        <h5 class="mb-0">{{ $user->name }}</h5>
                        <small>{{ $user->email }}</small>
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $user->id }}">Detail</button>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">Hapus</button>
                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1" aria-labelledby="detailLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://placehold.co/100x100/EFEFEF/AAAAAA&text=Foto' }}"
                                 alt="Profile Photo" class="profile-photo-previeww">
                        </div>
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Nama:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Paspor:</strong> {{ $user->passport_name ?? '-' }}</p>
                        <p><strong>Dibuat:</strong> {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Yakin?',
            text: "Hapus user " + userName + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }

    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Oke'
        });
    });
    @endif
</script>

@endsection
