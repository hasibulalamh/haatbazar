@props([
    'name' => '',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'maxlength' => null,
    'autosize' => false,
    'error' => null,
    'helper' => null,
    'disabled' => false,
    'readonly' => false,
])

@php
    $textareaId = $attributes->get('id', 'textarea-' . uniqid());
    $hasError = $error || $errors->has($name);
    $helperId = 'helper-' . $textareaId;
    $counterId = 'counter-' . $textareaId;
    $describedBy = [];

    if ($hasError || $error) {
        $describedBy[] = 'error-' . $textareaId;
    }
    if ($helper) {
        $describedBy[] = $helperId;
    }
    if ($maxlength) {
        $describedBy[] = $counterId;
    }
@endphp

<div class="textarea-group">
    @if ($label)
        <label for="{{ $textareaId }}" class="textarea-label">
            {{ $label }}
        </label>
    @endif

    <textarea id="{{ $textareaId }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        @disabled($disabled) @readonly($readonly)
        @if ($maxlength) maxlength="{{ $maxlength }}" @endif @class([
            'textarea',
            'textarea--error' => $hasError,
            'textarea--autosize' => $autosize,
        ])
        @if (count($describedBy) > 0) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
        @if ($hasError || $error) aria-invalid="true" @endif
        @if ($maxlength) data-maxlength="{{ $maxlength }}" @endif
        {{ $attributes->except(['id', 'name', 'rows', 'placeholder', 'class']) }}>{{ old($name, $value) }}</textarea>

    @if ($hasError || $error)
        <div id="error-{{ $textareaId }}" class="textarea-message textarea-message--error">
            {{ $error ?? $errors->first($name) }}
        </div>
    @endif

    @if ($helper && !$hasError)
        <div id="{{ $helperId }}" class="textarea-message textarea-message--helper">
            {{ $helper }}
        </div>
    @endif

    @if ($maxlength)
        <div id="{{ $counterId }}" class="textarea-counter">
            <span class="textarea-counter-current">0</span> / {{ $maxlength }}
        </div>
    @endif
</div>

@if ($autosize || $maxlength)
    <script>
        document.getElementById('{{ $textareaId }}')?.addEventListener('input', function() {
            @if ($autosize)
                this.style.height = 'auto';
                this.style.height = Math.max(this.scrollHeight, {{ 44 * $rows }}) + 'px';
            @endif

            @if ($maxlength)
                const counter = document.getElementById('{{ $counterId }}');
                if (counter) {
                    const current = this.value.length;
                    const max = {{ $maxlength }};
                    counter.querySelector('.textarea-counter-current').textContent = current;

                    if (current >= max * 0.8) {
                        counter.classList.add('textarea-counter--warning');
                    } else {
                        counter.classList.remove('textarea-counter--warning');
                    }
                }
            @endif
        });
    </script>
@endif
