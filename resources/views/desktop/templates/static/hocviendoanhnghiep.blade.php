@extends('desktop.master')
@section('content')
@php
    $feedback = get_posts('feedback', $lang,  ["order_by" => ["stt" => "asc"]]);
	$feedback2 = get_posts('feedback2', $lang,  ["order_by" => ["stt" => "asc"]]);
@endphp
<div class="doinguchuyengia " >
    <div class="container max-w-[1462px] ">
        <x-shared.title class="text-center mt-20" >
            <x-slot name="title" >{{ __('HỌC VIÊN NÓI GÌ VỀ CHÚNG TÔI') }}</x-slot>
        </x-shared.title>
        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-4 m-5">
            @foreach ($feedback as $item)
                @php
                    $name = $item->{"ten$lang"} ?? '';
                    $desc = $item->{"mota$lang"} ?? '';
                    $sl_options = (isset($item->sl_options) && $item->sl_options != '') ? json_decode($item->sl_options, true) : null;
                    $congty = $sl_options['congty'] ?? '';
                    $tieudetop = $sl_options['tieudetop'] ?? '&nbsp;';
                    $photoUrl = $item->photo ?? '';
                    $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 100, 100, 1);
                    $url = $item->sluglang ?? '';
                @endphp
                <div class="flex gap-6 items-center justify-between">
                    <div class="flex justify-end relative shrink-0 ">
                        <img src="public/pts/danhgiasign.png" alt="danhgia" class="absolute -top-4 -right-2">
                        <div  style="background-image: url({{ $photo }})" class="w-[100px] aspect-w-1 aspect-h-1 rounded-full overflow-hidden bg-cover "></div>
                    </div>
                    <div class="text-[#404040] flex-1">
                        <div class="font-bold capitalize text-lg">{!! $tieudetop !!}</div>
                        <hr class="border-primary-100 mt-2">
                        <div class="text-sm  mt-5">{{ $desc }}</div>
                        <div class="font-bold mt-2 text-base uppercase">{{ $name }}</div>
                        <div class="text-sm  mt-2">{{ $congty }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <x-shared.title class="text-center mt-20" >
            <x-slot name="title" >{{ __('DOANH NGHIỆP NÓI GÌ VỀ CHÚNG TÔI') }}</x-slot>
        </x-shared.title>
        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-4 m-5">
            @foreach ($feedback2 as $item)
                @php
                    $name = $item->{"ten$lang"} ?? '';
                    $desc = $item->{"mota$lang"} ?? '';
                    $sl_options = (isset($item->sl_options) && $item->sl_options != '') ? json_decode($item->sl_options, true) : null;
                    $congty = $sl_options['congty'] ?? '';
                    $tieudetop = $sl_options['tieudetop'] ?? '&nbsp;';
                    $photoUrl = $item->photo ?? '';
                    $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 100, 100, 1);
                    $url = $item->sluglang ?? '';
                @endphp
                <div class="flex gap-6 items-center justify-between">
                    <div class="flex justify-end relative shrink-0 ">
                        <img src="public/pts/danhgiasign.png" alt="danhgia" class="absolute -top-4 -right-2">
                        <div  style="background-image: url({{ $photo }})" class="w-[100px] aspect-w-1 aspect-h-1 rounded-full overflow-hidden bg-cover "></div>
                    </div>
                    <div class="text-[#404040] flex-1">
                        <div class="font-bold capitalize text-lg">{!! $tieudetop !!}</div>
                        <hr class="border-primary-100 mt-2">
                        <div class="text-sm  line-clamp-3 mt-5">{{ $desc }}</div>
                        <div class="font-bold mt-2 text-base uppercase">{{ $name }}</div>
                        <div class="text-sm  mt-2">{{ $congty }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <x-shared.title class="text-center mt-20" >
            <x-slot name="title" >{{ __('HỌC VIÊN REVIEW') }}</x-slot>
        </x-shared.title>
        <div class="swiper swiper-hocvienreview my-8">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                @foreach ($hocVienReviewList as $item)
                    @php
                        $name = $item->{"ten".$lang} ?? '';
                        $url = $item->link_video;
                    @endphp
                    <div class="swiper-slide text-center group">
                        <div class="aspect-w-16 shadow-lg overflow-hidden aspect-h-9 rounded-xl">
                            <iframe src="https://www.youtube.com/embed/{{ Helper::getYoutube($url ?? '') }}" class="absolute inset-0 w-full h-full" allowfullscreen></iframe>
                        </div>
                        <div class="mt-5 text-base group-hover:text-primary font-bold font-title">{{ $name }}</div>
                    </div>
                @endforeach
            </div>
            <!-- If we need pagination -->
            {{-- <div class="swiper-pagination"></div> --}}

            <!-- If we need navigation buttons -->
            

            <!-- If we need scrollbar -->
            {{-- <div class="swiper-scrollbar"></div> --}}
        </div>

    </div>
</div>


@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

@push('js_page')
    <script>
        $(document).ready(function() {
            const swiper_hocvienreview = new Swiper('.swiper-hocvienreview', {
                // Optional parameters
                loop: false,
                autoplay: JS_AUTOPLAY && {
                    delay: 3000,
                },
                // slidesPerView: 3.72,
                slidesPerView: 2,
                spaceBetween: 20,
                // If we need pagination
                // pagination: {
                //     el: '.swiper-pagination',
                // },

                // Navigation arrows
                breakpoints: {
                    1024: {
                        slidesPerView: 4,
                    }
                }
                // And if we need scrollbar
                // scrollbar: {
                //     el: '.swiper-scrollbar',
                // },
            });

        });
    </script>
@endpush

@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush