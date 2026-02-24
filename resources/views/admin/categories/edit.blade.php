@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

    <div class="topbar">
        <div>
            <h1 class="topbar-title">Edit Category</h1>
            <p class="topbar-subtitle">Update "{{ $category->name }}"</p>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('admin.categories.index') }}" class="btn-icon">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>
    </div>

    <div class="card" style="padding:32px; max-width:560px;">

        @if ($errors->any())
            <div class="alert-error" style="margin-bottom:20px;">
                @foreach ($errors->all() as $error)
                    <p><i class="fa fa-circle-exclamation"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="form-group">
                <label class="form-label">Category Name <span style="color:#fca5a5;">*</span></label>
                <div class="input-wrapper">
                    <i class="fa fa-layer-group input-icon"></i>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="form-input @error('name') is-invalid @enderror" placeholder="e.g. Electronics" required>
                </div>
            </div>

            {{-- Parent Category --}}
            <div class="form-group">
                <label class="form-label">Parent Category <span
                        style="color:var(--text-muted); font-size:12px;">(optional)</span></label>
                <div class="input-wrapper">
                    <i class="fa fa-sitemap input-icon"></i>
                    <select name="parent_id" class="form-input" style="cursor:pointer;">
                        <option value="">— None (Top Level) —</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Icon --}}
            <div class="form-group">
                <label class="form-label">Current Icon</label>
                <div
                    style="display:flex; align-items:center; gap:16px; padding:16px; background:rgba(99,102,241,0.05); border:1px solid rgba(99,102,241,0.2); border-radius:12px;">
                    <div
                        style="width:48px; height:48px; border-radius:12px; background:rgba(99,102,241,0.12); display:flex; align-items:center; justify-content:center;">
                        <i class="fa {{ $category->icon ?? 'fa-tag' }}" style="color:#a5b4fc; font-size:22px;"></i>
                    </div>
                    <p style="font-size:13px; color:var(--text-muted);">Icon auto-updates when you change the name.</p>
                </div>
            </div>

            <button type="submit" class="btn-submit" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                <span class="btn-text">Update Category &nbsp;<i class="fa fa-floppy-disk"></i></span>
                <span class="btn-loader"><i class="fa fa-spinner fa-spin"></i> &nbsp;Updating...</span>
            </button>

        </form>
    </div>

@endsection

@push('scripts')
    <script>
        function previewCategoryImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('preview-img').style.display = 'block';
                    document.getElementById('upload-placeholder').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
