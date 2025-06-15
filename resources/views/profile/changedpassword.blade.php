@extends('layouts.app')

@section('content')
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-image: url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
        /* Blue-themed medical examination room */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: 'Nunito', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        position: relative;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(52, 152, 219, 0.7);
        backdrop-filter: blur(3px);
        z-index: -1;
    }

    .auth-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .form-box {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(52, 152, 219, 0.3);
        max-width: 520px;
        width: 100%;
        padding: 2rem 2.5rem;
        color: #2c3e50;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    /* Blue sky cloud background in center */
    .form-box::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.92) 0%, rgba(135, 206, 250, 0.9) 50%, rgba(255, 255, 255, 0.92) 100%);
        border-radius: 16px;
        z-index: -1;
    }

    /* Decorative clouds */
    .form-box::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        height: 60%;
        background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNjUsMjBjLTMuMywwLTYuMywxLjQtOC41LDMuNUM1NCwyMC4zLDUwLjMsMTgsNDYsMThjLTYuMSwwLTExLDQuOS0xMSwxMWMwLDAuNSwwLjEsMSwwLjIsMS41QzM0LDI5LjUsMzIuMiwyOSwzMCwyOWMtNS41LDAtMTAsNC41LTEwLDEwIGMwLDUuNSw0LjUsMTAsMTAsMTBoNDVjNS41LDAsMTAtNC41LDEwLTEwQzg1LDMzLjUsODAuNSwyOSw3NSwyOWMtMC40LDAtMC44LDAtMS4yLDAuMUM3My45LDIzLjUsNzAsMjAsNjUsMjB6IiBmaWxsPSJ3aGl0ZSIgb3BhY2l0eT0iMC43Ii8+PC9zdmc+');
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: 0.2;
        z-index: -1;
    }

    .form-header {
        text-align: center;
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .form-box h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #3498db;
        font-size: 28px;
    }

    .form-box p {
        margin-bottom: 1.2rem;
        font-size: 1rem;
        color: #2c3e50;
    }

    .medical-icon {
        color: #3498db;
        margin-right: 8px;
    }

    label {
        color: #3498db;
        font-weight: 600;
        font-size: 16px;
    }

    .form-control {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 15px;
        width: 100%;
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid #3498db;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
        position: relative;
        z-index: 1;
    }

    .hospital-icon {
        font-size: 2.8rem;
        color: #3498db;
        margin-bottom: 0.5rem;
    }

    .alert {
        border-radius: 8px;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .alert-success {
        background-color: rgba(46, 204, 113, 0.2);
        border: 1px solid #2ecc71;
        color: #27ae60;
    }

    .alert-danger {
        background-color: rgba(231, 76, 60, 0.2);
        border: 1px solid #e74c3c;
        color: #c0392b;
    }

    .alert ul {
        padding-left: 20px;
    }
</style>

<div class="auth-container">
    <div class="form-box">
        <div class="form-header">
            <div class="hospital-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2>Change Password</h2>
            <p>Update your password securely</p>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">
                    <i class="fas fa-key medical-icon"></i>Current Password
                </label>
                <input type="password" name="current_password" id="current_password" class="form-control" required placeholder="Enter your current password">
            </div>

            <div class="form-group">
                <label for="new_password">
                    <i class="fas fa-lock medical-icon"></i>New Password
                </label>
                <input type="password" name="new_password" id="new_password" class="form-control" required placeholder="Enter your new password">
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">
                    <i class="fas fa-check-circle medical-icon"></i>Confirm New Password
                </label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required placeholder="Confirm your new password">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection