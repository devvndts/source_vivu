@props([
    'btnClass' => 'btn-primary',
    'type' => 'button',
    'title' => 'Button',
    'isInput' => false,
    ])
@if ($isInput)
    <input type="{{ $type }}" class="
    inline-block
    px-6
    py-2.5
    font-medium
    text-xs
    leading-tight
    uppercase
    rounded
    shadow-md
    hover:shadow-lg
    focus:shadow-lg
    focus:outline-none
    focus:ring-0
    active:shadow-lg
    transition
    duration-150
    ease-in-out 
    {{ $btnClass }}
    {{ $attributes->get("class") }}" 
        {{ $attributes }} value="{{ $title }}" />
@else
    <button type="{{ $type }}" class="
    inline-block
    px-6
    py-2.5
    font-medium
    text-xs
    leading-tight
    uppercase
    rounded
    shadow-md
    hover:shadow-lg
    focus:shadow-lg
    focus:outline-none
    focus:ring-0
    active:shadow-lg
    transition
    duration-150
    ease-in-out 
    {{ $btnClass }}
    {{ $attributes->get("class") }}" 
        {{ $attributes }}>
        {{ $title }}
    </button>
@endif
