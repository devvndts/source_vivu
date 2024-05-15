@if ($slot->isNotEmpty())
<div class="content-main {{ $attributes->get('class') }}" {{ $attributes }}>
    {{ $slot }}
</div>
@endif