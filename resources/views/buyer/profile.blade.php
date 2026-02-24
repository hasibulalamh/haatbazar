@extends('layouts.buyer')

@section('title', 'My Profile')

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">My Profile</h1>
        <p class="topbar-subtitle">Manage your personal information</p>
    </div>
</div>

<div class="profile-wrapper" style="max-width:520px; margin:0 auto;">
    {{-- Avatar Section --}}
    <div class="card profile-card" style="padding:32px; margin-bottom:20px;">
        <div class="avatar-section">
            <div class="avatar-wrapper">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-img">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif
                <label for="avatar-upload" class="avatar-edit-btn">
                    <i class="fa fa-camera"></i>
                </label>
            </div>
            <h2 class="profile-name">{{ Auth::user()->name }}</h2>
            <span class="badge badge-primary">
                <i class="fa fa-circle-check"></i> Verified Buyer
            </span>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fa fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p><i class="fa fa-circle-exclamation"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Tabs --}}
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('info', this)">
                <i class="fa fa-user"></i> Personal Info
            </button>
            <button class="tab-btn" onclick="switchTab('password', this)">
                <i class="fa fa-lock"></i> Password
            </button>
        </div>

        {{-- Tab: Personal Info --}}
        <div id="tab-info" class="tab-content active">
            <form method="POST" action="{{ route('buyer.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <input type="file" id="avatar-upload" name="avatar" accept="image/*"
                    style="display:none;" onchange="previewAvatar(this)">

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrapper">
                        <i class="fa fa-user input-icon"></i>
                        <input type="text" name="name"
                            value="{{ old('name', Auth::user()->name) }}"
                            class="form-input @error('name') is-invalid @enderror"
                            placeholder="Your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fa fa-envelope input-icon"></i>
                        <input type="email" name="email"
                            value="{{ old('email', Auth::user()->email) }}"
                            class="form-input @error('email') is-invalid @enderror"
                            placeholder="your@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <div class="input-wrapper">
                        <i class="fa fa-phone input-icon"></i>
                        <input type="text" name="phone"
                            value="{{ old('phone', Auth::user()->phone) }}"
                            class="form-input @error('phone') is-invalid @enderror"
                            placeholder="01XXXXXXXXX">
                    </div>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="fa fa-calendar"></i> Member Since</span>
                    <span class="info-value">{{ Auth::user()->created_at->format('d M, Y') }}</span>
                </div>

                <button type="submit" class="btn-submit" style="margin-top:20px;">
                    <span class="btn-text">Save Changes &nbsp;<i class="fa fa-floppy-disk"></i></span>
                    <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Saving...</span>
                </button>
            </form>
        </div>

        {{-- Tab: Password --}}
        <div id="tab-password" class="tab-content">
            <form method="POST" action="{{ route('buyer.password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" name="current_password" id="current_password"
                            class="form-input @error('current_password') is-invalid @enderror"
                            placeholder="Enter current password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('current_password', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" name="password" id="new_password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Minimum 8 characters" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('new_password', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="confirm_password"
                            class="form-input" placeholder="Repeat new password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirm_password', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" style="margin-top:20px;">
                    <span class="btn-text">Update Password &nbsp;<i class="fa fa-shield"></i></span>
                    <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Updating...</span>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
