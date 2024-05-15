@php
@endphp
<div class="{{ $attributes['class'] }}" {{ $attributes }}>
    {{-- <div class="flex flex-nowrap items-center justify-between mb-[18px] "> --}}
    @if (@$title)
        @if ($title->attributes["href"])
            <a class=" uppercase font-title text-xl lg:text-5xl{{ $title->attributes['class'] }}" {{ $title->attributes }} style="background: linear-gradient(180deg, #FF7200 62.81%, rgba(255, 114, 0, 0) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-fill-color: transparent;">
                {{ $title }}
            </a>
        @else
            <span class=" uppercase font-title text-xl lg:text-5xl {{ $title->attributes['class'] }}" {{ $title->attributes }} style="background: linear-gradient(180deg, #FF7200 62.81%, rgba(255, 114, 0, 0) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-fill-color: transparent;">
                {{ $title }}
            </span>  
        @endif
    @endif

    @if (@$desc)
        <div class="text-sm my-7 {{ $desc->attributes['class'] }}" {{ $desc->attributes }}>
            {{ $desc }}
        </div>
    @endif
    
    {{-- @if (@$readmore)
        <div class="flex justify-end flex-shrink-0 min-w-0 md:flex-1">
            <a class="text-sm md:text-lg md:font-medium inline-block text-secondary {{ $readmore->attributes['class'] }}" {{ $readmore->attributes }}>
                {{ $readmore }}
                <i class="ml-2 fas fa-chevron-right " ></i>
            </a>
        </div>
    @endif
    </div> --}}

    @if (@$icon)
        <img src="{{ asset('img/idx-tit.png') }}" class="{{ $icon->attributes['class'] }}" {{ $icon->attributes }} alt="icon" >
    @endif
</div>