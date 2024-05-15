@php
    $doiNguChuyenGia = get_photos('doi-ngu-chuyen-gia', $lang, ["order_by" => ["stt" => "asc"]]);
    $banCoVan = get_photos('ban-co-van', $lang, ["order_by" => ["stt" => "asc"]]);
    $text_general = get_static('text-general', $lang);
@endphp
<div class="doinguchuyengia py-20" id="chuyen_gia">
    <div class="container flex flex-wrap items-stretch justify-between max-w-[1462px] ">
        <div class="md:w-[27%]  flex justify-between content-between items-stretch flex-col md:px-7 ">
            <div class="flex-1">
                <div class="font-title text-[24px] xl:text-[50px] font-bold uppercase text-primary">
                    ĐỘI NGŨ CHUYÊN GIA
                </div>
                <div class="text-sm mt-5 line-clamp-3">
                    {!! $text_general->{'mota'.$lang} !!}
                </div>
            </div>
            <div class="mt-4 md:mt-auto relative flex gap-3 mb-16">
                <div class="swiper-button-prev-doinguychuyengia w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                    <span class="material-icons">
                    chevron_left
                    </span>
                </div>
                <div class="swiper-button-next-doinguychuyengia w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex justify-center items-center"><span class="material-icons">
                    chevron_right
                    </span></div>
            </div>
        </div>
        <div class="md:w-[73%] w-full">
            <!-- Slider main container -->
            <div class="swiper swiper-doinguychuyengia">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($doiNguChuyenGia as $item)
                        @php
                            $name = $item->{"ten".$lang} ?? '';
                            $description = $item->{"mota".$lang} ?? '';
                            $photo = $item->photo ?? '';
                            $img = Thumb::Crop(UPLOAD_PHOTO, $photo ?? '', 270, 370, 1);
                        @endphp
                        <div class="swiper-slide text-center group">
                            <div style="background-image: url({{ $img }})" class="aspect-w-2 relative aspect-h-3 bg-cover rounded-[10px] overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-full hover:bg-doingu bg-doingupre bg-no-repeat bg-cover transition-all duration-300 "></div>
                            </div>
                            <div class="mt-5 text-base group-hover:text-primary font-bold font-title">{{ $name }}</div>
                            <div class="text-sm">{{ $description }}</div>
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

    <div class="container flex flex-wrap items-stretch justify-between max-w-[1462px] mt-20">
        <div class="md:w-[27%]  flex justify-between content-between items-stretch flex-col md:px-7 ">
            <div class="flex-1">
                <div class="font-title text-[24px] xl:text-[50px] font-bold uppercase text-primary">
                    BAN CỐ VẤN
                </div>
                <div class="text-sm mt-5 line-clamp-3">
                    {!! $text_general->{'mota'.$lang} !!}
                </div>
            </div>
            <div class="mt-4 md:mt-auto relative flex gap-3 mb-16">
                <div class="swiper-button-prev-bancovan w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                    <span class="material-icons">
                    chevron_left
                    </span>
                </div>
                <div class="swiper-button-next-bancovan w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex justify-center items-center"><span class="material-icons">
                    chevron_right
                    </span></div>
            </div>
        </div>
        <div class="md:w-[73%] w-full ">
            <!-- Slider main container -->
            <div class="swiper swiper-bancovan">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($banCoVan as $item)
                        @php
                            $name = $item->{"ten".$lang} ?? '';
                            $description = $item->{"mota".$lang} ?? '';
                            $photo = $item->photo ?? '';
                            $img = Thumb::Crop(UPLOAD_PHOTO, $photo ?? '', 270, 370, 1);
                        @endphp
                        <div class="swiper-slide text-center group">
                            <div style="background-image: url({{ $img }})" class="aspect-w-2 relative aspect-h-3 bg-cover rounded-[10px] overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-full hover:bg-doingu bg-doingupre bg-no-repeat bg-cover transition-all duration-300 "></div>
                            </div>
                            <div class="mt-5 text-base font-bold font-title group-hover:text-primary">{{ $name }}</div>
                            <div class="text-sm">{{ $description }}</div>
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
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            const swiper_doinguychuyengia = new Swiper('.swiper-doinguychuyengia', {
                // Optional parameters
                loop: true,
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
                navigation: {
                    nextEl: '.swiper-button-next-doinguychuyengia',
                    prevEl: '.swiper-button-prev-doinguychuyengia',
                },
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

            const swiper_bancovan = new Swiper('.swiper-bancovan', {
                // Optional parameters
                loop: true,
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
                navigation: {
                    nextEl: '.swiper-button-next-bancovan',
                    prevEl: '.swiper-button-prev-bancovan',
                },
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
