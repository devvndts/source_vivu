@extends('desktop.master')
@php
    $tai_chinh_meta = get_static('tai-chinh-meta', $lang);
    $bat_dong_san_meta = get_static('bat-dong-san-meta', $lang);
@endphp
@section('content')
    <div class="relative">
        <div
            class="bg-[url('../images/dichvu.png')] bg-no-repeat bg-[length:100%_auto] bg-top left-0 top-0  h-full w-full absolute z-0">
        </div>
        <div class="relative z-10 py-6 about-gioithieu">
            <div class="container max-w-screen-xl">
                <div class="flex items-start justify-between mb-6 flex-nowrap">
                    <div class="font-bold w-[38%] text-[64px] text-black">{{ $row_detail["ten$lang"] ?? '' }}</div>
                    <figure>
                        @php
                            $img = Thumb::Crop(UPLOAD_STATICPOST, $row_detail['photo'], 700, 570, 1);
                        @endphp
                        <x-shared.image class="w-full" src="{{ $img }}" />
                    </figure>
                </div>
            </div>
        </div>
        @php
            $name = $bat_dong_san_meta->{"ten$lang"} ?? '';
            $desc = $bat_dong_san_meta->{"mota$lang"} ?? '';
            $gal = get_galleries($bat_dong_san_meta->type, $lang, ["query" => ["id_photo" => $bat_dong_san_meta->id]]);
        @endphp
        <div class="relative z-10 py-6 bat-dong-san-tai-chinh">
            <div class="absolute left-0 z-20 w-full top-12">
                <div class="container max-w-screen-xl">
                    <div class="flex justify-end pr-20">
                        <div class="font-bold shadow-[10px_10px_40px_rgba(0,0,0,0.1)] py-6 bg-white px-24 inline-block text-[32px] text-primary-500">
                            {{ $name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container relative z-10 max-w-screen-xl">
                <div class="flex items-end justify-between mb-6 flex-nowrap">
                    <div class="w-[61%]">
                        <div class="mb-2 swiper mySwiper2">
                            <div class="swiper-wrapper">
                                @foreach ($gal as $item)
                                    @php
                                    $imgLarge = UPLOAD_STATICPOST .$item->photo;
                                    $img = Thumb::Crop(UPLOAD_STATICPOST, $item->photo, 700, 530, 1, null, 'png');
                                    @endphp
                                    <div class="swiper-slide">
                                        <x-shared.image src="{{ $img }}" />
                                        <a href="{{ $imgLarge }}" class="inline-flex items-center justify-center w-[50px] bg-white absolute bottom-0 right-0 h-[50px] outline-none shadow-none " data-fancybox="gallerybds">
                                            <i class="text-xl text-black fas fa-search"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="w-[80%]">
                                <div thumbsSlider="" class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($gal as $item)
                                            @php
                                            $img = Thumb::Crop(UPLOAD_STATICPOST, $item->photo, 700, 530, 1, null, 'png');
                                            @endphp
                                            <div class="swiper-slide">
                                                <x-shared.image src="{{ $img }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-end justify-end flex-1 min-w-0">
                                <div
                                    class="swiper-bat-dong-san-meta-button-prev inline-flex items-center justify-center border border-[#999] transition-all duration-300 text-[#999] hover:border-[#111] hover:text-[#111] w-8 h-8">
                                    <i class="far fa-chevron-left"></i>
                                </div>
                                <div
                                    class="swiper-bat-dong-san-meta-button-next ml-[10px] inline-flex items-center justify-center border transition-all duration-300 border-[#999] text-[#999] hover:border-[#111] hover:text-[#111] w-8 h-8">
                                    <i class="far fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-[35%] [&_p]:mb-3">
                        {!! $desc !!}
                    </div>
                </div>
            </div>
        </div>
        @php
            $name = $tai_chinh_meta->{"ten$lang"} ?? '';
            $desc = $tai_chinh_meta->{"mota$lang"} ?? '';
            $gal = get_galleries($tai_chinh_meta->type, $lang, ["query" => ["id_photo" => $tai_chinh_meta->id]]);
        @endphp
        <div class="relative z-10 py-6 bat-dong-san-tai-chinh">
            <div class="absolute left-0 z-20 w-full top-12">
                <div class="container max-w-screen-xl">
                    <div class="flex pl-20">
                        <div class="font-bold shadow-[10px_10px_40px_rgba(0,0,0,0.1)] py-6 bg-white px-24 inline-block text-[32px] text-primary-500">
                            {{ $name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container relative z-10 max-w-screen-xl">
                <div class="flex items-end justify-between mb-6 flex-nowrap">
                    <div class="w-[61%] order-2">
                        <div class="mb-2 swiper mySwiperTaiChinh2">
                            <div class="swiper-wrapper">
                                @foreach ($gal as $item)
                                    @php
                                    $imgLarge = UPLOAD_STATICPOST .$item->photo;
                                    $img = Thumb::Crop(UPLOAD_STATICPOST, $item->photo, 700, 530, 1, null, 'png');
                                    @endphp
                                    <div class="swiper-slide">
                                        <x-shared.image src="{{ $img }}" />
                                        <a href="{{ $imgLarge }}" class="inline-flex items-center justify-center w-[50px] bg-white absolute bottom-0 right-0 h-[50px] outline-none shadow-none " data-fancybox="gallerytaichinh">
                                            <i class="text-xl text-black fas fa-search"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="w-[80%]">
                                <div thumbsSlider="" class="swiper mySwiperTaiChinh">
                                    <div class="swiper-wrapper">
                                        @foreach ($gal as $item)
                                            @php
                                            $img = Thumb::Crop(UPLOAD_STATICPOST, $item->photo, 700, 530, 1, null, 'png');
                                            @endphp
                                            <div class="swiper-slide">
                                                <x-shared.image src="{{ $img }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-end justify-end flex-1 min-w-0">
                                <div
                                    class="swiper-tai-chinh-meta-button-prev inline-flex items-center justify-center border border-[#999] transition-all duration-300 text-[#999] hover:border-[#111] hover:text-[#111] w-8 h-8">
                                    <i class="far fa-chevron-left"></i>
                                </div>
                                <div
                                    class="swiper-tai-chinh-meta-button-next ml-[10px] inline-flex items-center justify-center border transition-all duration-300 border-[#999] text-[#999] hover:border-[#111] hover:text-[#111] w-8 h-8">
                                    <i class="far fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-[35%] [&_p]:mb-3">
                        {!! $desc !!}
                    </div>
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
    <script>
        $(document).ready(function() {
            var swiper = new Swiper(".mySwiper", {
                loop: false,
                spaceBetween: 10,
                slidesPerView: 3,
                freeMode: true,
                watchSlidesProgress: true,
            });
            var swiper2 = new Swiper(".mySwiper2", {
                loop: false,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-bat-dong-san-meta-button-next",
                    prevEl: ".swiper-bat-dong-san-meta-button-prev",
                },
                thumbs: {
                    swiper: swiper,
                },
            });

            var swiperTaiChinh = new Swiper(".mySwiperTaiChinh", {
                loop: false,
                spaceBetween: 10,
                slidesPerView: 3,
                freeMode: true,
                watchSlidesProgress: true,
            });
            var swiperTaiChinh2 = new Swiper(".mySwiperTaiChinh2", {
                loop: false,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-tai-chinh-meta-button-next",
                    prevEl: ".swiper-tai-chinh-meta-button-prev",
                },
                thumbs: {
                    swiper: swiperTaiChinh,
                },
            });
        });
    </script>
@endpush

@isset($row_detail)
    @push('strucdata')
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "NewsArticle",
                "mainEntityOfPage":
                {
                    "@type": "WebPage",
                    "@id": "https://google.com/article"
                },
                "headline": "{!!$row_detail['ten'.$lang]!!}",
                "image":
                [
                    "{{ (isset($row_detail['photo']))?url('/').'/'.UPLOAD_STATICPOST.$row_detail['photo']:'' }}"
                ],
                "datePublished": "{{date('Y-m-d',$row_detail['ngaytao'])}}",
                "dateModified": "{{date('Y-m-d',$row_detail['ngaysua'])}}",
                "author":
                {
                    "@type": "Person",
                    "name": "{!!$setting['ten'.$lang]!!}",
                    "url": "{{url()->current()}}"
                },
                "publisher":
                {
                    "@type": "Organization",
                    "name": "Google",
                    "logo":
                    {
                        "@type": "ImageObject",
                        "url": "{{ (isset($logo))?url('/').'/'.UPLOAD_PHOTO.$logo['photo']:'' }}"
                    }
                },
                "description": "{{SEOMeta::getDescription()}}"
            }
        </script>
    @endpush
@endisset
