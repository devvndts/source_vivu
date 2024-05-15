<div class="grid grid-cols-2 gap-4 lg:grid-cols-3 lg:gap-5 
[body.view-list_&]:grid-cols-1 lg:[body.view-list_&]:grid-cols-1
{{ $attributes->get("class") }}" 
    {{ $attributes }} >
    {{ $slot }}
</div>