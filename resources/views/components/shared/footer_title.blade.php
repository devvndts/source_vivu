@props(['title'])

@if (!empty($title))
<div class="mb-11 text-xl font-semibold capitalize text-white {{ $attributes->get('class') }}" {{ $attributes }}>
    {{ $title }}
    {{ $slot }}
</div>
@endif