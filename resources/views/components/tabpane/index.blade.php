@props([
    'tabId' => 'tabs-tab',
    ])
<div class="tab-content {{ $attributes->get('class') }}" {{ $attributes }} id="{{ $tabId }}ContentVertical">
    {{ $slot }}
</div>