@props([
    'tabId' => '',
    'active' => false
    ])
@php
    $activeClass = ($active) ? 'show active' : '';
    // $tabId = (isset($tabId) && !empty($tabId)) ? $tabId : '';
@endphp
<div class="tab-pane fade {{ $activeClass }} {{ $attributes->get('class') }}" {{ $attributes }} id="{{ $tabId }}Vertical" role="tabpanel"
aria-labelledby="{{ $tabId }}-tabVertical">
{{ $slot }}
</div>