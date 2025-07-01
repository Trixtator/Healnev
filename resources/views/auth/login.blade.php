@extends('layouts.loglayout')

@section('title', 'Login - HealthNav')

@section('content')
<!-- Compact Landscape Login Page - No Tilt -->
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

            <!-- Left Side - Branding (Compact) -->
            <div class="auth-left-side">
                <div class="brand-section">
                    <div class="brand-icon">
                        <i class="fas fa-hospital-alt"></i>
                    </div>
                    <h1 class="brand-title">HealthNav</h1>
                    <p class="auth-subtitle">Welcome back!</p>
                </div>

                <!-- <div class="trust-badges">
                    <div class="trust-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure</span>
                    </div>
                    <div class="trust-badge">
                        <i class="fas fa-user-md"></i>
                        <span>Trusted</span>
                    </div>
                    <div class="trust-badge">
                        <i class="fas fa-clock"></i>
                        <span>24/7</span>
                    </div>
                </div> -->
            </div>

            <!-- Right Side - Login Form (Compact) -->
            <div class="auth-right-side">
                <div class="form-header">
                    <h2>Sign In</h2>
                    <p>Please sign in to your account</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>
                            Email
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
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>
                            Password
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
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="checkbox-label">
                                <span class="checkmark"></span>
                                Remember me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot?
                        </a>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Sign In
                        </span>
                        <div class="btn-loader">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </button>

                    <div class="auth-divider">
                        <span>or</span>
                    </div>

                    <!-- <div class="social-login">
                        <button type="button" class="btn-social btn-google">
                            <i class="fab fa-google"></i>
                            Continue with Google
                        </button>
                    </div> -->

                    <div class="auth-footer">
                        <p>Don't have an account?</p>
                        <a href="{{ route('register') }}" class="auth-link">
                            Create account
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Compact Landscape Styles - NO TILT EFFECTS -->
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
        overflow-x: hidden;
    }

    /* Auth Wrapper */
    .auth-wrapper {
        min-height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Background */
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

    /* Floating Shapes */
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

    .shape-1 {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .shape-3 {
        width: 60px;
        height: 60px;
        bottom: 30%;
        left: 20%;
        animation-delay: 4s;
    }

    .shape-4 {
        width: 100px;
        height: 100px;
        top: 10%;
        right: 30%;
        animation-delay: 1s;
    }

    /* Auth Container - Compact */
    .auth-container {
        width: 100%;
        max-width: 750px;
        /* Smaller for login */
        position: relative;
        z-index: 1;
    }

    /* Compact Landscape Card - NO TILT */
    .compact-landscape {
        display: flex;
        min-height: 420px;
        /* Smaller for login */
        max-width: 700px;
        margin: 0 auto;
    }

    /* Auth Card - NO TILT EFFECTS */
    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        /* NO TRANSFORM - COMPLETELY STRAIGHT */
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        border-radius: 24px 24px 0 0;
    }

    /* Hover Effect - Only Scale, NO TILT */
    .auth-card:hover {
        transform: scale(1.01);
        /* Only scale, no rotation */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    /* Left Side - Compact Branding */
    .auth-left-side {
        flex: 0 0 260px;
        /* Smaller width for login */
        background: var(--gradient-primary);
        padding: 25px 20px;
        /* Reduced padding */
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
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') center/cover;
        opacity: 0.1;
        z-index: 0;
    }

    .auth-left-side>* {
        position: relative;
        z-index: 1;
    }

    /* Brand Section - Compact */
    .brand-section {
        margin-bottom: 20px;
        /* Reduced margin */
    }

    .brand-icon {
        width: 55px;
        /* Smaller icon */
        height: 55px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        /* Reduced margin */
        box-shadow: var(--shadow-md);
        /* NO ROTATION - STRAIGHT */
        transition: var(--transition);
    }

    .brand-icon:hover {
        /* NO ROTATION - Only scale */
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.3);
    }

    .brand-icon i {
        font-size: 1.3rem;
        /* Smaller icon */
        color: var(--white);
    }

    .brand-title {
        font-size: 1.5rem;
        /* Smaller for compact */
        font-weight: 800;
        color: var(--white);
        margin-bottom: 6px;
        /* Reduced margin */
        letter-spacing: -0.5px;
    }

    .auth-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        /* Smaller font */
        margin: 0;
        line-height: 1.5;
    }

    /* Trust Badges - Compact */
    .trust-badges {
        display: flex;
        flex-direction: column;
        gap: 6px;
        /* Reduced gap */
        width: 100%;
    }

    .trust-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        /* Reduced gap */
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 10px;
        /* Reduced padding */
        border-radius: 6px;
        /* Smaller border radius */
        backdrop-filter: blur(10px);
        font-size: 0.75rem;
        /* Smaller font */
        transition: var(--transition);
    }

    .trust-badge:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(2px);
        /* Reduced movement */
    }

    .trust-badge i {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.8rem;
        /* Smaller icon */
    }

    /* Right Side - Compact Form */
    .auth-right-side {
        flex: 1;
        padding: 20px 18px;
        /* Reduced padding */
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    /* Form Header - Compact */
    .form-header {
        text-align: center;
        margin-bottom: 18px;
        /* Reduced margin */
    }

    .form-header h2 {
        font-size: 1.3rem;
        /* Smaller font */
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 4px;
        /* Reduced margin */
    }

    .form-header p {
        color: #6c757d;
        font-size: 0.8rem;
        /* Smaller font */
    }

    /* Form Styles - Compact */
    .auth-form {
        width: 100%;
    }

    .form-group {
        margin-bottom: 14px;
        /* Reduced margin */
    }

    .form-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 4px;
        /* Reduced margin */
        font-size: 0.75rem;
        /* Smaller font */
    }

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 9px 38px 9px 12px;
        /* Reduced padding */
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        font-size: 0.8rem;
        /* Smaller font */
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
        /* Adjusted position */
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.8rem;
        /* Smaller font */
        pointer-events: none;
    }

    .password-toggle {
        position: absolute;
        right: 11px;
        /* Adjusted position */
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 3px;
        /* Reduced padding */
        border-radius: 3px;
        transition: var(--transition);
        font-size: 0.8rem;
        /* Smaller font */
    }

    .password-toggle:hover {
        color: var(--primary-color);
        background: rgba(52, 152, 219, 0.1);
    }

    .invalid-feedback {
        display: block;
        color: var(--danger-color);
        font-size: 0.65rem;
        /* Smaller font */
        margin-top: 3px;
        /* Reduced margin */
        font-weight: 500;
    }

    /* Form Options - Compact */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        /* Reduced margin */
        flex-wrap: wrap;
        gap: 6px;
        /* Reduced gap */
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
        /* Smaller font */
        color: var(--dark-color);
        user-select: none;
    }

    .checkmark {
        width: 14px;
        /* Smaller checkbox */
        height: 14px;
        border: 2px solid #ddd;
        border-radius: 3px;
        margin-right: 5px;
        /* Reduced margin */
        position: relative;
        transition: var(--transition);
    }

    .checkmark::after {
        content: '';
        position: absolute;
        left: 3px;
        /* Adjusted position */
        top: 0px;
        width: 3px;
        /* Smaller checkmark */
        height: 6px;
        border: solid var(--white);
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
        transition: var(--transition);
    }

    .remember-me input[type="checkbox"]:checked+.checkbox-label .checkmark {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .remember-me input[type="checkbox"]:checked+.checkbox-label .checkmark::after {
        opacity: 1;
    }

    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.7rem;
        /* Smaller font */
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-password:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Submit Button - Compact */
    .btn-submit {
        width: 100%;
        padding: 9px;
        /* Reduced padding */
        background: var(--gradient-primary);
        border: none;
        border-radius: var(--border-radius);
        color: var(--white);
        font-size: 0.85rem;
        /* Smaller font */
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        margin-bottom: 14px;
        /* Reduced margin */
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

    /* Social Login - Compact */
    .social-login {
        margin-bottom: 14px;
        /* Reduced margin */
    }

    .btn-social {
        width: 100%;
        padding: 8px;
        /* Reduced padding */
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        background: white;
        color: var(--dark-color);
        font-size: 0.8rem;
        /* Smaller font */
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        /* Reduced gap */
    }

    .btn-social:hover {
        border-color: var(--primary-color);
        background: rgba(52, 152, 219, 0.05);
    }

    .btn-google i {
        color: #db4437;
    }

    /* Auth Divider - Compact */
    .auth-divider {
        text-align: center;
        margin: 12px 0;
        /* Reduced margin */
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
        /* Reduced padding */
        color: #6c757d;
        font-size: 0.75rem;
        /* Smaller font */
        position: relative;
    }

    /* Auth Footer - Compact */
    .auth-footer {
        text-align: center;
    }

    .auth-footer p {
        color: #6c757d;
        margin-bottom: 5px;
        /* Reduced margin */
        font-size: 0.75rem;
        /* Smaller font */
    }

    .auth-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8rem;
        /* Smaller font */
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
    }

    .auth-link:hover {
        color: var(--primary-dark);
        transform: translateX(2px);
    }

    /* Animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(10deg);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .auth-container {
            max-width: 100%;
            padding: 0 15px;
        }

        .compact-landscape {
            flex-direction: column;
            min-height: auto;
            max-width: 380px;
            /* Smaller for mobile */
        }

        .auth-left-side {
            flex: none;
            padding: 18px 15px;
            /* Reduced padding */
        }

        .auth-right-side {
            padding: 18px 15px;
            /* Reduced padding */
        }

        .brand-title {
            font-size: 1.3rem;
            /* Smaller on mobile */
        }

        .trust-badges {
            flex-direction: row;
            justify-content: space-around;
        }

        .trust-badge {
            flex-direction: column;
            text-align: center;
            padding: 5px 6px;
            /* Reduced padding */
        }
    }

    @media (max-width: 480px) {

        .auth-left-side,
        .auth-right-side {
            padding: 15px 12px;
            /* Further reduced padding */
        }

        .brand-title {
            font-size: 1.2rem;
        }

        .form-control {
            padding: 8px 35px 8px 10px;
            /* Further reduced padding */
        }

        .btn-submit {
            padding: 8px;
            font-size: 0.8rem;
        }
    }

    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .auth-card {
            border: 2px solid var(--dark-color);
        }

        .form-control {
            border: 2px solid var(--dark-color);
        }

        .btn-submit {
            background: var(--dark-color);
        }
    }

    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        .shape {
            animation: none;
        }
    }
</style>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true
            });
        }

        // Password toggle functionality
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

        // Form submission with loading state
        const form = document.querySelector('.auth-form');
        const submitBtn = document.querySelector('.btn-submit');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });
        }

        // Enhanced form validation
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });

            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Keyboard navigation enhancement
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });
    });
</script>

<!-- Add AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection