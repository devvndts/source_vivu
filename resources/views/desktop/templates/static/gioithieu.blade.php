@extends('desktop.master')
@php
    $gioi_thieu_meta = get_static('gioi-thieu-meta', $lang);
    $gioi_thieu_sumenh = get_static('gioi-thieu-sumenh', $lang);
    $gioi_thieu_tamnhin = get_static('gioi-thieu-tamnhin', $lang);
    $gioi_thieu_meta_sl_options = Helper::jsonDecode($gioi_thieu_meta->sl_options ?? '');
    $gioi_thieu_meta_img = '';
    $gioi_thieu_tamnhin_img = '';
    $gioi_thieu_sumenh_img = '';
    if (isset($gioi_thieu_meta) && !empty($gioi_thieu_meta->photo)) {
        $gioi_thieu_meta_img = Thumb::Crop(UPLOAD_STATICPOST, $gioi_thieu_meta->photo, 600, 340, 1);
    }
    if (isset($gioi_thieu_sumenh) && !empty($gioi_thieu_sumenh->photo)) {
        $gioi_thieu_sumenh_img = Thumb::Crop(UPLOAD_STATICPOST, $gioi_thieu_sumenh->photo, 580, 550, 1);
    }
    if (isset($gioi_thieu_tamnhin) && !empty($gioi_thieu_tamnhin->photo)) {
        $gioi_thieu_tamnhin_img = Thumb::Crop(UPLOAD_STATICPOST, $gioi_thieu_tamnhin->photo, 660, 530, 1);
    }
    $chuyen_mon = get_photos('chuyen-mon', $lang, ['order_by' => ['stt' => 'asc']]);

    $text_visao = get_static('text-visao', $lang);
    $vi_sao = get_posts('vi-sao', $lang);
    $dich_vu_bat_dong_san = get_static('dich-vu-bat-dong-san', $lang);
    $dich_vu_tai_chinh = get_static('dich-vu-tai-chinh', $lang);
@endphp
@section('content')
    <div class="py-6 about-gioithieu">
        <div class="container max-w-screen-xl">
            <div class="">
                <div class="flex items-start justify-between mb-6 flex-nowrap">
                    <div class="font-bold w-1/2 text-[64px] text-black">{{ $row_detail["ten$lang"] ?? '' }}</div>
                    <hr class="flex-1 min-w-0 border-black mt-7">
                </div>
                <figure>
                    @php
                        $img = Thumb::Crop(UPLOAD_STATICPOST, $row_detail['photo'], 1170, 510, 1);
                    @endphp
                    <x-shared.image class="w-full" src="{{ $img }}" />
                </figure>
            </div>
        </div>
    </div>
    @php
        $name = $gioi_thieu_meta->{"ten$lang"} ?? '';
        $desc = $gioi_thieu_meta->{"mota$lang"} ?? '';
    @endphp
    <div class="py-6 about-meta">
        <div class="container max-w-screen-xl">
            <div class="flex items-start justify-between">
                <div class="order-2 w-1/2">
                    <a data-fancybox="whyvideo"
                        href="https://www.youtube.com/watch?v={{ Helper::GetYoutube($gioi_thieu_meta_sl_options['link_video'] ?? '') }}"
                        style="background-image: url('{{ $gioi_thieu_meta_img }}');"
                        class="block bg-center bg-no-repeat bg-cover aspect-w-6 aspect-h-3">
                        <span class="w-[60px] h-[60px] left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-cover absolute"
                            style="background-image: url('{{ asset('public/images/play.png') }}')"></span>
                    </a>
                </div>
                <div class="w-1/2">
                    <div class="inline-flex items-center mb-4 text-xl font-bold text-primary flex-nowrap">
                        <div class="w-[96px] -ml-[36px] h-[1px] bg-opacity-100 bg-primary mr-6"></div>
                        {{ $name }}</a>
                    </div>
                    <div class="[&_*]:text-sm [&_*]:mb-10 [&_*]:text-[#333] [&_*]:font-light max-w-[414px] ml-[85px]">
                        {!! $desc !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $name = $gioi_thieu_tamnhin->{"ten$lang"} ?? '';
        $desc = $gioi_thieu_tamnhin->{"mota$lang"} ?? '';
    @endphp
    <div class="py-6 about-tamnhin">
        <div class="container max-w-screen-xl">
            <div class="flex items-start justify-between">
                <div class="w-1/2 ">
                    <figure>
                        <x-shared.image src="{{ $gioi_thieu_tamnhin_img }}" class="w-full" />
                    </figure>
                </div>
                <div class="w-1/2">
                    <div class="inline-flex items-center mb-4 text-xl font-bold text-primary flex-nowrap">
                        <div class="w-[96px] -ml-[36px] h-[1px] bg-opacity-100 bg-primary mr-6"></div>
                        {{ $name }}</a>
                    </div>
                    <div class="[&_*]:text-sm [&_*]:mb-10 [&_*]:text-[#333] [&_*]:font-light max-w-[414px] ml-[85px]">
                        {!! $desc !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $name = $gioi_thieu_sumenh->{"ten$lang"} ?? '';
        $desc = $gioi_thieu_sumenh->{"mota$lang"} ?? '';
    @endphp
    <div class="py-6 about-sumenh">
        <div class="container max-w-screen-xl">
            <div class="flex items-start justify-between">
                <div class="order-2 w-1/2">
                    <figure>
                        <x-shared.image src="{{ $gioi_thieu_sumenh_img }}" class="w-full" />
                    </figure>
                </div>
                <div class="w-1/2">
                    <div class="inline-flex items-center mb-4 text-xl font-bold text-primary flex-nowrap">
                        <div class="w-[96px] -ml-[36px] h-[1px] bg-opacity-100 bg-primary mr-6"></div>
                        {{ $name }}</a>
                    </div>
                    <div class="[&_*]:text-sm [&_*]:mb-10 [&_*]:text-[#333] [&_*]:font-light max-w-[414px] ml-[85px]">
                        {!! $desc !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $text_visao_sl_options = Helper::jsonDecode($text_visao->sl_options);
    @endphp
    <div class="py-16 home-why">
        <div class="container max-w-screen-xl">
            <x-shared.title class="text-center">
                <x-slot name="desc">
                    {{ __('Tại Sao Chọn Chúng Tôi') }}
                </x-slot>
                <x-slot name="title">
                    {{ $text_visao->{"ten$lang"} }}
                </x-slot>
            </x-shared.title>
            <div class="flex items-start justify-between">
                <div class="w-1/2">
                    <a data-fancybox="whyvideo"
                        href="https://www.youtube.com/watch?v={{ Helper::GetYoutube($text_visao_sl_options['link_video']) }}"
                        style="background-image: url('{{ Thumb::Crop(UPLOAD_STATICPOST, $text_visao->photo, 600, 340, 1) }}');"
                        class="block bg-center bg-no-repeat bg-cover aspect-w-6 aspect-h-3">
                        <span class="w-[60px] h-[60px] left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-cover absolute"
                            style="background-image: url('{{ asset('public/images/play.png') }}')"></span>
                    </a>
                </div>
                <div class="relative mt-7 w-1/2 bg-white py-[15px] px-20 shadow-[0px_4px_70px_rgba(0,0,0,0.2)]">
                    <div class="absolute top-0 w-5 h-full bg-white -left-5"></div>
                    <div>
                        @foreach ($vi_sao as $item)
                            @php
                                $name = $item->{"ten$lang"};
                                $desc = $item->{"mota$lang"};
                                $img = Thumb::Crop(UPLOAD_POST, $item->photo, 50, 50, 2);
                            @endphp
                            <div class="flex justify-between my-[30px]">
                                <figure
                                    class="w-[50px] h-[50px] rounded-full bg-secondary-500 flex items-center justify-center">
                                    <x-shared.image src="{{ $img }}" />
                                </figure>
                                <div class="flex-1 ml-7">
                                    <div class="text-base font-medium text-[#111]">{{ $name }}</div>
                                    <div class="text-sm font-light text-[#111] line-clamp-2">{{ $desc }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative">
        <div class="bg-[url('../images/chuyenmon.png')] bg-no-repeat bg-[length:100%_auto] bg-top left-0 top-0  h-full w-full absolute z-0" ></div>
        <div class="relative py-16 home-our-service">
            <div class="bg-primary h-[380px] w-full left-0 top-0 z-0 absolute"></div>
            <div class="container relative z-20 max-w-screen-xl">
                <x-shared.title class="text-center">
                    <x-slot name="desc" class="text-secondary-500">
                        {{ __('Dịch Vụ Chúng Tôi') }}
                    </x-slot>
                    <x-slot name="title" class="text-white">
                        {{ __('Các Dịch Vụ Tại Meta Capital') }}
                    </x-slot>
                </x-shared.title>
                <div class="flex items-start justify-between">
                    @php
                        $name = $dich_vu_bat_dong_san->{"ten$lang"};
                        $desc = $dich_vu_bat_dong_san->{"mota$lang"};
                        $img = Thumb::Crop(UPLOAD_STATICPOST, $dich_vu_bat_dong_san->photo, 350, 330, 2);
                    @endphp
                    <div class="text-center w-full max-w-[360px]">
                        <figure>
                            <x-shared.image class="mx-auto" src="{{ $img }}" />
                        </figure>
                        <div class="font-medium my-3 text-[15px] text-[#111]">{{ $name }}</div>
                        <div class="font-light my-3 text-sm line-clamp-2 text-[#111]">{{ $desc }}</div>
                        <x-shared.readmore title="{{ __('Xem thêm chi tiết') }}" />
                    </div>
                    @php
                        $name = $dich_vu_tai_chinh->{"ten$lang"};
                        $desc = $dich_vu_tai_chinh->{"mota$lang"};
                        $img = Thumb::Crop(UPLOAD_STATICPOST, $dich_vu_tai_chinh->photo, 350, 330, 2);
                    @endphp
                    <div class="text-center w-full max-w-[360px]">
                        <figure>
                            <x-shared.image class="mx-auto" src="{{ $img }}" />
                        </figure>
                        <div class="font-medium my-3 text-[15px] text-[#111]">{{ $name }}</div>
                        <div class="font-light my-3 text-sm line-clamp-2 text-[#111]">{{ $desc }}</div>
                        <x-shared.readmore title="{{ __('Xem thêm chi tiết') }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="relative py-6 about-chuyenmon">
            {{-- <x-shared.image src="public/images/chuyenmon.png" class="absolute top-0 -translate-x-1/2 left-1/2" /> --}}
            
            <div class="container max-w-screen-xl">
                <div class="flex items-end justify-between">
                    <x-shared.title>
                        <x-slot name="desc">
                            {{ __('Chuyên Môn') }}
                        </x-slot>
                        <x-slot name="title">
                            {{ __('Chuyên Môn') }} Meta Capital
                        </x-slot>
                    </x-shared.title>
                    <div class="mb-9">
                        <div
                            class="swiper-chuyenmon-button-prev inline-flex items-center justify-center border border-[#999] transition-all duration-300 text-[#999] hover:border-[#111] hover:text-[#111] w-8 h-8">
                            <i class="far fa-chevron-left"></i>
                        </div>
                        <div
                            class="swiper-chuyenmon-button-next ml-[10px] inline-flex items-center justify-center border transition-all duration-300 border-[#999] text-[#999] hover:border-[#111] hover:text-[#111] w-8 h-8">
                            <i class="far fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
    
                <div class=" swiper-chuyenmon swiper">
                    <div class="swiper-wrapper">
                        @foreach ($chuyen_mon as $item)
                            @php
                                $name = $item->{"ten$lang"};
                                $desc = $item->{"mota$lang"};
                                $img = Thumb::Crop(UPLOAD_PHOTO, $item->photo, 280, 515, 1);
                            @endphp
                            <div class="swiper-slide group">
                                <div class="relative">
                                    <figure>
                                        <x-shared.image class="w-full" src="{{ $img }}" />
                                    </figure> 
                                    <div class="absolute bottom-0 transition-all duration-150 left-0 w-full min-h-[154px] group-hover:min-h-full bg-linear-chuyenmon group-hover:bg-linear-chuyenmon2 px-6 py-4 flex flex-col group-hover:justify-center justify-end">
                                        <div class="text-xl font-medium text-secondary-500">{{ $name }}</div>
                                        <div class="hidden mt-3 text-sm font-light text-white transition-all duration-150 group-hover:block">{{ $desc }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
            const swiper = new Swiper('.swiper-chuyenmon', {
                loop: true,
                spaceBetween: 20,
                slidesPerView: 4,
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-chuyenmon-button-next',
                    prevEl: '.swiper-chuyenmon-button-prev',
                },
                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 1,
                    },
                    // when window width is >= 480px
                    480: {
                        slidesPerView: 2,
                    },
                    // when window width is >= 640px
                    640: {},
                    992: {
                        slidesPerView: 4,
                    }
                }
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
