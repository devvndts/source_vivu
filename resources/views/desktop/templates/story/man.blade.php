@php
@endphp
@extends('desktop.master')
@section('element_detail', 'p-story')

@section('content')
    @isset($bannerCauchuyen[0])
        @php
        // dd($bannerCauchuyen[0]);
        // link_video
        $link_video = $bannerCauchuyen[0]->link_video;
        $idYoutube = Helper::GetYoutube($link_video);
        $img = sprintf('<img class="w-full" src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_PHOTO, $bannerCauchuyen[0]->photo, 1600, 615, 1, $bannerCauchuyen[0]->type), 'story_banner', asset('img/noimage.png'));
        @endphp
        @if ($link_video)
            <div class="container">
                <div class="aspect-w-16 aspect-h-9">
                    <!-- The <iframe> (and video player) will replace this <div> tag. -->
                    <div id="video-container"></div>
                </div>
            </div>
        @else
            {!! $img !!}
        @endif
    @endisset

    @isset($nhaSangLap)
        @php
        $name = 'nhà sáng lập';
        $desc = $nhaSangLap->{"noidung$lang"};
        $img = Thumb::Crop(UPLOAD_STATICPOST, $nhaSangLap->photo, 550, 670, 2, $nhaSangLap->type);
        @endphp
        <div class="relative z-20 py-8 lg:pb-0">
            <div class="container">
                <div class="relative md:flex">
                    <img class="absolute hidden md:block -right-12" src="{{ asset('img/story_leaf.png') }}" alt="story_leaf">
                    <div class="md:w-[43%] flex-shrink-0">
                        <x-shared.image class="w-full" alt="{{ $name }}" src="{{ $img }}" />
                    </div>
                    <div class="min-w-0 mt-16 md:ml-10 md:flex-1">
                        @php
                            $data = [
                                'title' => 'nhà sáng lập',
                                'desc' => '',
                                'link' => '',
                                'icon' => true,
                                'class_icon' => '!ml-14',
                                'class_title' => '!text-left',
                                'class_desc' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.title-primary', ['data' => $data])
                        <div class="my-6 text-justify text-last-left">
                            {!! $desc !!}
                        </div>
                        {{-- <div class="flex flex-wrap items-center">
                        <span class="text-sm font-semibold text-black">Báo chí nói gì về CEO Natural Pharm:</span>
                        <a href="" class="py-1 ml-5"><img class="max-h-10" src="{{ asset('img/story_vnn.png') }}"
                                alt="story_vnn"></a>
                        <a href="" class="py-1 ml-5"><img class="max-h-10" src="{{ asset('img/story_vnn.png') }}"
                                alt="story_vnn"></a>
                        <a href="" class="py-1 ml-5"><img class="max-h-10" src="{{ asset('img/story_vnn.png') }}"
                                alt="story_vnn"></a>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @isset($taiSaoLaNatural)
        @php
        $name = 'tại sao là';
        $desc = $taiSaoLaNatural->{"noidung$lang"};
        $img = Thumb::Crop(UPLOAD_STATICPOST, $taiSaoLaNatural->photo, 620, 460, 2, $taiSaoLaNatural->type);
        @endphp
        <div class="pb-8 bg-[#F7FCF0] relative z-10 py-8 lg:pt-0">
            <div class="bg-[#F7FCF0] h-10 w-full absolute -top-10 hidden lg:block"></div>
            <div class="container">
                <div class="relative items-start md:flex">
                    <img class="absolute hidden md:block -scale-x-100 top-20 -left-12" src="{{ asset('img/story_leaf.png') }}"
                        alt="story_leaf">
                    <div class="md:w-[49%] flex-shrink-0 md:ml-14 order-1 relative">
                        <x-shared.image class="relative z-20 w-full" alt="{{ $name }}" src="{{ $img }}" />
                        <div class="absolute z-10 w-full h-full bg-[#FBECD5] -right-6 -bottom-6 "></div>
                    </div>
                    <div class="min-w-0 mt-16 md:flex-1 md:ml-16">
                        @php
                            $data = [
                                'title' => $name,
                                'desc' => '',
                                'link' => '',
                                'icon' => true,
                                'class_icon' => '!ml-14',
                                'class_title' => '!text-left',
                                'class_desc' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.title-primary', ['data' => $data])
                        <div class="my-6 text-justify text-last-left">
                            {!! $desc !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @isset($slide2Cauchuyen)
        <div class="slider2-home">
            <div class="container">
                <div class="slider-main">
                    @foreach ($slide2Cauchuyen as $item)
                        @php
                            $name = $item->{"ten$lang"};
                            $desc = $item->{"mota$lang"};
                            $link = $item->$sluglang;
                            $img = Thumb::Crop(UPLOAD_PHOTO, $item->photo, 550, 570, 2, $item->type);
                        @endphp
                        <div class="slider2-item slick-slide">
                            <div class="slider2-item__box md:flex md:flex-nowrap md:justify-between pb-[24px] md:pb-0">
                                <a class="md:w-[43.5%]" href="{{ $link }}">
                                    {{-- <img src="{{ asset('img/story_product.png') }}"
                                    alt=""> --}}
                                    <x-shared.image src="{{ $img }}" alt="{{ $name }}"></x-shared.image>
                                </a>
                                <div class="slider2-item__info md:w-[27.5%] md:mt-[130px]">
                                    <h5
                                        class="text-[20px] line-clamp-2 md:text-[32px] md:line-clamp-3 text-center md:text-left">
                                        <a href="{{ $link }}">{{ $name }}</a>
                                    </h5>
                                </div>
                                <p class="md:w-[25%] md:mt-[320px] text-base line-clamp-4 text-center md:text-justify md:text-last-left">
                                    {{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endisset

    @isset($giaTriCotLoi)
        <div class="core-value py-16 bg-[#F7FCF0]">
            <div class="container">
                <img class="absolute hidden md:block -right-12 -top-48" src="{{ asset('img/story_leaf.png') }}"
                    alt="story_leaf">
                @php
                    $text = get_static('text-gia-tri-cot-loi');
                    $data = [
                        'title' => 'giá trị cốt lỗi',
                        'desc' => $text->{"mota$lang"} ?? '',
                    ];
                @endphp
                @include('desktop.layouts.title-primary', ['data' => $data])

                <div class="-mx-2 core-value-slick md:mx-0">
                    @foreach ($giaTriCotLoi as $item)
                        @php
                            $name = $item->{"ten$lang"};
                            $desc = $item->{"mota$lang"};
                            $link = $item->$sluglang;
                            $img = Thumb::Crop(UPLOAD_POST, $item->photo, 290, 360, 2, $item->type);
                        @endphp

                        <div class="px-2 slick-slide">
                            <a href="{{ $link }}">
                                <div class="p-2">
                                    <div class="relative z-20 px-2">
                                        <figure>
                                            {{-- <img src="{{ asset('img/story_core.png') }}" class="w-full" alt="story_core"> --}}
                                            <x-shared.image src="{{ $img }}" class="w-full" alt="{{ $name }}">
                                            </x-shared.image>
                                        </figure>
                                    </div>
                                    <div class="relative z-10 p-2 pb-3 bg-white shadow-md">
                                        <div class="absolute left-0 w-full bg-white h-7 -top-7"></div>
                                        <h5 class="mb-2 text-sm font-semibold line-clamp-2">{{ $name }}</h5>
                                        <p class="text-sm text-black line-clamp-3 text-opacity-70">{{ $desc }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endisset

    @isset($chungNhanChuyenGia)
        <div class="story-video py-9 ">
            <div class="container">
                <img class="absolute z-10 hidden md:block -scale-x-100 top-20 -left-12" src="{{ asset('img/story_leaf.png') }}"
                    alt="story_leaf">

                <div class="relative z-20 items-center md:flex">
                    <div class="md:w-[40%] md:shadow-3xl md:py-7 md:px-14 bg-white">
                        @php
                            $text = get_static('text-chungnhanchuyengia');
                            $data = [
                                'title' => 'chứng nhận từ chuyên gia',
                                'desc' => $text->{"mota$lang"} ?? '',
                                'class_title' => '!text-left',
                                'class_desc' => '!text-justify',
                            ];
                        @endphp
                        @include('desktop.layouts.title-primary', ['data' => $data])
                    </div>
                    <div class="min-w-0 md:flex-1">
                        <div class="story-video-swiper swiper">
                            <div class="swiper-wrapper">
                                @foreach ($chungNhanChuyenGia as $item)
                                    @php
                                        // $name = $item->{"ten$lang"};
                                        // $desc = $item->{"mota$lang"};
                                        // $link = $item->$sluglang;
                                        // $img = Thumb::Crop(UPLOAD_POST, $item->photo, 290, 360, 2, $item->type);
                                        //tiktok
                                        $opt = Helper::JsonDecode($item->sl_options);
                                    @endphp
                                    <div class="swiper-slide">
                                        <div>
                                            <figure class="aspect-w-[355px] aspect-h-[500px] h-72 lg:h-[500px]">
                                                {{-- <img src="{{ asset('img/story_core.png') }}" class="object-cover w-full" alt="story_core"> --}}
                                                @if ($opt["tiktok"])
                                                    {!! $opt["tiktok"] !!}
                                                @endif
                                            </figure>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @isset($chungNhanCongBo)
        <div class="core-value py-9 bg-[#F7FCF0]">
            <div class="container">
                <img class="absolute top-0 -left-12" src="{{ asset('img/story_leaf_a.png') }}" alt="story_leaf_a">
                <img class="absolute -bottom-10 -right-12" src="{{ asset('img/story_leaf.png') }}" alt="story_leaf">
                @php
                    $text = get_static('text-chungnhancongbo');
                    $data = [
                        'title' => 'chứng nhận và công bố',
                        'desc' => $text->{"mota$lang"} ?? '',
                    ];
                @endphp
                @include('desktop.layouts.title-primary', ['data' => $data])

                <div class="max-w-4xl mx-auto">
                    <div class="core-value-slick">
                        @foreach ($chungNhanCongBo as $item)
                            @php
                                $name = $item->{"ten$lang"};
                                $link = $item->link;
                                $img = Thumb::Crop(UPLOAD_PHOTO, $item->photo, 400, 570, 1, $item->type);
                            @endphp
                            <div class="px-2 slick-slide">
                                <a href="{{ $link }}">
                                    <figure>
                                        {{-- <img src="{{ asset('img/story_certificates.png') }}" class="w-full"
                                            alt="story_certificates"> --}}
                                        <x-shared.image class="w-full" src="{{ $img }}" alt="{{ $name }}"></x-shared.image>
                                    </figure>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @isset($baoChi)
        <div class="py-10 core-value ">
            <div class="container">
                @php
                    $text = get_static('text-baochi');
                    $data = [
                        'title' => 'báo chí nói gì về chúng tôi',
                        'desc' => $text->{"mota$lang"} ?? '',
                    ];
                @endphp
                @include('desktop.layouts.title-primary', ['data' => $data])

                <div class="core-value-slick">
                    @foreach ($baoChi as $item)
                        @php
                            $name = $item->{"ten$lang"};
                            $desc = $item->{"mota$lang"};
                            $link = $item->$sluglang;
                            $img = Thumb::Crop(UPLOAD_POST, $item->photo, 300, 300, 1, $item->type);
                        @endphp
                        <div class="px-2 slick-slide">
                            <div>
                                <div class="p-2">
                                    <div class="relative z-20 px-2">
                                        <a href="{{ $link }}">
                                            <figure class="aspect-w-1 aspect-h-1">
                                                {{-- <img src="{{ asset('img/story_core.png') }}" class="object-cover w-full"
                                            alt="story_core"> --}}
                                                <x-shared.image alt="{{ $name }}" src="{{ $img }}"
                                                    class="object-cover w-full"></x-shared.image>
                                            </figure>
                                        </a>
                                    </div>
                                    <div class="relative z-10 bg-white shadow-md">
                                        <div>
                                            <div class="p-2">
                                                <h5 class="mb-2 text-sm font-semibold line-clamp-2">
                                                    <a href="{{ $link }}">
                                                        {{ $name }}
                                                    </a>
                                                </h5>
                                                <p class="text-sm text-black line-clamp-3 text-opacity-70">
                                                    {{ $desc }}
                                                </p>
                                            </div>
                                            <div class="bg-[#F7FCF0] mt-auto h-14 flex justify-center items-center">
                                                <a href="" class=""><img class="max-h-11"
                                                        src="{{ asset('img/story_vnn.png') }}" alt="story_vnn"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endisset

    <div class="py-14 story-product ">
        <div class="container">
            @php
                $data = [
                    'title' => 'các sản phẩm cung cấp',
                ];
            @endphp
            @include('desktop.layouts.title-primary', ['data' => $data])

            <div class="flex flex-wrap -mx-6 story-product-items">
                @foreach ($productsNew as $key => $item)
                    @php
                        $class = ($key + 1) % 2 == 0 ? 'custom-even' : '';
                        $name = $item["ten$lang"];
                        $desc = $item["mota$lang"];
                        $opt = Helper::JsonDecode($item['sl_options']);
                        $link = $opt['link'] ?? '';
                        $img = Thumb::Crop(UPLOAD_POST, $item["photo"], 280, 330, 2, $item["type"]);
                    @endphp
                    <div class="story-product-item {{ $class }} w-[calc(100%/2)] lg:w-[calc(100%/4)]">
                        <div class="px-6 lg:custom-even:pt-16 ">
                            <div class="relative max-w-[280px] mb-6 mx-auto flex flex-col items-center">
                                {{-- <img src="{{ asset('img/new-bg.png') }}" class="" alt="bg">
                                <figure class="max-w-[90px] md:max-w-[160px] absolute right-7 md:right-5 bottom-5">
                                    <img
                                        src="{{ asset('img/new-item.png') }}" alt="">
                                    <x-shared.image src="{{ $img }}" alt="{{ $name }}"></x-shared.image>
                                </figure> --}}

                                <img src="{{ asset('img/circle_bg.png') }}" class="relative z-20 block scale-[.8]" alt="bg">
                                <img src="{{ asset('img/circle_blur.png') }}" class="relative z-10 block -mt-6 scale-75" alt="blur">
                                
                                <figure class="max-w-[90px] md:max-w-[160px] absolute z-30 bottom-0">
                                    <a href="{{ $link }}">
                                        <x-shared.image src="{{ $img }}" alt="{{ $name }}"></x-shared.image>
                                    </a>
                                </figure>
                                
                            </div>

                            <div class="">
                                @if ($opt["sloganvi"])
                                <div class="text-center"><span
                                    class="text-[#845536] font-semibold text-sm">{{ $opt["sloganvi"] }}</span></div>
                                @endif
                                <a href="{{ $link }}"><h3 class="text-primary leading-tight text-center font-bold text-[16px] md:text-[20px]">
                                    {{ $name }}</h3></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <x-button title="{{ __('site.readmore') }}" class="block mx-auto mt-12 w-fit">
                <x-slot name="icon"></x-slot>
            </x-button>
        </div>
    </div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush
<!--js thêm cho mỗi trang-->
@push('js_page')
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player, time_update_interval;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('video-container', {
                // width: 600,
                // height: 400,
                videoId: '{{ $idYoutube }}',
                playerVars: {
                    'playsinline': 1,
                    'autoplay': 1,
                    'controls': 0
                },
                events: {
                    onReady: onPlayerReady,
                    // 'onStateChange': onPlayerStateChange
                }
            });
        }

        // 4. The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event.target.playVideo();
        }

        // 5. The API calls this function when the player's state changes.
        //    The function indicates that when playing a video (state=1),
        //    the player should play for six seconds and then stop.
        var done = false;
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
            setTimeout(stopVideo, 6000);
            done = true;
            }
        }
        function stopVideo() {
            player.stopVideo();
        }

        function initialize(){
            // Update the controls on load
            updateTimerDisplay();
            updateProgressBar();

            // Clear any old interval.
            clearInterval(time_update_interval);

            // Start interval to update elapsed time display and
            // the elapsed part of the progress bar every second.
            time_update_interval = setInterval(function () {
                updateTimerDisplay();
                updateProgressBar();
            }, 1000)

        }

        var slider__content__swiper = new Swiper(`.story-video-swiper`, {
            slidesPerView: 2.2,
            spaceBetween: 10,
            speed: 800,
            rewind: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            // autoHeight: true,
            /*autoplay: {
                delay: 8000,
                disableOnInteraction: false,
            },*/
        });
        $(document).ready(function() {
            $('#play').on('click', function () {
                player.playVideo();
            });

            $('#pause').on('click', function () {
                player.pauseVideo();
            });
            
            $('.slider-main').slick({
                lazyLoad: 'ondemand',
                infinite: false,
                accessibility: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: JS_AUTOPLAY,
                autoplaySpeed: 3000,
                speed: 1000,
                arrows: true,
                centerMode: false,
                dots: false,
                draggable: true,
            });
            $('.core-value-slick').slick({
                lazyLoad: 'ondemand',
                infinite: false,
                accessibility: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: JS_AUTOPLAY,
                autoplaySpeed: 3000,
                speed: 1000,
                arrows: false,
                centerMode: false,
                dots: false,
                draggable: true,
                responsive: [{
                        breakpoint: 850,
                        settings: {
                            slidesToShow: 3
                        }
                    }, {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 430,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
            });
        });
    </script>
@endpush
