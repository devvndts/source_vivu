@props([
    'width' => '50',
    'height' => '50',
    'isShowWidth' => false,
    ])
@php
    $str = $attributes->get('src');
	$pattern = "/\d+x\d+x\d+/i";
	if (preg_match($pattern, $str, $matches)) {
        $thumbAttr = explode("x", $matches[0]);
        $width = $thumbAttr[0];
        $height = $thumbAttr[1];
    } else {
        $array = @getimagesize($str);
        if($array) list($width, $height, $type, $attr) = $array;
    }
@endphp

<img {{ $attributes }} 
    onerror="this.onerror=null; this.src='{{ asset('img/noimage.png') }}';"
    @if ($isShowWidth)
        width="{{ $width }}" 
        height="{{ $height }}"
    @endif
    >