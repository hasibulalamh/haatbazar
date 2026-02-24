<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HaatBazar — Seller Register</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .logo-badge.seller { background: rgba(245,158,11,0.15) !important; border-color: rgba(245,158,11,0.3) !important; color: #fcd34d !important; }
        .btn-submit { background: linear-gradient(135deg, #d97706, #b45309); }
        .btn-submit:hover { box-shadow: 0 8px 25px rgba(217,119,6,0.4); }
        .buyer-link { display:flex; align-items:center; justify-content:center; gap:8px; background:rgba(22,163,74,0.08); border:1px solid rgba(22,163,74,0.2); border-radius:10px; padding:10px 16px; margin-top:12px; text-decoration:none; transition:all 0.25s; }
        .buyer-link span { color: var(--primary-light); font-size:13px; font-weight:500; }
        .buyer-link:hover { background:rgba(22,163,74,0.15); border-color:rgba(22,163,74,0.4); }
        .bg-orb-1 { background: #d97706 !important; }
    </style>
</head>
<body class="auth-page">

<div class="bg-canvas">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
</div>
<div class="bg-grid"></div>

<div class="auth-wrapper">
    <div class="auth-card card">

        <div class="auth-logo">
            <div class="logo-text">HaatBazar</div>
            <div class="logo-badge seller">SELLER PORTAL</div>
        </div>

        <h2 class="auth-title">Become a Seller</h2>
        <p class="auth-subtitle">Start selling on HaatBazar today</p>

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p><i class="fa fa-circle-exclamation" style="margin-right:6px;"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('seller.register.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <div class="input-wrapper">
                    <i class="fa fa-user input-icon"></i>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-input @error('name') is-invalid @enderror"
                        placeholder="Enter your full name" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <i class="fa fa-envelope input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-input @error('email') is-invalid @enderror"
                        placeholder="you@example.com" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <div class="input-wrapper">
                    <i class="fa fa-phone input-icon"></i>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="form-input @error('phone') is-invalid @enderror"
                        placeholder="01XXXXXXXXX" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="Minimum 8 characters" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-input" placeholder="Repeat your password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <span class="btn-text">Create Seller Account &nbsp;<i class="fa fa-store"></i></span>
                <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Creating...</span>
            </button>
        </form>

        <div class="auth-links">
            <p>Already have an account? <a href="{{ route('seller.login') }}">Login here</a></p>
            <a href="{{ route('buyer.register') }}" class="buyer-link">
                <i class="fa fa-bag-shopping" style="color:var(--primary-light);"></i>
                <span>Register as Buyer instead</span>
                <i class="fa fa-chevron-right" style="color:var(--primary-light); font-size:11px;"></i>
            </a>
        </div>

    </div>
</div>

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
