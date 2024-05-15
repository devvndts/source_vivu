@php
	$feedback = get_posts('feedback', $lang,  ["order_by" => ["stt" => "asc"]]);
	$feedback2 = get_posts('feedback2', $lang,  ["order_by" => ["stt" => "asc"]]);
@endphp
<div class="home-danhgia mt-20" id="hoc_vien_doanh_nghiep">
    <div class="container max-w-[1483px]">
        <img src="public/pts/danhgia.png" alt="danhgia" class="mx-auto">
        <div class="xl:flex gap-[90px] flex-wrap justify-between mt-4 py-14  relative">
            <div class="absolute left-0 top-0 w-full h-full bg-orange-500 bg-opacity-10 rounded-tl-[160px] rounded-tr-[160px] hidden xl:block"></div>
            <div class="w-full mx-auto max-w-[585px] md:px-10">
                <div class="text-primary font-bold font-title mt-12 text-2xl uppercase">HỌC VIÊN NÓI GÌ VỀ CHÚNG TÔI</div>
                <div class="swiper swiper-hocvien mt-12">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
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
                        <div class="swiper-slide ">
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
                        </div>
                        @endforeach
                    </div>
                    <div class="absolute z-20 right-0 top-0 flex gap-3">
                        <div class="swiper-button-prev-hocvien w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                            <span class="material-icons">
                            chevron_left
                            </span>
                        </div>
                        <div class="swiper-button-next-hocvien w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex justify-center items-center"><span class="material-icons">
                            chevron_right
                            </span></div>
                    </div>
                </div>
            </div>
            <hr class="h-[414px] hidden xl:block w-[1px] bg-[#404040]/30">
            <div class="w-full mx-auto max-w-[585px] md:px-10">
                <div class="text-primary font-bold font-title mt-12 text-2xl uppercase">DOANH NGHIỆP NÓI GÌ VỀ CHÚNG TÔI</div>
                <div class="swiper swiper-doanhnghiep mt-12">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
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
                        <div class="swiper-slide ">
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
                        </div>
                        @endforeach
                    </div>
                    <div class="absolute z-20 right-0 top-0 flex gap-3">
                        <div class="swiper-button-prev-doanhnghiep w-[33px] h-[33px] rounded-full border border-[#404040] text-[#404040] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                            <span class="material-icons">
                            chevron_left
                            </span>
                        </div>
                        <div class="swiper-button-next-doanhnghiep w-[33px] h-[33px] rounded-full border border-[#404040] transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#404040] flex justify-center items-center"><span class="material-icons">
                            chevron_right
                            </span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            const swiper_hocvien = new Swiper('.swiper-hocvien', {
                // Optional parameters
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 3000,
                },
                slidesPerView: 1,

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next-hocvien',
                    prevEl: '.swiper-button-prev-hocvien',
                },

            });
            const swiper_doanhnghiep = new Swiper('.swiper-doanhnghiep', {
                // Optional parameters
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 3000,
                },
                slidesPerView: 1,

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next-doanhnghiep',
                    prevEl: '.swiper-button-prev-doanhnghiep',
                },

            });
        });
    </script>
@endpush