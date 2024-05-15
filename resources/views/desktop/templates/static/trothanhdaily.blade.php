@extends('desktop.master')
@php
    // $tam_nhin = get_posts('tin-tuc', $lang, ['order_by' => ['stt' => 'asc']]);
    // $su_menh = get_posts('tin-tuc', $lang, ['order_by' => ['stt' => 'asc']]);
    if ($row_detail) {
        $name = $row_detail["ten$lang"] ?? '';
        $desc = $row_detail["mota$lang"] ?? '';
        $photo = $row_detail["photo"] ?? '';
        $photo2 = $row_detail["photo2"] ?? '';
        $typeQuytrinh = sprintf('quy-trinh-%s', $row_detail["type"]);
        $typePost = sprintf('post-%s', $row_detail["type"]);
        $quytrinh = get_posts($typeQuytrinh, $lang, ['order_by' => ['stt' => 'asc']]);
        $postsOfPage = get_posts($typePost, $lang, ['order_by' => ['stt' => 'asc']]);
    }
@endphp
@section('content')
<div class="relative bg-no-repeat bg-cover aspect-w-16 aspect-h-6" style="background-image: url('{{ UPLOAD_STATICPOST . $photo }}')">
    <div class="flex items-center justify-center text-2xl md:text-4xl">{{ $name }}</div>
</div>
<div class="container max-w-screen-xl mb-5">
    <div class="flex flex-wrap justify-between my-5 md:flex-nowrap">
        <figure class="w-full mb-4 md:mb-0 md:w-[48%]">
            <x-shared.image src="{{ UPLOAD_STATICPOST . $photo2 }}" />
        </figure>
        <div class="w-full md:w-[48%]">
            {!! $desc !!}
        </div>
    </div>
    @if ($quytrinh)
    <div class="flex flex-wrap justify-center my-5 text-center md:flex-nowrap">
        @foreach ($quytrinh as $item)
            @php
                $name = $item->{'ten'.$lang} ?? '';
				$desc = $item->{'mota'.$lang} ?? '';
				$img = Thumb::Crop(UPLOAD_POST, $item->photo, 400, 400, 1, null, 'png');
            @endphp
            <div class="w-full md:w-[30%] mx-[1%]">
                <figure class="mx-auto mb-3">
                    <x-shared.image class="mx-auto w-[150px]" src="{{ $img }}" />
                </figure>
                <div class="font-bold">
                    {!! $name !!}
                </div>
                <div class="">
                    {!! $desc !!}
                </div>
            </div>
        @endforeach
    </div>
    @endif

    @if ($postsOfPage)
    
        @foreach ($postsOfPage as $item)
            @php
                $name = $item->{'ten'.$lang} ?? '';
                $url = url($item->{$sluglang} ?? '');
				$desc = $item->{'mota'.$lang} ?? '';
				$img = Thumb::Crop(UPLOAD_POST, $item->photo, 600, 400, 1, null, 'png');
            @endphp
            <div class="flex flex-wrap justify-between gap-5 my-5 md:flex-nowrap group">
                <figure class="w-full mb-3 md:w-1/2 md:group-even:order-2">
                    <x-shared.image class="w-full" src="{{ $img }}" />
                </figure>
                <div class="w-full md:w-1/2">
                    <div class="text-3xl font-bold">
                        {!! $name !!}
                    </div>
                    <div class="">
                        {!! $desc !!}
                    </div>
                    <x-shared.readmore class="mt-4" href="{{ $url }}" />
                </div>
            </div>
        @endforeach
    
    @endif
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')

@endpush

@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush