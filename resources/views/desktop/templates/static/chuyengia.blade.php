@extends('desktop.master')
@section('content')
@php
    $doiNguChuyenGia = get_photos('doi-ngu-chuyen-gia', $lang, ["order_by" => ["stt" => "asc"]]);
    $banCoVan = get_photos('ban-co-van', $lang, ["order_by" => ["stt" => "asc"]]);
@endphp
<div class="doinguchuyengia " >
    <div class="container max-w-[1462px] ">
        <x-shared.title class="text-center mt-20" >
            <x-slot name="title" >{{ __('ĐỘI NGŨ CHUYÊN GIA') }}</x-slot>
        </x-shared.title>
        <div class="grid lg:grid-cols-6 md:grid-cols-3 grid-cols-2 gap-4 m-5">
            @foreach ($doiNguChuyenGia as $item)
                @php
                    $name = $item->{"ten".$lang} ?? '';
                    $description = $item->{"mota".$lang} ?? '';
                    $photo = $item->photo ?? '';
                    $img = Thumb::Crop(UPLOAD_PHOTO, $photo ?? '', 270, 370, 1);
                @endphp
                <div class="text-center group">
                    <div style="background-image: url({{ $img }})" class="aspect-w-2 relative aspect-h-3 bg-cover rounded-[10px] overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-full hover:bg-doingu bg-doingupre bg-no-repeat bg-cover transition-all duration-300 "></div>
                    </div>
                    <div class="mt-5 text-base group-hover:text-primary font-bold font-title">{{ $name }}</div>
                    <div class="text-sm">{{ $description }}</div>
                </div>
            @endforeach
        </div>
        <x-shared.title class="text-center mt-10" >
            <x-slot name="title" >{{ __('BAN CỐ VẤN') }}</x-slot>
        </x-shared.title>
        <div class="grid lg:grid-cols-6 md:grid-cols-3 grid-cols-2 gap-4 m-5">
            @foreach ($banCoVan as $item)
                @php
                    $name = $item->{"ten".$lang} ?? '';
                    $description = $item->{"mota".$lang} ?? '';
                    $photo = $item->photo ?? '';
                    $img = Thumb::Crop(UPLOAD_PHOTO, $photo ?? '', 270, 370, 1);
                @endphp
                <div class="text-center group">
                    <div style="background-image: url({{ $img }})" class="aspect-w-2 relative aspect-h-3 bg-cover rounded-[10px] overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-full hover:bg-doingu bg-doingupre bg-no-repeat bg-cover transition-all duration-300 "></div>
                    </div>
                    <div class="mt-5 text-base  group-hover:text-primary font-bold font-title">{{ $name }}</div>
                    <div class="text-sm">{{ $description }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

@push('js_page')
@endpush

@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush