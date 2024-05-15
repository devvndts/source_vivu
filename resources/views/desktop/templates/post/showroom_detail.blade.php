@php
    $name = $row_detail["ten$lang"];
    $opt = ($row_detail["sl_options"]) ? Helper::JsonDecode($row_detail["sl_options"]) : null;
    $optToado = $opt["toado_iframe"] ?? '';
    $img = Thumb::Crop(UPLOAD_POST, $row_detail["photo"], 600, 600, 1);
@endphp
@extends('desktop.master')

@section('content')
<div class="container max-w-screen-xl pt-5 mb-5 ">
    <div class="md:flex justify-between">
        <div class="md:w-1/2 mb-5">
            <figure>
                <x-shared.image src="{{ $img }}" />
            </figure>
            <h3 class="my-5 text-2xl uppercase">{{ $name }}</h3>
            <x-shared.content>{!! $row_detail['noidung'.$lang] !!}</x-shared.content>
        </div>
        <div class="md:w-1/2 md:ml-5 mb-5">
            <div class="[&>iframe]:w-full">
                {!! $optToado !!}
            </div>
        </div>
    </div>
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
@endpush


@push('strucdata')
@endpush