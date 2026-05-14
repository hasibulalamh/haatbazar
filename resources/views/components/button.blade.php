@props([
    'variant' => 'primary', // primary, secondary, ghost, text
    'size' => 'md', // sm, md, lg
    'type' => 'button', // button, submit, reset
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconEnd' => null,
])

<button type="{{ $type }}" @disabled($disabled || $loading) @class([
    'button',
    'button--' . $variant,
    'button--' . $size,
    'button--loading' => $loading,
    'button--disabled' => $disabled || $loading,
    $attributes->get('class'),
])
    aria-busy="{{ $loading ? 'true' : 'false' }}" {{ $attributes->except('class') }}>
    @if ($icon)
        <span class="button__icon button__icon--start" aria-hidden="true">
            @svg('icons.' . $icon, 'button__icon-svg')
        </span>
    @endif

    <span class="button__text">
        {{ $slot }}
    </span>

    @if ($loading)
        <span class="button__spinner" aria-hidden="true">
            <svg class="button__spinner-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" opacity="0.25"></circle>
                <path d="M12 2a10 10 0 0 1 10 10" opacity="1"></path>
            </svg>
        </span>
    @elseif($iconEnd)
        <span class="button__icon button__icon--end" aria-hidden="true">
            @svg('icons.' . $iconEnd, 'button__icon-svg')
        </span>
    @endif
</button>
