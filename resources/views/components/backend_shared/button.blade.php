@props(['type' => 'primary'])

@php
$availableClasses = [
    'primary' => 'bg-gradient-primary',
    'danger' => 'bg-gradient-danger',
];
if (array_key_exists($type, $availableClasses)) {
    $class = $availableClasses[$type];
} else {
    $class = $availableClasses['primary'];
}
@endphp

<a class="text-white btn btn-sm bg-gradient-primary {{ $class }} {{ $attributes["class"] }}" 
    {{ $attributes }} >
    {{ $slot }}
</a>
