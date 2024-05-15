@props([
    'title' => __('Learn more'),
    ])
@if ($attributes["href"])
    <a class="inline-flex  duration-300 font-bold text-lg lg:text-lg text-primary  items-center lg:py-4 lg:px-11 p-2 transition-all {{ $attributes->get('class') }}" {{ $attributes }}>
        {{ $title }}
        @isset($icon)
        <span class="material-icons flex items-center justify-center w-12 h-12 rounded-full bg-primary text-white ml-4 {{ $icon->attributes->get('class') }}" {{ $icon->attributes }}>
            trending_flat
            </span>
        @endisset
    </a>
@endif