@php
    $tintucLevel1 = get_categories('tin-tuc', $lang, ["query" => ["level" => "0"], "order_by" => ["stt" => "asc"]]);
@endphp
<div class="home-tintuc mt-20">
    <x-shared.title class="text-center" >
        <x-slot name="title">{{ __('Tin tức') }}</x-slot>
    </x-shared.title>
    @foreach ($tintucLevel1 as $level1)
    @php
        $level1Name = $level1->{"ten$lang"} ?? '';
        $level1Id = $level1->id;
        $level1Url = url($level1->{$sluglang} ?? '');
        $postOfLevel1 = get_posts('tin-tuc', $lang,  ["order_by" => ["stt" => "asc"], "query" => ["ids_level_1" => $level1Id]]);
    @endphp
    <div class="container max-w-[1474px] relative mt-4">
        <div class="flex justify-between items-center">
            <h2 class="uppercase font-bold text-xl"><a class="text-primary" href="{{ $level1Url }}">{{ $level1Name }}</a></h2>
            <x-shared.readmore2 class="hidden md:inline-flex" href="{{ $level1Url }}" >
                <x-slot name="icon"></x-slot>
            </x-shared.readmore2>
        </div>
        <div class="absolute w-[563px] h-[563px] left-1/2 -translate-x-full  top-[478px] bg-orange-500 bg-opacity-10 filter blur-3xl"></div>
        <div class="max-w-[1520px] mt-4">
            <div class="swiper swiper-tintuc ">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($postOfLevel1 as $item)
                    @php
                        $name = $item->{"ten$lang"} ?? '';
                        $url = url($item->{$sluglang} ?? '');
                        $desc = $item->{"mota$lang"} ?? '';
                        $photoUrl = $item->photo ?? '';
                        $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 400, 300, 1);
                    @endphp
                    <div class="swiper-slide ">
                        <div class="rounded-xl bg-white  overflow-hidden shadow-md">
                            <a href="{{ $url }}" style="background-image: url({{ $photo }})" class="aspect-w-4 block aspect-h-3 bg-cover">
                            </a>
                            <div class="flex flex-col min-h-[276px] items-stretch  relative py-12 px-9">
                                <div >
                                    <h3 class="text-base font-bold font-title line-clamp-2">
                                        <a href="{{ $url }}">{{ $name }}</a>
                                    </h3>
                                    <div class="text-sm line-clamp-3 mt-2">{{ $desc }}</div>
                                </div>
                                <x-shared.readmore2 href="{{ $url }}" class="!p-0 mt-auto ">
                                    <x-slot name="icon"></x-slot>
                                </x-shared.readmore2>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- <div class="container max-w-[1474px] relative">
        <div class="flex justify-between items-center">
            <h2 class="uppercase font-bold text-xl"><a class="text-primary" href="">Tin tức VMO Academy</a></h2>
            <x-shared.readmore2 href="{{ url('#') }}" >
                <x-slot name="icon"></x-slot>
            </x-shared.readmore2>
        </div>
        <div class="absolute w-[563px] h-[563px] left-1/2 -translate-x-full  top-[478px] bg-orange-500 bg-opacity-10 filter blur-3xl"></div>

        <div class="max-w-[1520px]">
            <div class="swiper swiper-tintuc ">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < 6; $i++)
                    <!-- Slides -->
                    <div class="swiper-slide ">
                        <div class="rounded-xl bg-white  overflow-hidden shadow-md">
                            <a href="" style="background-image: url(public/pts/doinguchuyengia.png)" class="aspect-w-4 block aspect-h-3 bg-cover">
                            </a>
                            <div class="flex flex-col min-h-[276px] items-stretch  relative py-12 px-9">
                                <div class="">
                                    <h3 class="text-base font-bold font-title line-clamp-2">
                                        <a href="">
                                            @if ($i == 0)
                                            {{ $i }} Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                                            @else
                                            {{ $i }} Lorem ipsum
                                            @endif
                                        </a>
                                    </h3>
                                    <div class="text-sm line-clamp-3 mt-2">Aen ean risus felis bibe ndum a acc um san an quis lao reet et pu rus mauris non euismod.</div>
                                </div>
                                <x-shared.readmore2 href="{{ url('#') }}" class="!p-0 mt-auto ">
                                    <x-slot name="icon"></x-slot>
                                </x-shared.readmore2>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div> --}}
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            const swiper_tintuc = new Swiper('.swiper-tintuc', {
                // Optional parameters
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 3000,
                },
                // centerInsufficientSlides: true,
                // centeredSlides: true,
                // centeredSlidesBounds: true,
                slidesPerView: 1.2,
                spaceBetween: 24,
                // slidesOffsetAfter: 200,
                // If we need pagination
                // pagination: {
                //     el: '.swiper-pagination',
                // },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3.3,
                    }
                },
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next-tintuc',
                    prevEl: '.swiper-button-prev-tintuc',
                },

                // And if we need scrollbar
                // scrollbar: {
                //     el: '.swiper-scrollbar',
                // },
            });
        });
    </script>
@endpush