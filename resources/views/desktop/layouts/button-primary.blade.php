@php
$title = (@$data["title"]) ? $data["title"] : __('site.readmore'); 
$class = (@$data["class"]) ? $data["class"] : ''; 
$link = (@$data["link"]) ? $data["link"] : ''; 
$icon = (@$data["icon"]) ? $data["icon"] : true; 
@endphp

@if ($link)
<a href="{!! $link !!}" class="{!! $class !!} btn border-[#815030] text-[#815030] text-lg">
    {!! $title !!} 
    @if ($icon)
    <i class="fal fa-long-arrow-right ml-7"></i>
    @endif 
</a>
@else
<span class="{!! $class !!} btn border-[#815030] text-[#815030] text-lg">
    {!! $title !!} 
    @if ($icon)
    <i class="fal fa-long-arrow-right ml-7"></i>
    @endif 
</span>  
@endif