@props([
    'name' => '',
    'value' => null,
    'label' => '',
    'checked' => false,
    'disabled' => false,
])

@php
    $radioId = $attributes->get('id', 'radio-' . uniqid());
@endphp

<div class="radio-option">
    <input type="radio" id="{{ $radioId }}" name="{{ $name }}" value="{{ $value }}"
        @checked(old($name, $checked)) @disabled($disabled) class="radio-input"
        {{ $attributes->except(['id', 'name', 'value', 'class']) }} />

    <label for="{{ $radioId }}" class="radio-label">
        <span class="radio-box" aria-hidden="true">
            <span class="radio-dot"></span>
        </span>
        <span class="radio-text">{{ $label }}</span>
    </label>
</div>
