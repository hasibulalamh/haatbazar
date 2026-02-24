@extends('layouts.buyer')

@section('title', 'Dashboard')

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
        <p class="topbar-subtitle">Here's what's happening with your account today.</p>
    </div>
    <div class="topbar-actions">
        <a href="#" class="btn-icon"><i class="fa fa-bell"></i></a>
        <a href="#" class="btn-icon"><i class="fa fa-user"></i></a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fa fa-box"></i></div>
        <div class="stat-value">0</div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="fa fa-heart"></i></div>
        <div class="stat-value">0</div>
        <div class="stat-label">Wishlist Items</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa fa-star"></i></div>
        <div class="stat-value">0</div>
        <div class="stat-label">Reviews Given</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fa fa-cart-shopping"></i></div>
        <div class="stat-value">0</div>
        <div class="stat-label">Cart Items</div>
    </div>
</div>

<h2 class="section-title">Quick Actions</h2>
<div class="quick-actions">
    <a href="#" class="quick-action">
        <div class="quick-action-icon">🛍️</div>
        <div class="quick-action-label">Browse Products</div>
    </a>
    <a href="#" class="quick-action">
        <div class="quick-action-icon">📦</div>
        <div class="quick-action-label">My Orders</div>
    </a>
    <a href="#" class="quick-action">
        <div class="quick-action-icon">❤️</div>
        <div class="quick-action-label">Wishlist</div>
    </a>
    <a href="{{ route('buyer.profile.edit') }}" class="quick-action">
        <div class="quick-action-icon">👤</div>
        <div class="quick-action-label">Edit Profile</div>
    </a>
    <a href="#" class="quick-action">
        <div class="quick-action-icon">📍</div>
        <div class="quick-action-label">Addresses</div>
    </a>
    <a href="#" class="quick-action">
        <div class="quick-action-icon">⭐</div>
        <div class="quick-action-label">My Reviews</div>
    </a>
</div>

<h2 class="section-title">Recent Orders</h2>
<div class="card" style="padding: 20px;">
    <div class="empty-state">
        <i class="fa fa-box-open"></i>
        <p>You haven't placed any orders yet.</p>
        <a href="#" style="color: var(--primary-light); font-size:13px; margin-top:8px; display:inline-block;">
            Start Shopping →
        </a>
    </div>
</div>

@endsection
