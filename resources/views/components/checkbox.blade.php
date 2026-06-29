@props([
    'name' => '',
    'label' => '',
    'value' => null,
    'checked' => false,
    'disabled' => false,
    'error' => null,
    'helper' => null,
])

@php
    $checkboxId = $attributes->get('id', 'checkbox-' . uniqid());
    $hasError = $error || $errors->has($name);
    $helperId = 'helper-' . $checkboxId;
    $describedBy = [];

    if ($hasError || $error) {
        $describedBy[] = 'error-' . $checkboxId;
    }
    if ($helper) {
        $describedBy[] = $helperId;
    }
@endphp

<div class="checkbox-group">
    <div class="checkbox-wrapper">
        <input type="checkbox" id="{{ $checkboxId }}" name="{{ $name }}" value="{{ $value ?? 'on' }}"
            @checked(old($name, $checked)) @disabled($disabled) @class(['checkbox-input', 'checkbox-input--error' => $hasError])
            @if (count($describedBy) > 0) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
            @if ($hasError || $error) aria-invalid="true" @endif
            {{ $attributes->except(['id', 'name', 'value', 'class']) }} />

        <label for="{{ $checkboxId }}" class="checkbox-label">
            <span class="checkbox-box" aria-hidden="true">
                <svg class="checkbox-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
            <span class="checkbox-text">{{ $label }}</span>
        </label>
    </div>

    @if ($hasError || $error)
        <div id="error-{{ $checkboxId }}" class="checkbox-message checkbox-message--error">
            {{ $error ?? $errors->first($name) }}
        </div>
    @endif

    @if ($helper && !$hasError)
        <div id="{{ $helperId }}" class="checkbox-message checkbox-message--helper">
            {{ $helper }}
        </div>
    @endif
</div>
