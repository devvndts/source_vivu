@props(['type' => 'danger'])

@php
$availableClasses = [
    'danger' => 'alert alert-danger',
];
if (array_key_exists($type, $availableClasses)) {
    $class = $availableClasses[$type];
} else {
    $class = $availableClasses['danger'];
}
@endphp

<p class="mt-2 {{ $class }} {{ $attributes["class"] }}" 
{{ $attributes }}>
    {{ $slot }}
</p>