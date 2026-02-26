<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HaatBazar — Create Account</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="auth-page">

{{-- Animated Background --}}
<div class="bg-canvas">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
</div>
<div class="bg-grid"></div>

{{-- Auth Wrapper --}}
<div class="auth-wrapper">
    <div class="auth-card">

        {{-- Logo --}}
        <div class="auth-logo">
            <div class="logo-text">HaatBazar</div>
            <div class="logo-badge">Buyer Portal</div>
        </div>

        {{-- Title --}}
        <h2 class="auth-title">Create your account</h2>
        <p class="auth-subtitle">Join thousands of buyers shopping across Bangladesh</p>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p><i class="fa fa-circle-exclamation" style="margin-right:6px;"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('buyer.register.store') }}">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <div class="input-wrapper">
                    <i class="fa fa-user input-icon"></i>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-input @error('name') is-invalid @enderror"
                        placeholder="Enter your full name"
                        required
                        autofocus
                    >
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <i class="fa fa-envelope input-icon"></i>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        required
                    >
                </div>
            </div>

            {{-- Phone --}}
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <div class="input-wrapper">
                    <i class="fa fa-phone input-icon"></i>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="form-input @error('phone') is-invalid @enderror"
                        placeholder="01XXXXXXXXX"
                        required
                    >
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="Minimum 8 characters"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-input"
                        placeholder="Repeat your password"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                <span class="btn-text">Create Account &nbsp;<i class="fa fa-arrow-right"></i></span>
                <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Creating...</span>
            </button>

        </form>

        {{-- Links --}}
        <div class="auth-links">
            <p>Already have an account? <a href="{{ route('buyer.login') }}">Login here</a></p>
            <a href="/seller/register" class="seller-link">
                <i class="fa fa-store" style="color:#fcd34d;"></i>
                <span>Want to sell on HaatBazar? Register as Seller</span>
                <i class="fa fa-chevron-right" style="color:#fcd34d; font-size:11px;"></i>
            </a>
        </div>

    </div>
</div>

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
