@php
    /*
    selectedIds : array
    */
@endphp
@props([
    'data' => null,
    'selectedIds' => null,
])
<select class="form-control
    {{ $attributes->get('class') }}"
    {{ $attributes }}>
    @if ($data)
        @foreach ($data as $key => $item)
            @php
                $selected = $selectedIds && in_array($item["value"], $selectedIds) ? 'selected' : '';
            @endphp
            <option value="{{ $item["value"] }}" {{ $selected }} >{{ $item["title"] }}</option>
        @endforeach        
    @endif
</select>