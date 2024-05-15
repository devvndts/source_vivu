@props([
    'isChecked' => false,
])
<input class="form-control
        {{ $attributes->get('class') }}"
        {{ $isChecked ? 'checked' : '' }}
    {{ $attributes }} />

