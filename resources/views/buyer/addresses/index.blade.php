@extends('layouts.buyer')

@section('title', 'My Addresses')

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">My Addresses</h1>
        <p class="topbar-subtitle">Manage your delivery addresses</p>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('buyer.addresses.create') }}" class="btn-submit"
            style="background:linear-gradient(135deg,#6366f1,#4f46e5); width:auto; padding:10px 20px; margin:0; font-size:13px; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa fa-plus"></i> Add Address
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:20px;">
        <i class="fa fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:16px;">
    @forelse($addresses as $address)
    <div class="card" style="padding:20px; position:relative; border-color:{{ $address->is_default ? 'rgba(99,102,241,0.4)' : 'var(--border)' }};">

        @if($address->is_default)
            <span style="position:absolute; top:14px; right:14px; font-size:11px; background:rgba(99,102,241,0.1); color:#a5b4fc; padding:3px 10px; border-radius:20px; font-weight:600;">
                <i class="fa fa-circle-check"></i> Default
            </span>
        @endif

        <div style="margin-bottom:14px;">
            <div style="font-weight:700; font-size:15px; margin-bottom:4px;">{{ $address->name }}</div>
            <div style="font-size:13px; color:var(--text-muted); margin-bottom:2px;">
                <i class="fa fa-phone"></i> {{ $address->phone }}
            </div>
            <div style="font-size:13px; color:var(--text-muted); margin-bottom:2px;">
                <i class="fa fa-location-dot"></i> {{ $address->address }}
            </div>
            <div style="font-size:13px; color:var(--text-muted);">
                <i class="fa fa-city"></i> {{ $address->city }}
            </div>
        </div>

        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            @if(!$address->is_default)
                <form method="POST" action="{{ route('buyer.addresses.default', $address) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                        style="padding:6px 12px; background:rgba(99,102,241,0.1); color:#a5b4fc; border-radius:8px; font-size:12px; border:none; cursor:pointer;">
                        <i class="fa fa-circle-check"></i> Set Default
                    </button>
                </form>
            @endif

            <a href="{{ route('buyer.addresses.edit', $address) }}"
               style="padding:6px 12px; background:rgba(217,119,6,0.1); color:#fcd34d; border-radius:8px; font-size:12px; text-decoration:none;">
                <i class="fa fa-pen"></i> Edit
            </a>

            <form method="POST" action="{{ route('buyer.addresses.destroy', $address) }}"
                  onsubmit="return confirm('Delete this address?')">
                @csrf @method('DELETE')
                <button type="submit"
                    style="padding:6px 12px; background:rgba(239,68,68,0.1); color:#fca5a5; border-radius:8px; font-size:12px; border:none; cursor:pointer;">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;">
        <div class="card" style="padding:40px; text-align:center;">
            <i class="fa fa-location-dot" style="font-size:36px; color:var(--text-muted); opacity:0.4; display:block; margin-bottom:12px;"></i>
            <p style="color:var(--text-muted); margin-bottom:16px;">No addresses yet.</p>
            <a href="{{ route('buyer.addresses.create') }}"
               style="color:#a5b4fc; font-size:13px;">Add Your First Address →</a>
        </div>
    </div>
    @endforelse
</div>

@endsection
