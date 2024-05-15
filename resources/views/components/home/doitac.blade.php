@php
    $partner = get_photos('partner', $lang, ["order_by" => ["stt" => "asc"]]);
@endphp
<div class="home-doitac py-20">
    <x-shared.title class="text-center" >
        <x-slot name="title">{{ __('Đối tác') }}</x-slot>
    </x-shared.title>
    <div class="container max-w-[1382px] relative mt-20">
        <div class="swiper-button-prev-doitac absolute z-30 left-0 top-1/2 -mt-4 w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
            <span class="material-icons">
            chevron_left
            </span>
        </div>
        <div class="swiper-button-next-doitac absolute z-30 right-0 top-1/2 -mt-4 w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex justify-center items-center"><span class="material-icons">
            chevron_right
            </span></div>
        <div class="swiper swiper-doitac max-w-[1144px]">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper ">
                @foreach ($partner as $item)
                    @php
                        $name = $item->{"ten$lang"} ?? '';
                        $link = $item->link ?? '';
                        $photoUrl = $item->photo ?? '';
						$photo = Thumb::Crop(UPLOAD_PHOTO, $photoUrl ?? '', 160, 160, 2);

                    @endphp
                    <div class="swiper-slide">
                        <div class="rounded-full group hover:animate-pulse border-opacity-20 border-transparent overflow-hidden border hover:border-primary flex items-center justify-center mx-auto w-[100px] h-[100px] md:w-[200px] md:h-[200px]">
                            <div class="rounded-full border-opacity-70  overflow-hidden border border-transparent group-hover:border-primary transition-all duration-300 ease-in-out flex items-center justify-center mx-auto md:w-[180px] w-full h-full md:h-[180px]">
                                <div class="rounded-full bg-white  overflow-hidden border border-primary  mx-auto md:w-[160px] w-full h-full md:h-[160px]">
                                    <a href="{{ $link }}" style="background-image: url({{ $photo }})" class="aspect-w-1 block aspect-h-1 bg-center bg-contain">
                                    </a>
                                </div>
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
            const swiper_doitac = new Swiper('.swiper-doitac', {
                // Optional parameters
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 3000,
                },
                // centerInsufficientSlides: true,
                centeredSlides: true,
                // centeredSlidesBounds: true,
                slidesPerView: 3,
                // slidesOffsetAfter: 200,
                // If we need pagination
                // pagination: {
                //     el: '.swiper-pagination',
                // },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next-doitac',
                    prevEl: '.swiper-button-prev-doitac',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 5,
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