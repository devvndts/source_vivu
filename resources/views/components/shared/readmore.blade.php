@props([
    'title' => __('Xem thêm'),
    ])
@php
@endphp
@if ($attributes["href"])
    <a class="inline-flex border border-primary bg-gradient-to-br from-orange-500 to-orange-600 bg-gradient-radial duration-300 text-xs lg:text-sm text-white  hover:text-white  items-center rounded-[50px] lg:py-4 lg:px-5 p-2 transition-all {{ $attributes->get('class') }}" {{ $attributes }}>
        {{ $title }}
        @isset($icon)
        <span class="material-icons ml-3 {{ $icon->attributes->get('class') }}" {{ $icon->attributes }}>
            trending_flat
            </span>
        @endisset
    </a>
@else
    <span class="inline-flex border border-primary bg-gradient-to-br from-orange-500 to-orange-600 bg-gradient-radial duration-300 text-xs lg:text-sm text-white  items-center rounded-[50px] lg:py-4 lg:px-11 p-2  transition-all {{ $attributes->get('class') }}" {{ $attributes }}>
        {{ $title }}
        @isset($icon)
        <span class="material-icons ml-3 {{ $icon->attributes->get('class') }}" {{ $icon->attributes }}>
            trending_flat
            </span>
        @endisset
    </span>  
@endif