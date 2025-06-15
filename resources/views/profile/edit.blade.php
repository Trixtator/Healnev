{{-- File: resources/views/profile/edit.blade.php --}}
@extends('layouts.shared') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
{{-- Tambahkan SweetAlert2 (jika belum ada di layout utama) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">

<style>
    /* ... CSS Anda yang sudah ada dari respons sebelumnya ... */
    /* Pastikan semua style relevan dari respons sebelumnya ada di sini */
    .profile-edit-container { max-width: 900px; margin: 2rem auto; padding: 2rem; background-color: #fff; font-family: Arial, sans-serif; border-radius: 8px; }
    .profile-edit-header h1 { font-size: 1.8rem; font-weight: bold; margin-bottom: 1.5rem; color: #333; text-align: left; }
    .profile-photo-section { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #eee; }
    .profile-photo-preview-container { position: relative; }
    .profile-photo-preview { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #e9ecef; background-color: #ccc; }
    .profile-photo-edit-icon { position: absolute; bottom: 0px; right: 0px; background-color: #6c757d; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; }
    .profile-photo-edit-icon input[type="file"] { display: none; }
    .profile-photo-info h2 { margin: 0 0 0.25rem 0; font-size: 1.2rem; font-weight: 600; }
    .profile-photo-info p { margin: 0; font-size: 0.85rem; color: #666; }
    .section-title { font-size: 1.3rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 1.5rem; color: #333; }
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem 2rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.85rem; color: #555; }
    .form-group input[type="text"], .form-group input[type="email"], .form-group input[type="password"], .form-group input[type="date"], .form-group select, .form-group textarea, .form-group .form-control-plaintext { width: 100%; padding: 0.75rem; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box; background-color: #f8f9fa; font-size: 0.9rem; color: #495057; }
    .form-group textarea { min-height: 100px; resize: vertical; }
    .form-control-plaintext { background-color: #f8f9fa; border: 1px solid #ced4da; padding: 0.75rem; border-radius: 6px; margin-bottom: 0.5rem; color: #495057; width: 100%; box-sizing: border-box;}
    .btn-change-action {
        color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 20px; cursor: pointer; font-size: 0.85rem;
        font-weight: 500; display: inline-block; text-align: center; margin-top: 0.25rem; background-color: #6c757d;
    }
    .btn-change-action:hover { background-color: #5a6268; }
    .btn-submit-profile { background-color: #007bff; color: white; padding: 0.75rem 2rem; border: none; border-radius: 25px; cursor: pointer; font-size: 1rem; font-weight: 600; display: block; margin: 2.5rem auto 0 auto; min-width: 220px; }
    .btn-submit-profile:hover { background-color: #0056b3; }
    .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; } /* Style ini mungkin tidak lagi dominan jika semua diganti SweetAlert */
    .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
    .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
    .text-danger { font-size: 0.875em; color: #dc3545; display: block; margin-top:0.25rem;}
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .profile-photo-section { flex-direction: column; align-items: flex-start; } }

    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
    .modal-content { background-color: #fefefe; margin: 10% auto; padding: 25px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; position: relative; }
    .modal-header { padding-bottom: 10px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
    .modal-header h2 { margin: 0; font-size: 1.5rem; }
    .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; position: absolute; top: 10px; right: 20px; }
    .close-btn:hover, .close-btn:focus { color: black; text-decoration: none; cursor: pointer; }
    .btn-modal-save { background-color: #007bff; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; }
    .btn-modal-save:hover { background-color: #0056b3; }

    #emailInput.editing { margin-bottom: 0.75rem; }
    #emailEditState .btn-change-action { margin-top: 0; border-radius: 8px; }
    .btn-save-email { background-color: #6D5F50; color: white; border: 1px solid transparent; }
    .btn-save-email:hover { background-color: #53473A; }
    .btn-cancel-email { background-color: #FFFFFF; color: #333333; border: 1px solid #ADADAD; }
    .btn-cancel-email:hover { background-color: #f0f0f0; }
    .js-ajax-error-msg { font-size: 0.875em; color: #dc3545; display: block; margin-top: 0.25rem; }
</style>

<div class="profile-edit-container">
    <div class="profile-edit-header">
        <h1>Edit Profile</h1>
    </div>

    {{-- BLOK INI SEKARANG DIKOSONGKAN KARENA PESAN GLOBAL AKAN DITANGANI SWEETALERT VIA JAVASCRIPT --}}
    <div id="global-message-container">
        {{-- @if (session('success') && !request()->ajax())
            <div class="alert alert-success global-success-message">{{ session('success') }}</div>
        @endif
        @if (session('error') && !request()->ajax())
            <div class="alert alert-danger global-error-message">{{ session('error') }}</div>
        @endif
        @if ($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('updateEmail') && !request()->ajax())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="mainProfileForm">
        @csrf
        @method('PUT')

        <div class="profile-photo-section">
            <div class="profile-photo-preview-container">
                {{-- ... di dalam <div class="profile-photo-section"> ... --}}
                <img id="photoPreview"
                    src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://placehold.co/100x100/EFEFEF/AAAAAA&text=Foto' }}"
                    alt="Profile Photo" class="profile-photo-preview">
                {{-- ... --}}
                <label for="profile_photo_input_file" class="profile-photo-edit-icon" title="Ganti Foto Profil">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/></svg>
                    <input type="file" id="profile_photo_input_file" name="profile_photo" onchange="previewImage(event)" accept="image/*">
                </label>
            </div>
            <div class="profile-photo-info">
                <h2>{{ $user->name ?? (($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) }}</h2>
                <p id="displayedEmailTextInfo">{{ $user->email ?? '' }}</p>
            </div>
        </div>
        @error('profile_photo') <div class="text-danger" style="margin-top: -1.5rem; margin-bottom: 1rem;">{{ $message }}</div> @enderror

        <h2 class="section-title">Account Information</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Password</label>
                <div class="form-control-plaintext">************</div>
                <button type="button" class="btn-change-action" id="changePasswordBtn">Change Password</button>
            </div>
            <div class="form-group">
                <label for="email_display_text">Email Address</label>
                <div id="emailDisplayState">
                    <div id="emailDisplayText" class="form-control-plaintext">{{ $user->email }}</div>
                    <button type="button" class="btn-change-action" id="changeEmailBtn">Change Email</button>
                </div>
                <div id="emailEditState" style="display:none;">
                    <input type="email" id="emailInput" name="email_for_edit" value="{{ $user->email }}" class="editing" placeholder="Type your email">
                    <button type="button" class="btn-change-action btn-save-email" id="saveEmailBtn" style="margin-right: 0.5rem;">Save Email</button>
                    <button type="button" class="btn-change-action btn-cancel-email" id="cancelEmailBtn">Cancel</button>
                </div>
                <div id="email-update-message" style="margin-top: 5px;">
                    {{-- Pesan error Blade untuk email (jika ada, misal dari redirect) --}}
                    @if (session('status_updateEmail_error'))
                        <div class="alert alert-danger">{{ session('status_updateEmail_error') }}</div>
                    @endif
                    @if ($errors->updateEmail->any())
                        <div class="text-danger">
                            @foreach ($errors->updateEmail->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <h2 class="section-title">Personal Information</h2>
        <div class="form-grid">
             <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="passport_name">Passport Nama</label>
                <input type="text" id="passport_name" name="passport_name" value="{{ old('passport_name', $user->passport_name ?? '') }}">
                @error('passport_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="birth_date">Tanggal Lahir</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date ? ($user->birth_date instanceof \Carbon\Carbon ? $user->birth_date->format('Y-m-d') : $user->birth_date) : '') }}">
                @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                @error('address') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <button type="submit" class="btn-submit-profile">Simpan Perubahan Data Pribadi</button>
    </form>
</div>

<div id="changePasswordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ganti Password</h2>
            <span class="close-btn" id="closePasswordModalBtn">&times;</span>
        </div>
        <div id="password-update-message" style="margin-bottom: 15px;">
            {{-- Pesan error Blade untuk password (jika ada, misal dari redirect) --}}
            @if (session('status_updatePassword_error'))
                <div class="alert alert-danger">{{ session('status_updatePassword_error') }}</div>
            @endif
            @if ($errors->updatePassword->any() && !$errors->updatePassword->has('current_password') && !$errors->updatePassword->has('new_password'))
                 <div class="alert alert-danger">
                    @foreach ($errors->updatePassword->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
        </div>
        <form id="changePasswordForm" method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="modal_current_password">Password Saat Ini</label>
                <input type="password" id="modal_current_password" name="current_password" required>
                @error('current_password', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="modal_new_password">Password Baru</label>
                <input type="password" id="modal_new_password" name="new_password" required>
                @error('new_password', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="modal_new_password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="modal_new_password_confirmation" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn-modal-save">Simpan Password</button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('photoPreview');
            output.src = reader.result;
        };
        if(event.target.files[0]){
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const passwordModal = document.getElementById('changePasswordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const closePasswordModalBtn = document.getElementById('closePasswordModalBtn');
        const changePasswordForm = document.getElementById('changePasswordForm');
        const mainFormCSRF = document.querySelector('#mainProfileForm input[name="_token"]');

        // --- Password Modal ---
        if (changePasswordBtn && passwordModal && changePasswordForm) {
            changePasswordBtn.onclick = function() {
                passwordModal.style.display = "block";
                changePasswordForm.reset();
                changePasswordForm.querySelectorAll('.js-ajax-error-msg').forEach(el => el.remove());
            };
            if(closePasswordModalBtn) {
                closePasswordModalBtn.onclick = function() { passwordModal.style.display = "none"; };
            }
            window.addEventListener('click', function(event) {
                if (event.target == passwordModal) { passwordModal.style.display = "none"; }
            });

            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                this.querySelectorAll('.js-ajax-error-msg').forEach(el => el.remove());
                Swal.fire({
                    title: 'Menyimpan Password...', text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false, showConfirmButton: false, willOpen: () => { Swal.showLoading(); }
                });
                const formData = new FormData(this);
                const csrfToken = this.querySelector('input[name="_token"]').value;
                fetch(this.action, {
                    method: 'POST', body: formData,
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(response => response.json().then(data => ({ok: response.ok, status: response.status, data})))
                .then(result => {
                    Swal.close();
                    const data = result.data;
                    if (result.ok && data.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Password berhasil diperbarui!', timer: 2000, showConfirmButton: false });
                        this.reset();
                        setTimeout(() => { passwordModal.style.display = "none"; }, 2000);
                    } else {
                        let errorTitle = 'Oops... Terjadi Kesalahan!';
                        let errorMessagesHtml = data.message || `Gagal memperbarui password (HTTP Status: ${result.status}).`;
                        if (data.errors) {
                            errorTitle = 'Validasi Gagal!';
                            errorMessagesHtml = '<ul style="text-align:left; padding-left:20px; list-style-type:disc;">';
                            for (const field in data.errors) {
                                errorMessagesHtml += `<li>${data.errors[field].join(', ')}</li>`;
                            }
                            errorMessagesHtml += '</ul>';
                        }
                        Swal.fire({ icon: 'error', title: errorTitle, html: errorMessagesHtml, confirmButtonText: 'Mengerti' });
                    }
                })
                .catch(error => {
                    Swal.close(); console.error('Password Update Fetch Error:', error);
                    Swal.fire({ icon: 'error', title: 'Kesalahan Jaringan', text: 'Tidak bisa terhubung ke server.', confirmButtonText: 'Mengerti'});
                });
            });
        }

        // --- Inline Email Edit ---
        const emailDisplayState = document.getElementById('emailDisplayState');
        const emailEditState = document.getElementById('emailEditState');
        const emailDisplayText = document.getElementById('emailDisplayText');
        const emailInput = document.getElementById('emailInput');
        const changeEmailBtnEl = document.getElementById('changeEmailBtn');
        const saveEmailBtnEl = document.getElementById('saveEmailBtn');
        const cancelEmailBtnEl = document.getElementById('cancelEmailBtn');
        const displayedEmailTextInfo = document.getElementById('displayedEmailTextInfo');

        if (changeEmailBtnEl && emailDisplayState && emailEditState && emailInput && emailDisplayText) {
            changeEmailBtnEl.onclick = function() {
                emailDisplayState.style.display = 'none';
                emailEditState.style.display = 'block';
                emailInput.value = emailDisplayText.textContent.trim();
                emailInput.focus();
            }
        }

        if (cancelEmailBtnEl && emailDisplayState && emailEditState) {
            cancelEmailBtnEl.onclick = function() {
                emailEditState.style.display = 'none';
                emailDisplayState.style.display = 'block';
            }
        }

        if (saveEmailBtnEl && emailDisplayState && emailEditState && emailInput && emailDisplayText && displayedEmailTextInfo && mainFormCSRF) {
            saveEmailBtnEl.onclick = function() {
                const newEmail = emailInput.value;
                Swal.fire({
                    title: 'Menyimpan Email...', text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false, showConfirmButton: false, willOpen: () => { Swal.showLoading(); }
                });
                fetch('{{ route("profile.email.update") }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json', 'X-CSRF-TOKEN': mainFormCSRF.value,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email: newEmail })
                })
                .then(response => response.json().then(data => ({ok: response.ok, status: response.status, data})))
                .then(result => {
                    Swal.close();
                    const data = result.data;
                    if (result.ok && data.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Email berhasil diperbarui!', timer: 2000, showConfirmButton: false });
                        emailDisplayText.textContent = newEmail;
                        if(displayedEmailTextInfo) displayedEmailTextInfo.textContent = newEmail;
                        emailEditState.style.display = 'none';
                        emailDisplayState.style.display = 'block';
                    } else {
                        let errorTitle = 'Oops... Terjadi Kesalahan!';
                        let errorMessagesHtml = data.message || 'Gagal memperbarui email.';
                        if (data.errors) {
                            errorTitle = 'Validasi Gagal!';
                            errorMessagesHtml = '<ul style="text-align:left; padding-left:20px; list-style-type:disc;">';
                            // Perbaikan typo: errorsTextHtml -> errorMessagesHtml
                            for (const field in data.errors) { errorMessagesHtml += `<li>${data.errors[field].join(', ')}</li>`; }
                            errorMessagesHtml += '</ul>';
                        }
                        Swal.fire({ icon: 'error', title: errorTitle, html: errorMessagesHtml, confirmButtonText: 'Mengerti'});
                    }
                })
                .catch(error => {
                    Swal.close(); console.error('Email Update Fetch Error:', error);
                    Swal.fire({ icon: 'error', title: 'Kesalahan Jaringan', text: 'Tidak bisa terhubung ke server.', confirmButtonText: 'Mengerti'});
                });
            }
        }

        // Buka modal password jika ada error validasi password dari server (setelah redirect)
        @if ($errors->updatePassword->any() || session('status_updatePassword_error'))
            if (passwordModal) {
                passwordModal.style.display = "block";
            }
        @endif

        // Menampilkan SweetAlert untuk pesan session global dan error validasi umum
        @if (session('success') && !request()->ajax())
            Swal.fire({icon: 'success', title: 'Sukses!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        @endif
        @if (session('error') && !request()->ajax())
            Swal.fire({icon: 'error', title: 'Error!', text: "{{ session('error') }}", confirmButtonText: 'Mengerti'});
        @endif
        @if ($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('updateEmail') && !request()->ajax())
            let errorsHtml = '<strong>Whoops! Ada beberapa masalah dengan input Anda:</strong><ul style="text-align:left; padding-left:20px; list-style-type:disc; margin-top:10px;">';
            @foreach ($errors->all() as $error)
                errorsHtml += `<li>{{ Illuminate\Support\Str::replace("'", "\\'", $error) }}</li>`; // Escape single quotes
            @endforeach
            errorsHtml += '</ul>';
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: errorsHtml,
                confirmButtonText: 'Mengerti'
            });
        @endif
    });
</script>

@endsection