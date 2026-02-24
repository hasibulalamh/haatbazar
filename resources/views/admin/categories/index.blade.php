@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

    <div class="topbar">
        <div>
            <h1 class="topbar-title">Categories</h1>
            <p class="topbar-subtitle">Manage all product categories</p>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                <i class="fa fa-plus"></i> Add Category
            </a>
        </div>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th>Subcategories</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div
                                style="width:40px; height:40px; border-radius:10px; background:rgba(99,102,241,0.12); display:flex; align-items:center; justify-content:center;">
                                <i class="fa {{ $category->icon ?? 'fa-tag' }}" style="color:#a5b4fc; font-size:18px;"></i>
                            </div>
                        </td>
                        <td style="font-weight:600;">{{ $category->name }}</td>
                        <td><code style="font-size:12px; color:#a5b4fc;">{{ $category->slug }}</code></td>
                        <td>
                            @if ($category->parent)
                                <span class="badge" style="background:rgba(99,102,241,0.1); color:#a5b4fc;">
                                    {{ $category->parent->name }}
                                </span>
                            @else
                                <span style="color:var(--text-muted); font-size:13px;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background:rgba(22,163,74,0.1); color:#86efac;">
                                {{ $category->children->count() }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px;">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    style="padding:6px 12px; background:rgba(99,102,241,0.1); color:#a5b4fc; border-radius:8px; font-size:12px; text-decoration:none;">
                                    <i class="fa fa-pen"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="padding:6px 12px; background:rgba(239,68,68,0.1); color:#fca5a5; border-radius:8px; font-size:12px; border:none; cursor:pointer;">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fa fa-layer-group"></i>
                                <p>No categories yet.</p>
                                <a href="{{ route('admin.categories.create') }}"
                                    style="color:#a5b4fc; font-size:13px; margin-top:8px; display:inline-block;">
                                    Add First Category →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
