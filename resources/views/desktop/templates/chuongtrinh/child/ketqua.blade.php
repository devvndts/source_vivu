@if ($data['ketquasaukhoahoc'])
<div class="detail-ketqua container  py-20">
    <div class="clear-both min-h-[260px] relative">
        <x-shared.title class="max-w-[370px] xl:float-left xl:mt-14">
            <x-slot name="title">{{ __('Kết quả sau khóa học') }}</x-slot>
        </x-shared.title>
        {{-- <img src="public/pts/ketqua.png" alt="ketqua" class="rounded-tr-[230px]"> --}}
        <div class="clear-both xl:absolute w-full xl:max-w-[800px] right-0 top-0">
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
            class="swiper swiper-detailketqua ">
                <div class="swiper-wrapper">
                    @foreach ($data['ketquasaukhoahoc'] as $item)
                        @php
                            $name = $item["ten$lang"] ?? '';
                            $photoUrl = $item["photo2"] ?? '';
                            $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 800, 260, 1);
                        @endphp
                        <div class="swiper-slide ">
                            <div class="aspect-w-6 bg-no-repeat overflow-hidden bg-cover aspect-h-2 rounded-tr-[230px] " style="background-image: url({{ $photo }}); ">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="  relative -mt-8">
        {{-- <div
            class="swiper-button-prev-ketqua z-20 absolute left-2 top-1/2 -mt-4 w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary bg-white hover:text-primary">
            <span class="material-icons">
                chevron_left
            </span>
        </div>
        <div
            class="swiper-button-next-ketqua z-20 absolute right-2 top-1/2 -mt-4 w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex bg-white justify-center items-center">
            <span class="material-icons">
                chevron_right
            </span>
        </div> --}}
        <div thumbsSlider="" class="swiper swiper-ketqua ">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper ">
                @foreach ($data['ketquasaukhoahoc'] as $item)
                    @php
                        $name = $item["ten$lang"] ?? '';
                        $description = $item["mota$lang"] ?? '';
                        $photoUrl = $item["photo"] ?? '';
                        $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 70, 70, 2);
                        // $photo = UPLOAD_POST . $photoUrl;
                    @endphp
                    <div class="swiper-slide ">
                        <div class="items-center cursor-pointer text-black bg-white [.swiper-slide-thumb-active_&]:text-white [.swiper-slide-thumb-active_&]:bg-primary justify-between relative rounded-lg overflow-hidden border border-solid min-h-[150px] flex border-primary shadow-lg group pl-10 pr-3  gap-4" style="--shadow: 0px 27px 30px rgba(0, 0, 0, 0.06);">
                            <x-shared.image class="w-[70px] h-[70px] filter [.swiper-slide-thumb-active_&]:brightness-0 [.swiper-slide-thumb-active_&]:invert" src="{{ $photo }}" alt="" />
                            {{-- <div
                                class="overflow-hidden  w-[50px] h-[50px]">
                                <div style="background-image: url({{ $photo }})"
                                    class="aspect-w-1 block aspect-h-1 bg-contain bg-center backdrop-filter  backdrop-brightness-100  backdrop-invert">
                                </div>
                            </div> --}}

                            <div class="flex-1">
                                <div><strong class="text-base">{{ $name }}</strong></div>
                                <div class="text-sm mt-2">{{ $description }}</div>
                            </div>
                        </div>
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
@push('js_page')
    <script>
        $(document).ready(function() {
            
            const swiper_ketqua = new Swiper('.swiper-ketqua', {
                // Optional parameters
                loop: false,
                // centerInsufficientSlides: true,
                // centeredSlides: true,
                // centeredSlidesBounds: true,
                slidesPerView: 1,
                spaceBetween: 24,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 4,
                    }
                },
                // slidesOffsetAfter: 200,
                // If we need pagination
                // pagination: {
                //     el: '.swiper-pagination',
                // },

                // Navigation arrows
                // navigation: {
                //     nextEl: '.swiper-button-next-ketqua',
                //     prevEl: '.swiper-button-prev-ketqua',
                // },

                // And if we need scrollbar
                // scrollbar: {
                //     el: '.swiper-scrollbar',
                // },
            });
            var swiper_detailketqua = new Swiper(".swiper-detailketqua", {
                loop: true,
                // navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev",
                // },
                thumbs: {
                    swiper: swiper_ketqua,
                },
            });
            swiper_detailketqua.on('slideChange', function() {
                let index = swiper_detailketqua.realIndex;
                swiper_ketqua.slideToLoop(index, 800, null);
            });
        });
    </script>
@endpush
@endif