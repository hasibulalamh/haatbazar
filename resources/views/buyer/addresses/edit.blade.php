@extends('layouts.buyer')

@section('title', 'Edit Address')

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">Edit Address</h1>
        <p class="topbar-subtitle">Update your delivery address</p>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('buyer.addresses.index') }}" class="btn-icon">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
</div>

<div class="card" style="padding:32px; max-width:560px; margin:0 auto;">

    @if($errors->any())
        <div class="alert-error" style="margin-bottom:20px;">
            @foreach($errors->all() as $error)
                <p><i class="fa fa-circle-exclamation"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('buyer.addresses.update', $address) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="form-label">Full Name <span style="color:#fca5a5;">*</span></label>
            <div class="input-wrapper">
                <i class="fa fa-user input-icon"></i>
                <input type="text" name="name" value="{{ old('name', $address->name) }}"
                    class="form-input @error('name') is-invalid @enderror"
                    placeholder="Recipient name" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Phone <span style="color:#fca5a5;">*</span></label>
            <div class="input-wrapper">
                <i class="fa fa-phone input-icon"></i>
                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}"
                    class="form-input @error('phone') is-invalid @enderror"
                    placeholder="01XXXXXXXXX" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Address <span style="color:#fca5a5;">*</span></label>
            <textarea name="address" rows="3"
                class="form-input @error('address') is-invalid @enderror"
                style="padding:12px 14px; resize:vertical; height:auto;"
                placeholder="House, Road, Area..." required>{{ old('address', $address->address) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">City <span style="color:#fca5a5;">*</span></label>
            <div class="input-wrapper">
                <i class="fa fa-city input-icon"></i>
                <input type="text" name="city" value="{{ old('city', $address->city) }}"
                    class="form-input @error('city') is-invalid @enderror"
                    placeholder="Dhaka, Chittagong..." required>
            </div>
        </div>

        <button type="submit" class="btn-submit" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
            <span class="btn-text">Update Address &nbsp;<i class="fa fa-floppy-disk"></i></span>
            <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Updating...</span>
        </button>
    </form>
</div>

@endsection
