@extends('layouts.loglayout')

@section('title', 'Login MediCare Connect')

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

    .wrapper-login {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
    }

    .container-login {
        max-width: 400px;
        width: 100%;
        padding: 2rem 2.5rem;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(52, 152, 219, 0.3);
        position: relative;
        overflow: hidden;
    }

    /* Blue sky cloud background in center */
    .container-login::before {
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
    .container-login::after {
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

    .hospital-icon {
        font-size: 2.8rem;
        color: #3498db;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #3498db;
        font-size: 28px;
        position: relative;
        z-index: 1;
    }

    .login-subtitle {
        margin-bottom: 1.5rem;
        font-size: 1rem;
        color: #2c3e50;
        position: relative;
        z-index: 1;
    }

    .login-form {
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-floating-label {
        position: relative;
    }

    .input-border-bottom {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 10px 15px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .input-border-bottom:focus {
        box-shadow: none;
        border: 2px solid #3498db;
    }

    .form-floating-label label {
        color: #3498db;
        font-weight: 600;
        font-size: 16px;
        position: absolute;
        top: -20px;
        left: 0;
    }

    .medical-icon {
        color: #3498db;
        margin-right: 8px;
    }

    .custom-control-label {
        color: #2c3e50;
    }

    .form-action {
        margin-top: 25px;
    }

    .btn-login {
        background-color: #3498db;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        width: 100%;
        color: white;
    }

    .btn-login:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .register-link {
        margin-top: 1rem;
        text-align: center;
        color: #2c3e50;
    }

    .register-link a {
        color: #3498db;
        font-weight: 500;
        font-size: 15px;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .healthcare-footer {
        position: absolute;
        bottom: -40px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        font-weight: 600;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
</style>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <div class="hospital-icon">
                <i class="fas fa-hospital-alt"></i>
            </div>
            <h3 class="text-center" style="font-size: 28px; color: #3498db;">HealthNav</h3>
            <p class="login-subtitle">Log in to access</p>

            <div class="login-form">
                <div class="form-group form-floating-label">
                    <label for="username">
                        <i class="fas fa-user medical-icon"></i>Email Address
                    </label>
                    <input id="username" name="email" type="text" class="form-control input-border-bottom @error('email') is-invalid @enderror" autocomplete="off" autofocus required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group form-floating-label">
                    <label for="password">
                        <i class="fas fa-lock medical-icon"></i>Password
                    </label>
                    <input id="password" name="password" type="password" class="form-control input-border-bottom @error('password') is-invalid @enderror" autocomplete="off" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row form-sub m-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Remember Me</label>
                    </div>
                </div>
                <div class="form-action mb-3">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </div>
                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            </div>

            <div class="healthcare-footer">
                Trusted by HealthNav
            </div>
        </div>
    </div>
</form>
@endsection