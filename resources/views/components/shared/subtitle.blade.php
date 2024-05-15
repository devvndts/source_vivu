@props(['title'])

@if (!empty($title))
<div class="text-2xl font-title md:text-3xl text-primary text-center uppercase my-5 {{ $attributes->get('class') }}" {{ $attributes }}>
    {{ $title }}
    {{ $slot }}
</div>
@endif