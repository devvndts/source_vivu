@props([
    'data' => null,
    'loai' => 'hienthi',
    ])
@php
    $isChecked = (isset($data[$loai]) && $data[$loai]) ? 'checked' : ''; 
@endphp
<td class="text-center align-middle dev-item-display show-checkbox">
    <div class="custom-control custom-checkbox my-checkbox">
        <input type="checkbox" class="custom-control-input" data-model="{{ $data['model'] }}"
            data-level="{{ $data['level'] }}" data-id="{{ $data['id'] }}" 
            data-loai="{{ $loai }}"
            {{ $isChecked }}>
        <label for="show-checkbox-{{ $data['id'] }}"
            class="custom-control-label"></label>
    </div>
</td>