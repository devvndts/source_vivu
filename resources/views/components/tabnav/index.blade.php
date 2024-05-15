@props([
    'tabId' => 'tabs-tab',
    ])
<ul class="nav nav-tabs flex flex-col flex-wrap list-none border-b-0 pl-0 mr-4 {{ $attributes->get('class') }}" {{ $attributes }} id="{{ $tabId }}Vertical"
    role="tablist">
    {{ $slot }}
</ul>