@if ($data['doituonghocvien'])
    <div class="detail-doituonghocvien mt-36 relative">
        <div class="bg-white -top-[63px] w-1/2 h-[250px] /rounded-r-3xl absolute z-10 shadow-xl border border-x-0  border-orange-400/30 
        " style="--shadow: 0px 18px 26px rgba(0, 0, 0, 0.05);"></div>
        <div class="container z-10 relative max-w-[1440px]">
            <div class="lg:pl-[120px] flex items-center">
                <div class="pr-5 md:pr-[130px] relative">
                    <div class="bg-white -top-[63px] w-full h-[250px] rounded-r-3xl absolute z-10 /shadow-xl border border-l-0  border-orange-400/30 
                    " style="--shadow: 0px 18px 26px rgba(0, 0, 0, 0.05);"></div>
                    <x-shared.title class="z-20 relative">
                        <x-slot name="title">{{ __('đối tượng học viên') }}</x-slot>
                    </x-shared.title>
                </div>
                <div class="inline-flex ml-4 md:ml-12 justify-center gap-3 ">
                    <div
                        class="swiper-button-prev-detailhocvien w-[33px] h-[33px] rounded-full border border-secondary text-secondary flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                        <span class="material-icons">
                            chevron_left
                        </span>
                    </div>
                    <div
                        class="swiper-button-next-detailhocvien w-[33px] h-[33px] rounded-full border border-secondary transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-secondary flex justify-center items-center">
                        <span class="material-icons">
                            chevron_right
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container max-w-[1440px] z-20 relative mt-10">
            <div class="swiper swiper-detailhocvien ">
                <div class="swiper-wrapper ">
                        
                        @foreach ($data['doituonghocvien'] as $item)
                            @php
                                $name = $item["ten$lang"] ?? '';
                                $description = $item["mota$lang"] ?? '';
                                $photoUrl = $item["photo"] ?? '';
                                $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 70, 70, 1);
                            @endphp
                            <div class="swiper-slide pb-4">
                                <div class="relative rounded-lg  overflow-hidden border border-solid min-h-[250px] flex border-primary shadow-lg group" style="--shadow: 0px 27px 30px rgba(0, 0, 0, 0.06);">
                                    <div class="w-full bg-white relative z-10 flex items-center">
                                        <div class="text-center w-full">
                                            <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="mx-auto" />
                                            <div class="mt-5 text-black text-xl font-semibold">{{ $name }}</div>
                                        </div>
                                    </div>
                                    <div class="grid group-hover:bg-primary group-hover:grid-rows-1 transition-all duration-300 ease-in-out grid-rows-none group-hover:z-20 absolute top-0 bottom-0 left-0 right-0 pt-12 px-8">
                                        <div class="overflow-hidden">
                                            <div class=" text-white text-xl font-semibold">{{ $name }}</div>
                                            <div class=" text-white line-clamp-5 text-sm mt-2">{{ $description }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
                
            </div>
        </div>
    </div>

    @push('js_page')
        <script>
            $(document).ready(function() {
                const swiper_detailhocvien = new Swiper('.swiper-detailhocvien', {
                    // Optional parameters
                    loop: false,
                    autoplay: JS_AUTOPLAY && {
                        delay: 3000,
                    },
                    // centerInsufficientSlides: true,
                    // centeredSlides: true,
                    // centeredSlidesBounds: true,
                    slidesPerView: 2,
                    spaceBetween: 24,
                    // If we need pagination
                    // pagination: {
                    //     el: '.swiper-pagination',
                    // },
                    breakpoints: {
                        768: {
                            slidesPerView: 3,
                        },
                        1100: {
                            slidesPerView: 5,
                            slidesOffsetBefore: 120,
                        }
                    },
                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next-detailhocvien',
                        prevEl: '.swiper-button-prev-detailhocvien',
                    },

                    // And if we need scrollbar
                    // scrollbar: {
                    //     el: '.swiper-scrollbar',
                    // },
                });
            });
        </script>
    @endpush
@endif