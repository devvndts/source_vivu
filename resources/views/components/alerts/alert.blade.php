@php
    $class = "invalid-feedback";
    if ($type == "success") {
        $class = "valid-feedback";
    }
@endphp
<p {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</p>