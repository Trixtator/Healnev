@extends('layouts.shared')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    :root {
        --primary-color: #007bff;
        --primary-dark: #0056b3;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --text-color: #495057;
        --text-muted: #6c757d;
        --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --border-radius: 12px;
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        min-height: 100vh;
        /* padding: 2rem 0; */
        padding-top: 100px;
    }

    .profile-edit-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .profile-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .profile-photo-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 2rem;
        background: white;
        border-bottom: 1px solid var(--border-color);
    }

    .profile-photo-container {
        position: relative;
        flex-shrink: 0;
    }

    .profile-photo-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--border-color);
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .profile-photo-preview:hover {
        transform: scale(1.05);
        border-color: var(--primary-color);
    }

    .profile-photo-edit-icon {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .profile-photo-edit-icon:hover {
        background: var(--primary-dark);
        transform: scale(1.1);
    }

    .profile-photo-edit-icon input[type="file"] {
        display: none;
    }

    .profile-info h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: var(--text-color);
    }

    .profile-info p {
        margin: 0;
        color: var(--text-muted);
        font-size: 1rem;
    }

    .section {
        padding: 2rem;
        background: white;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 1.5rem 0;
        color: var(--text-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
        color: var(--text-color);
        background: white;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .form-control-plaintext {
        background: var(--light-gray);
        border: 2px solid var(--border-color);
        padding: 0.875rem 1rem;
        border-radius: var(--border-radius);
        color: var(--text-color);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 25px;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-change {
        background: var(--text-muted);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    .btn-change:hover {
        background: var(--text-color);
        transform: translateY(-1px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-secondary {
        background: white;
        color: var(--text-color);
        border: 2px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--light-gray);
        color: black;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1rem 2.5rem;
        font-size: 1rem;
        font-weight: 600;
        display: block;
        margin: 2rem auto 0;
        margin-bottom: 50px;
        min-width: 250px;
        justify-content: center;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    }

    .email-edit-container {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .email-edit-container .form-control {
        flex: 1;
        min-width: 200px;
    }

    .text-danger {
        color: var(--danger-color);
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 20px;
        width: 90%;
        max-width: 500px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .close-btn {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .close-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-edit-container {
            padding: 0 0.5rem;
        }

        .profile-photo-section {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .email-edit-container {
            flex-direction: column;
        }

        .email-edit-container .form-control {
            min-width: auto;
        }

        .modal-content {
            margin: 10% auto;
            width: 95%;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .btn-submit {
            min-width: auto;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .profile-header {
            padding: 1.5rem;
        }

        .profile-header h1 {
            font-size: 1.5rem;
        }

        .section {
            padding: 1.5rem;
        }

        .profile-photo-preview {
            width: 100px;
            height: 100px;
        }
    }

    /* Loading States */
    .btn.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .btn.loading::after {
        content: '';
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 0.5rem;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Success/Error States */
    .form-group.success .form-control {
        border-color: var(--success-color);
    }

    .form-group.error .form-control {
        border-color: var(--danger-color);
    }

    /* Accessibility */
    .btn:focus,
    .form-control:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="profile-edit-container">
    <div class="profile-card">
        <div class="profile-header">
            <h1>Edit Profile</h1>
        </div>

        <div class="profile-photo-section">
            <div class="profile-photo-container">
                <img id="photoPreview"
                    src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&size=120&background=007bff&color=ffffff' }}"
                    alt="Profile Photo" class="profile-photo-preview">
                <label for="profile_photo_input_file" class="profile-photo-edit-icon" title="Change Profile Photo">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                    </svg>
                    <input type="file" id="profile_photo_input_file" name="profile_photo" onchange="previewImage(event)" accept="image/*">
                </label>
            </div>
            <div class="profile-info">
                <h2>{{ $user->name ?? 'User Name' }}</h2>
                <p id="displayedEmailTextInfo">{{ $user->email ?? 'user@example.com' }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="mainProfileForm">
            @csrf
            @method('PUT')

            <div class="section">
                <h2 class="section-title">🔐 Account Security</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="form-control-plaintext">••••••••••••</div>
                        <button type="button" class="btn btn-change" id="changePasswordBtn">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                            Change Password
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <div id="emailDisplayState">
                            <div id="emailDisplayText" class="form-control-plaintext">{{ $user->email }}</div>
                            <button type="button" class="btn btn-change" id="changeEmailBtn">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                </svg>
                                Change Email
                            </button>
                        </div>
                        <div id="emailEditState" style="display:none;">
                            <div class="email-edit-container">
                                <input type="email" id="emailInput" name="email_for_edit" value="{{ $user->email }}" class="form-control" placeholder="Enter new email address">
                                <button type="button" class="btn btn-success" id="saveEmailBtn">Save</button>
                                <button type="button" class="btn btn-secondary" id="cancelEmailBtn">Cancel</button>
                            </div>
                        </div>
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

            <div class="section">
                <h2 class="section-title">👤 Personal Information</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="passport_name">passport number</label>
                        <input type="text" id="passport_name" name="passport_name" class="form-control" value="{{ old('passport_name', $user->passport_name ?? '') }}">
                        @error('passport_name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Date of Birth</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-control" value="{{ old('birth_date', $user->birth_date ? ($user->birth_date instanceof \Carbon\Carbon ? $user->birth_date->format('Y-m-d') : $user->birth_date) : '') }}">
                        @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+62 812 3456 7890">
                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="4" placeholder="Enter your complete address">{{ old('address', $user->address ?? '') }}</textarea>
                    @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-submit">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                </svg>
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- Password Change Modal -->
<div id="changePasswordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>🔒 Change Password</h2>
            <button class="close-btn" id="closePasswordModalBtn">&times;</button>
        </div>
        <div class="modal-body">
            <form id="changePasswordForm" method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="modal_current_password">Current Password</label>
                    <input type="password" id="modal_current_password" name="current_password" class="form-control" required>
                    @error('current_password', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="modal_new_password">New Password</label>
                    <input type="password" id="modal_new_password" name="new_password" class="form-control" required>
                    @error('new_password', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="modal_new_password_confirmation">Confirm New Password</label>
                    <input type="password" id="modal_new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancelPasswordBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('photoPreview');
            output.src = reader.result;
            
            // Add smooth transition
            output.style.opacity = '0';
            setTimeout(() => {
                output.style.transition = 'opacity 0.3s ease';
                output.style.opacity = '1';
            }, 100);
        };
        if(event.target.files[0]){
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const passwordModal = document.getElementById('changePasswordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const closePasswordModalBtn = document.getElementById('closePasswordModalBtn');
        const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');
        const changePasswordForm = document.getElementById('changePasswordForm');
        const mainFormCSRF = document.querySelector('#mainProfileForm input[name="_token"]');

        // Password Modal Handlers
        if (changePasswordBtn && passwordModal) {
            changePasswordBtn.onclick = function() {
                passwordModal.style.display = "block";
                changePasswordForm.reset();
                document.body.style.overflow = 'hidden';
            };
        }

        function closeModal() {
            if (passwordModal) {
                passwordModal.style.display = "none";
                document.body.style.overflow = 'auto';
            }
        }

        if (closePasswordModalBtn) {
            closePasswordModalBtn.onclick = closeModal;
        }

        if (cancelPasswordBtn) {
            cancelPasswordBtn.onclick = closeModal;
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target == passwordModal) {
                closeModal();
            }
        });

        // Password Form AJAX Submission
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = 'Updating...';
                
                const formData = new FormData(this);
                const csrfToken = this.querySelector('input[name="_token"]').value;
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(data => ({ok: response.ok, status: response.status, data})))
                .then(result => {
                    const data = result.data;
                    
                    if (result.ok && data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Password updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        this.reset();
                        setTimeout(() => closeModal(), 2000);
                    } else {
                        let errorTitle = 'Error!';
                        let errorMessage = data.message || 'Failed to update password.';
                        
                        if (data.errors) {
                            errorTitle = 'Validation Error!';
                            errorMessage = Object.values(data.errors).flat().join('\n');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: errorTitle,
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Password Update Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to connect to server.',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.innerHTML = originalText;
                });
            });
        }

        // Email Edit Functionality
        const emailDisplayState = document.getElementById('emailDisplayState');
        const emailEditState = document.getElementById('emailEditState');
        const emailDisplayText = document.getElementById('emailDisplayText');
        const emailInput = document.getElementById('emailInput');
        const changeEmailBtn = document.getElementById('changeEmailBtn');
        const saveEmailBtn = document.getElementById('saveEmailBtn');
        const cancelEmailBtn = document.getElementById('cancelEmailBtn');
        const displayedEmailTextInfo = document.getElementById('displayedEmailTextInfo');

        if (changeEmailBtn && emailDisplayState && emailEditState) {
            changeEmailBtn.onclick = function() {
                emailDisplayState.style.display = 'none';
                emailEditState.style.display = 'block';
                if (emailInput && emailDisplayText) {
                    emailInput.value = emailDisplayText.textContent.trim();
                    emailInput.focus();
                }
            };
        }

        if (cancelEmailBtn && emailDisplayState && emailEditState) {
            cancelEmailBtn.onclick = function() {
                emailEditState.style.display = 'none';
                emailDisplayState.style.display = 'block';
            };
        }

        if (saveEmailBtn && emailInput && emailDisplayText && displayedEmailTextInfo && mainFormCSRF) {
            saveEmailBtn.onclick = function() {
                const newEmail = emailInput.value;
                const originalText = this.innerHTML;
                
                // Show loading state
                this.classList.add('loading');
                this.innerHTML = 'Saving...';
                
                fetch('{{ route("profile.email.update") }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': mainFormCSRF.value,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email: newEmail })
                })
                .then(response => response.json().then(data => ({ok: response.ok, status: response.status, data})))
                .then(result => {
                    const data = result.data;
                    
                    if (result.ok && data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Email updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        emailDisplayText.textContent = newEmail;
                        displayedEmailTextInfo.textContent = newEmail;
                        emailEditState.style.display = 'none';
                        emailDisplayState.style.display = 'block';
                    } else {
                        let errorTitle = 'Error!';
                        let errorMessage = data.message || 'Failed to update email.';
                        
                        if (data.errors) {
                            errorTitle = 'Validation Error!';
                            errorMessage = Object.values(data.errors).flat().join('\n');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: errorTitle,
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Email Update Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to connect to server.',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    this.classList.remove('loading');
                    this.innerHTML = originalText;
                });
            };
        }

        // Form submission loading state
        const mainForm = document.getElementById('mainProfileForm');
        if (mainForm) {
            mainForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.btn-submit');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.innerHTML = '<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg>Saving Changes...';
                }
            });
        }

        // Show session messages with SweetAlert
        @if (session('success') && !request()->ajax())
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error') && !request()->ajax())
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('updateEmail') && !request()->ajax())
            let errorsHtml = '<ul style="text-align:left; padding-left:20px; list-style-type:disc; margin-top:10px;">';
            @foreach ($errors->all() as $error)
                errorsHtml += `<li>{{ Illuminate\Support\Str::replace("'", "\\'", $error) }}</li>`;
            @endforeach
            errorsHtml += '</ul>';
            
            Swal.fire({
                icon: 'error',
                title: 'Validation Error!',
                html: errorsHtml,
                confirmButtonText: 'OK'
            });
        @endif

        // Open password modal if there are password errors
        @if ($errors->updatePassword->any() || session('status_updatePassword_error'))
            if (passwordModal) {
                passwordModal.style.display = "block";
                document.body.style.overflow = 'hidden';
            }
        @endif
    });
</script>

@endsection
