@props([
    'name' => '',
    'label' => null,
    'options' => [],
    'value' => null,
    'disabled' => false,
    'error' => null,
    'helper' => null,
])

@php
    $selectId = $attributes->get('id', 'select-' . uniqid());
    $hasError = $error || $errors->has($name);
    $helperId = 'helper-' . $selectId;
    $describedBy = [];

    if ($hasError || $error) {
        $describedBy[] = 'error-' . $selectId;
    }
    if ($helper) {
        $describedBy[] = $helperId;
    }

    $selectedOption = null;
    foreach ($options as $option) {
        if ($option['value'] == old($name, $value)) {
            $selectedOption = $option;
            break;
        }
    }
@endphp

<div class="select-group">
    @if ($label)
        <label for="{{ $selectId }}" class="select-label">
            {{ $label }}
        </label>
    @endif

    <div class="select-wrapper">
        <button type="button" id="{{ $selectId }}" @disabled($disabled) @class([
            'select-trigger',
            'select-trigger--error' => $hasError,
            'select-trigger--open' => false,
        ])
            aria-haspopup="listbox" aria-expanded="false"
            @if (count($describedBy) > 0) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
            @if ($hasError || $error) aria-invalid="true" @endif x-data="selectComponent()" @click="toggle()"
            @keydown.escape="close()" @keydown.arrow-down.prevent="selectNext()"
            @keydown.arrow-up.prevent="selectPrev()" @keydown.enter.prevent="selectCurrent()"
            @keydown.space.prevent="selectCurrent()">
            <span class="select-value">
                {{ $selectedOption['label'] ?? 'Select...' }}
            </span>
            <svg class="select-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>

        <ul class="select-options" role="listbox" hidden>
            @foreach ($options as $option)
                <li role="option" class="select-option" x-data @click="selectOption('{{ $option['value'] }}')"
                    @keydown.enter.prevent="selectOption('{{ $option['value'] }}')"
                    @keydown.space.prevent="selectOption('{{ $option['value'] }}')">
                    {{ $option['label'] }}
                </li>
            @endforeach
        </ul>

        <select name="{{ $name }}" class="select-native" hidden>
            @foreach ($options as $option)
                <option value="{{ $option['value'] }}" @selected(old($name, $value) == $option['value'])>
                    {{ $option['label'] }}
                </option>
            @endforeach
        </select>
    </div>

    @if ($hasError || $error)
        <div id="error-{{ $selectId }}" class="select-message select-message--error">
            {{ $error ?? $errors->first($name) }}
        </div>
    @endif

    @if ($helper && !$hasError)
        <div id="{{ $helperId }}" class="select-message select-message--helper">
            {{ $helper }}
        </div>
    @endif
</div>

<script>
    function selectComponent() {
        return {
            isOpen: false,
            currentIndex: 0,
            toggle() {
                this.isOpen ? this.close() : this.open();
            },
            open() {
                this.isOpen = true;
                this.$nextTick(() => {
                    this.$el.nextElementSibling?.removeAttribute('hidden');
                });
            },
            close() {
                this.isOpen = false;
                this.$nextTick(() => {
                    this.$el.nextElementSibling?.setAttribute('hidden', '');
                });
            },
            selectNext() {
                const options = this.$el.nextElementSibling?.querySelectorAll('[role="option"]') || [];
                this.currentIndex = Math.min(this.currentIndex + 1, options.length - 1);
                options[this.currentIndex]?.focus();
            },
            selectPrev() {
                const options = this.$el.nextElementSibling?.querySelectorAll('[role="option"]') || [];
                this.currentIndex = Math.max(this.currentIndex - 1, 0);
                options[this.currentIndex]?.focus();
            },
            selectCurrent() {
                const options = this.$el.nextElementSibling?.querySelectorAll('[role="option"]') || [];
                options[this.currentIndex]?.click();
            },
            selectOption(value) {
                const nativeSelect = this.$el.parentElement?.querySelector('select');
                if (nativeSelect) {
                    nativeSelect.value = value;
                    nativeSelect.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
                const trigger = this.$el;
                const option = Array.from(this.$el.nextElementSibling?.querySelectorAll('[role="option"]') || [])
                    .find(opt => opt.dataset.value === value);
                if (option && trigger) {
                    trigger.querySelector('.select-value').textContent = option.textContent;
                }
                this.close();
            },
        };
    }
</script>
