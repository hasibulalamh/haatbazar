<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HaatBazar — Buyer Login</title>
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

<div class="auth-wrapper">
    <div class="auth-card card">

        {{-- Logo --}}
        <div class="auth-logo">
            <div class="logo-text">HaatBazar</div>
            <div class="logo-badge">Buyer Portal</div>
        </div>

        {{-- Title --}}
        <h2 class="auth-title">Welcome back!</h2>
        <p class="auth-subtitle">Login to your buyer account</p>

        {{-- Session Status --}}
        @if(session('status'))
            <div class="alert-success">
                <i class="fa fa-circle-check"></i> {{ session('status') }}
            </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p><i class="fa fa-circle-exclamation" style="margin-right:6px;"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('buyer.login.store') }}">
            @csrf

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
                        autofocus
                    >
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <label class="form-label" style="margin-bottom:0;">Password</label>
                    <a href="#" style="font-size:12px; color:var(--primary-light);">Forgot password?</a>
                </div>
                <div class="input-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Remember Me --}}
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                <input type="checkbox" name="remember" id="remember"
                    style="width:16px; height:16px; accent-color:var(--primary); cursor:pointer;">
                <label for="remember" style="font-size:13px; color:var(--text-muted); cursor:pointer;">Remember me</label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                <span class="btn-text">Login &nbsp;<i class="fa fa-arrow-right"></i></span>
                <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Logging in...</span>
            </button>

        </form>

        {{-- Links --}}
        <div class="auth-links">
            <p>Don't have an account? <a href="{{ route('buyer.register') }}">Register here</a></p>
            <a href="#" class="seller-link">
                <i class="fa fa-store" style="color:var(--accent-light);"></i>
                <span>Login as Seller instead</span>
                <i class="fa fa-chevron-right" style="color:var(--accent-light); font-size:11px;"></i>
            </a>
        </div>

    </div>
</div>

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
