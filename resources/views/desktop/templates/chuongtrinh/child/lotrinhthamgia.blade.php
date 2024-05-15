@if ($data['lotrinhthamgia'])
    <div class="detail-thamgia py-20">
        <div class="container">
            <x-shared.title class="text-center">
                <x-slot name="title">{{ __('lộ trình tham gia') }}</x-slot>
                <x-slot name="desc">{!! $text_general->{'mota'.$lang} !!}</x-slot>
            </x-shared.title>
        </div>
        <div class="container max-w-[1382px] relative mt-20">
            <div
                class="swiper-button-prev-thamgia absolute z-30 left-0 top-1/2 -mt-4 w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                <span class="material-icons">
                    chevron_left
                </span>
            </div>
            <div
                class="swiper-button-next-thamgia absolute z-30 right-0 top-1/2 -mt-4 w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex justify-center items-center">
                <span class="material-icons">
                    chevron_right
                </span>
            </div>
            <div class="swiper swiper-thamgia max-w-[1144px]">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper ">
                        
                        @foreach ($data['lotrinhthamgia'] as $item)
                            @php
                                $name = $item["ten$lang"] ?? '';
                                $description = $item["mota$lang"] ?? '';
                                $photoUrl = $item["photo"] ?? '';
                                // $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 70, 70, 1);
                                $photo = UPLOAD_POST . $photoUrl;
                            @endphp
                            <div class="swiper-slide">
                                <div class="relative">
                                    <div class="rounded-full group hover:animate-pulse border-opacity-20 border-transparent overflow-hidden border hover:border-primary flex items-center justify-center mx-auto w-[100px] h-[100px] md:w-[200px] md:h-[200px]">
                                        <div class="rounded-full border-opacity-70  overflow-hidden border border-transparent group-hover:border-primary transition-all duration-300 ease-in-out flex items-center justify-center mx-auto md:w-[180px] w-full h-full md:h-[180px]">
                                            <div class="rounded-full bg-white  overflow-hidden border border-primary  mx-auto md:w-[160px] w-full h-full md:h-[160px]">
                                                <div style="background-image: url({{ $photo }})" class="aspect-w-1 block aspect-h-1 bg-center bg-contain">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div
                                    class="rounded-full bg-white  overflow-hidden border border-primary mx-auto w-[160px] h-[160px]">
                                    <div style="background-image: url({{ $photo }})"
                                        class="aspect-w-1 block aspect-h-1 bg-cover">
                                    </div>
                                </div> --}}
                                <div class="text-center mt-6">
                                    <div><strong class="text-xl">{{ $name }}</strong></div>
                                    <div class="text-sm line-clamp-2">{{ $description }}</div>
                                </div>
                                <img src="public/pts/arrow.png" alt="arrow" class="absolute hidden md:inline-block -right-[22px] top-[210px]">
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
                const swiper_thamgia = new Swiper('.swiper-thamgia', {
                    // Optional parameters
                    loop: false,
                    // centerInsufficientSlides: true,
                    // centeredSlides: true,
                    // centeredSlidesBounds: true,
                    slidesPerView: 2,
                    // slidesOffsetAfter: 200,
                    // If we need pagination
                    // pagination: {
                    //     el: '.swiper-pagination',
                    // },

                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next-thamgia',
                        prevEl: '.swiper-button-prev-thamgia',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 5,
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