@if ($data['quyenloi'])
    <div class="detail-quyenloihocvien">
        <div class="container">
            <x-shared.title class="text-center mt-20">
                <x-slot name="title">{{ __('quyền lợi học viên') }}</x-slot>
                <x-slot name="desc">{!! $text_general->{'mota'.$lang} !!}</x-slot>
            </x-shared.title>
        </div>
        <div style="background-image: url('{{ UPLOAD_PHOTO . $photo_static['bg-quyenloihocvien']['photo'] }}');" class=" bg-no-repeat bg-[length:100%_auto] pt-[110px]">
            <div class="container z-10 relative max-w-[1194px]">
                <div class="swiper swiper-detailquyenloi">
                    <div class="swiper-wrapper">
                        @foreach ($data['quyenloi'] as $item)
                            @php
                                $name = $item["ten$lang"] ?? '';
                                $description = $item["mota$lang"] ?? '';
                                $photoUrl = $item["photo"] ?? '';
                                $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 250, 250, 1);
                            @endphp
                            <div class="swiper-slide">
                                <div class="relative pb-7 pt-24">
                                    <div class="md:w-[240px] w-[130px] h-[130px] rounded-full overflow-hidden md:h-[240px] absolute left-1/2 -translate-x-1/2 top-0">
                                        <x-shared.image src="{{ $photo }}" alt="{{ $name }}" />
                                    </div>
                                    <div class="shadow-xl bg-white rounded-xl p-4 pt-10 md:p-10 md:pt-[185px] text-center" style="--shadow: 0px 18px 26px rgba(0, 0, 0, 0.05);">
                                        <div class="font-bold text-base md:text-xl line-clamp-2 h-14 ">{{ $name }}</div>
                                        <div class="text-sm line-clamp-3 h-[60px]">{{ $description }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="absolute left-0 bottom-6 w-full z-20 flex justify-center gap-3 ">
                        <div
                            class="swiper-button-prev-detailquyenloi w-[33px] h-[33px] rounded-full border border-white text-white flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                            <span class="material-icons">
                                chevron_left
                            </span>
                        </div>
                        <div
                            class="swiper-button-next-detailquyenloi w-[33px] h-[33px] rounded-full border border-white transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-white flex justify-center items-center">
                            <span class="material-icons">
                                chevron_right
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js_page')
        <script>
            $(document).ready(function() {
                const swiper_detailquyenloi = new Swiper('.swiper-detailquyenloi', {
                    // Optional parameters
                    loop: true,
                    autoplay: JS_AUTOPLAY && {
                        delay: 3000,
                    },
                    // centerInsufficientSlides: true,
                    // centeredSlides: true,
                    // centeredSlidesBounds: true,
                    slidesPerView: 2,
                    spaceBetween: 12,
                    // slidesOffsetAfter: 200,
                    // If we need pagination
                    // pagination: {
                    //     el: '.swiper-pagination',
                    // },

                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next-detailquyenloi',
                        prevEl: '.swiper-button-prev-detailquyenloi',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                        1024: {
                            slidesPerView: 3,
                        }
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
