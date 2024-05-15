@php
$title = (@$data["title"]) ? $data["title"] : ''; 
$desc = (@$data["desc"]) ? $data["desc"] : ''; 
$link = (@$data["link"]) ? $data["link"] : ''; 
$html = (@$data["html"]) ? $data["html"] : ''; 
$icon = (@$data["icon"]) ? $data["icon"] : false; 
$class = (@$data["class"]) ? $data["class"] : ''; 
$classIcon = (@$data["class_icon"]) ? $data["class_icon"] : ''; 
$classTitle = (@$data["class_title"]) ? $data["class_title"] : ''; 
$classDesc = (@$data["class_desc"]) ? $data["class_desc"] : ''; 
@endphp
<div class="mb-8 {{ $class }}">
    @if($title && $link)
        <a href="{{ $link }}" class="font-bold text-xl lg:text-[36px] leading-10 uppercase text-center {{ $classTitle }}">{!! $title !!}</a>
    @elseif ($title)
        <div class="font-bold text-xl lg:text-[36px] leading-10 uppercase text-center {{ $classTitle }}">{!! $title !!}</div>
    @endif

    {!! $html !!}

    @if($icon)
    <img src="{{ asset('img/idx-tit.png') }}" class="max-w-[190px] lg:max-w-none mx-auto {{ $classIcon }}" alt="icon"> 
    @endif

    @if($desc)
    <div class="max-w-3xl mx-auto mt-2 text-sm text-center {{ $classDesc }}">{!! $desc !!}</div>
    @endif
</div>