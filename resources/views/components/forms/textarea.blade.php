@props([
    'name' => '',
    'id' => '',
    'rows' => 3,
])

@php
    $idValue = (!empty($id)) ? $id : $name;
@endphp
<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
        {{ $attributes->get('class') }}    
    "
    {{ $attributes }}
>{{ old($name, $slot) }}</textarea>
