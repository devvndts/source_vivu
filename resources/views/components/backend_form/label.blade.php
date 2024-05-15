@props([
    'isInlineBlock' => false,
])
@php
    $blockClass = ($isInlineBlock) ? 'd-inline-block' : 'd-block';
@endphp
<label class="{{ $blockClass }} 
    {{ $attributes->get("class") }}" 
    {{ $attributes }}>
        {{ $slot }}
</label>