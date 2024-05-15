@props([
    'tabId' => '',
    'parentClass' => '',
    'active' => false
    ])
@php
$activeClass = ($active) ? 'active' : '';
@endphp
<li class="nav-item flex-grow {{ $parentClass ?? '' }}" role="presentation">
    <a href="#{{ $tabId }}Vertical" class="
        nav-link
        block
        font-medium
        text-xs
        leading-tight
        border-x-0 border-t-0 border-b-2 border-transparent
        px-6
        py-3
        my-2
        hover:border-transparent hover:bg-gray-100
        focus:border-transparent
        {{ $activeClass }}
        {{ $attributes->get('class') }}" {{ $attributes }} id="{{ $tabId }}-tabVertical" data-bs-toggle="pill" data-bs-target="#{{ $tabId }}Vertical" role="tab"
        aria-controls="{{ $tabId }}Vertical" aria-selected="true">
        {{ $slot }}
    </a>
</li>