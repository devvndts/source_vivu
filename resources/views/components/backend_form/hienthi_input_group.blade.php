@props([
    'isChecked' => false,
])
<div class="align-middle custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input hienthi-checkbox {{ $attributes->get('class') }}" 
    {{ $isChecked ? 'checked' : '' }}
    {{ $attributes }} />
    <label for="hienthi-checkbox" class="custom-control-label"></label>
</div>
