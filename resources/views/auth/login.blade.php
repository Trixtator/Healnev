@extends('layouts.loglayout')

@section('title', 'Login - HealthNav')

@section('content')
<div class="auth-wrapper">
    <div class="auth-background">
        <div class="auth-overlay"></div>
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
    </div>

    <div class="auth-container">
        <div class="auth-card compact-landscape" data-aos="fade-up">

            <div class="auth-left-side">
                <div class="brand-section">
                    <img src="assets/images/logo1.png" alt="HealthNav Logo" class="brand-logo">
                    <h1 class="brand-title">HealthNav</h1>
                    <p class="auth-subtitle">Welcome back!</p>
                </div>
            </div>

            <div class="auth-right-side">
                <div class="form-header">
                    <h2>Sign In</h2>
                    <p>Please sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i> Email
                        </label>
                        <div class="input-wrapper">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                autocomplete="email"
                                autofocus
                                required>
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i> Password
                        </label>
                        <div class="input-wrapper">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="checkbox-label">
                                <span class="checkmark"></span> Remember me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </span>
                        <div class="btn-loader">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </button>

                    <div class="auth-divider">
                        <span>or</span>
                    </div>

                    <div class="auth-footer">
                        <p>Don't have an account?</p>
                        <a href="{{ route('register') }}" class="auth-link">
                            Create account <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced Global Variables */
    :root {
        --primary-color: #3498db;
        --primary-dark: #2980b9;
        --primary-light: #5dade2;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --dark-color: #2c3e50;
        --light-color: #ecf0f1;
        --white: #ffffff;
        --gradient-primary: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        --gradient-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 15px 50px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Reset and Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: var(--dark-color);
        /* Dihapus dari sini agar mobile bisa scroll */
    }

    .brand-logo {
        display: block;
        margin: 0 auto 10px auto;
        width: 100px;
        height: auto;
    }

    /* Auth Wrapper */
    .auth-wrapper {
        min-height: 100vh;
        height: auto; /* Memastikan tinggi bisa lebih dari 100vh di mobile */
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Background & Floating Shapes */
    .auth-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--gradient-bg);
        z-index: -2;
    }

    .auth-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') center/cover;
        opacity: 0.1;
    }

    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }

    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    .shape-1 { width: 80px; height: 80px; top: 20%; left: 10%; animation-delay: 0s; }
    .shape-2 { width: 120px; height: 120px; top: 60%; right: 15%; animation-delay: 2s; }
    .shape-3 { width: 60px; height: 60px; bottom: 30%; left: 20%; animation-delay: 4s; }
    .shape-4 { width: 100px; height: 100px; top: 10%; right: 30%; animation-delay: 1s; }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }

    /* Auth Container & Card */
    .auth-container {
        width: 100%;
        max-width: 750px;
        position: relative;
        z-index: 1;
        transform: translateY(-40px);
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .auth-card:hover {
        transform: scale(1.01);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .compact-landscape {
        display: flex;
        min-height: 420px;
        max-width: 700px;
        margin: 0 auto;
    }

    .auth-left-side {
        flex: 0 0 260px;
        background: var(--gradient-primary);
        padding: 25px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .auth-left-side::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') center/cover;
        opacity: 0.1;
        z-index: 0;
    }

    .auth-left-side > * {
        position: relative;
        z-index: 1;
    }

    .brand-section {
        margin-bottom: 20px;
    }

    .brand-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--white);
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .auth-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        margin: 0;
        line-height: 1.5;
    }

    .auth-right-side {
        flex: 1;
        padding: 20px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    /* Form Styles */
    .form-header {
        text-align: center;
        margin-bottom: 18px;
    }

    .form-header h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 4px;
    }

    .form-header p {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .auth-form {
        width: 100%;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 4px;
        font-size: 0.75rem;
    }

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 9px 38px 9px 12px;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        font-size: 0.8rem;
        transition: var(--transition);
        background: var(--white);
        color: var(--dark-color);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
    }

    .input-icon {
        position: absolute;
        right: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.8rem;
        pointer-events: none;
    }

    .password-toggle {
        position: absolute;
        right: 11px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 3px;
        border-radius: 3px;
        transition: var(--transition);
        font-size: 0.8rem;
    }

    .password-toggle:hover {
        color: var(--primary-color);
        background: rgba(52, 152, 219, 0.1);
    }

    .invalid-feedback {
        display: block;
        color: var(--danger-color);
        font-size: 0.65rem;
        margin-top: 3px;
        font-weight: 500;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 6px;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .remember-me input[type="checkbox"] {
        display: none;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 0.7rem;
        color: var(--dark-color);
        user-select: none;
    }

    .checkmark {
        width: 14px;
        height: 14px;
        border: 2px solid #ddd;
        border-radius: 3px;
        margin-right: 5px;
        position: relative;
        transition: var(--transition);
    }

    .checkmark::after {
        content: '';
        position: absolute;
        left: 3px;
        top: 0px;
        width: 3px;
        height: 6px;
        border: solid var(--white);
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
        transition: var(--transition);
    }

    .remember-me input[type="checkbox"]:checked + .checkbox-label .checkmark {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .remember-me input[type="checkbox"]:checked + .checkbox-label .checkmark::after {
        opacity: 1;
    }

    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.7rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-password:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .btn-submit {
        width: 100%;
        padding: 9px;
        background: var(--gradient-primary);
        border: none;
        border-radius: var(--border-radius);
        color: var(--white);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        margin-bottom: 14px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-text {
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .btn-loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: var(--transition);
    }

    .btn-submit.loading .btn-text {
        opacity: 0;
    }

    .btn-submit.loading .btn-loader {
        opacity: 1;
    }

    .auth-divider {
        text-align: center;
        margin: 12px 0;
        position: relative;
    }

    .auth-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e9ecef;
    }

    .auth-divider span {
        background: var(--white);
        padding: 0 15px;
        color: #6c757d;
        font-size: 0.75rem;
        position: relative;
    }

    .auth-footer {
        text-align: center;
    }

    .auth-footer p {
        color: #6c757d;
        margin-bottom: 5px;
        font-size: 0.75rem;
    }

    .auth-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
    }

    .auth-link:hover {
        color: var(--primary-dark);
        transform: translateX(2px);
    }

    /* =================================== */
    /* == RESPONSIVE & ACCESSIBILITY    == */
    /* =================================== */

    /* ATURAN BARU: Hanya untuk layar desktop (lebih besar dari 768px) */
    @media (min-width: 769px) {
        html,
        body {
            overflow: hidden; /* Matikan scroll HANYA di desktop */
        }
        .auth-wrapper {
            height: 100vh; /* Pastikan wrapper setinggi layar di desktop */
        }
    }

    /* Untuk tablet dan mobile */
    @media (max-width: 768px) {
        .auth-wrapper {
            padding: 40px 15px;
            align-items: flex-start; /* Konten mulai dari atas saat di-scroll */
        }

        .auth-container {
            transform: none; /* Matikan efek naik di mobile */
        }

        .compact-landscape {
            flex-direction: column;
            min-height: auto;
            max-width: 400px;
        }

        .auth-left-side,
        .auth-right-side {
            padding: 25px 20px;
        }
    }

    /* Untuk mobile yang lebih kecil */
    @media (max-width: 480px) {
        .auth-wrapper {
            padding: 30px 15px;
        }
        .auth-left-side,
        .auth-right-side {
            padding: 20px 15px;
        }
    }

    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation: none !important;
            transition: none !important;
        }
    }
</style>
@endsection

@section('scripts')
{{-- Script untuk toggle password, dll. tidak perlu diubah --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true
            });
        }

        window.togglePassword = function(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.parentElement.querySelector('.password-toggle');
            const icon = toggle.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        };

        const form = document.querySelector('.auth-form');
        const submitBtn = document.querySelector('.btn-submit');
        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });
        }
    });
</script>

{{-- Pastikan library AOS (Animate on Scroll) dimuat --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection