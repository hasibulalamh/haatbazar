@props([
    'name' => '',
    'type' => 'text',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'error' => null,
    'helper' => null,
    'icon' => null,
    'iconEnd' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
])

@php
    $inputId = $attributes->get('id', 'input-' . uniqid());
    $hasError = $error || $errors->has($name);
    $helperId = 'helper-' . $inputId;
    $describedBy = [];

    if ($hasError || $error) {
        $describedBy[] = 'error-' . $inputId;
    }
    if ($helper) {
        $describedBy[] = $helperId;
    }
@endphp

<div class="input-group">
    {{-- Label --}}
    @if ($label)
        <label for="{{ $inputId }}" class="input-label">
            {{ $label }}
            @if ($required)
                <span class="input-label__required" aria-label="required">*</span>
            @endif
        </label>
    @endif

    {{-- Input Container --}}
    <div class="input-wrapper">
        {{-- Leading Icon --}}
        @if ($icon)
            <span class="input-icon input-icon--start" aria-hidden="true">
                @svg('icons.' . $icon, 'input-icon-svg')
            </span>
        @endif

        {{-- Input Element --}}
        <input type="{{ $type }}" id="{{ $inputId }}" name="{{ $name }}"
            placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" @disabled($disabled)
            @readonly($readonly) @required($required) @class([
                'input',
                'input--error' => $hasError,
                'input--with-icon-start' => $icon,
                'input--with-icon-end' => $iconEnd && !$hasError,
            ])
            @if (count($describedBy) > 0) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
            @if ($hasError || $error) aria-invalid="true" @endif
            @if ($required) aria-required="true" @endif
            {{ $attributes->except(['id', 'name', 'type', 'placeholder', 'value', 'class']) }} />

        {{-- Trailing Icon or Error Icon --}}
        @if ($hasError)
            <span class="input-icon input-icon--end input-icon--error" aria-hidden="true">
                @svg('icons.x-circle', 'input-icon-svg')
            </span>
        @elseif($iconEnd)
            <span class="input-icon input-icon--end" aria-hidden="true">
                @svg('icons.' . $iconEnd, 'input-icon-svg')
            </span>
        @endif
    </div>

    {{-- Error Message --}}
    @if ($hasError || $error)
        <div id="error-{{ $inputId }}" class="input-message input-message--error">
            {{ $error ?? $errors->first($name) }}
        </div>
    @endif

    {{-- Helper/Hint Text --}}
    @if ($helper && !$hasError)
        <div id="{{ $helperId }}" class="input-message input-message--helper">
            {{ $helper }}
        </div>
    @endif
</div>
