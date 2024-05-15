@props([
    'target' => '',
    'title' => '',
    ])
<div class="border-b ">
    <div data-bs-toggle="collapse" aria-expanded="false" {{ $attributes }}
    class="flex py-3  px-0 items-center justify-between collapsed bg-white bg-opacity-10 [&:not(.collapsed)_.plug]:hidden [&:not(.collapsed)]:bg-opacity-20 [&:not(.collapsed)]:bg-white cursor-pointer [&.collapsed_span+span]:bg-opacity-10 [&.collapsed_span+span]:bg-white [&:not(.collapsed)_span+span]:bg-white [&:not(.collapsed)_span+span]:bg-opacity-100 {{ $attributes->get("class") }}" 
    data-bs-target="#{{ $target }}" 
    aria-controls="{{ $target }}">
        <span class="flex-1 text-sm font-medium text-primary">{{ $title }}</span>
        <span class="flex-shrink-0 text-2xl font-normal inline-flex items-center justify-center cursor-pointer text-primary [.collapsed_&]:text-primary rounded-full w-9 h-9  ">
            <i class="plug">+</i>
            <i class=" [.collapsed_&]:hidden">-</i>
        </span>
    </div>
    <div class="px-0 py-3 bg-white border-0 accordion-collapse collapse bg-opacity-20 " id="{{ $target }}">
        @if ($slot->isNotEmpty())
        <div class="prose-sm text-black content-main text-opacity-70">
            {{ $slot }}
        </div>
        @endif
    </div>
</div> 