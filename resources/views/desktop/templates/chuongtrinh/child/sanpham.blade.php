@if ($data['sanphamhocvien'])
<div class="detail-sanpham py-20 bg-[#F0F2F5]">
    <x-shared.title class="text-center">
        <x-slot name="title">{{ __('Sản phẩm học viên') }}</x-slot>
    </x-shared.title>
    <div class="container max-w-[800px] relative mt-7">
        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
            class="swiper swiper-detailsanpham">
            <div class="swiper-wrapper">
                @foreach ($data['sanphamhocvien'] as $item)
                    @php
                        $name = $item["ten$lang"] ?? '';
                        $description = $item["mota$lang"] ?? '';
                        $photoUrl = $item["photo"] ?? '';
                        $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 1140, 750, 1);
                    @endphp
                    <div class="swiper-slide p-4">
                        <a target="_blank" href="{{ $name }}" class="aspect-w-5 bg-no-repeat overflow-hidden bg-cover aspect-h-3 rounded-xl filter drop-shadow-lg block" style="background-image: url({{ $photo }}); --tw-drop-shadow: 0px 4px 27px rgba(255, 0, 0, 0.5);">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container max-w-[1382px] mt-8">
        <div thumbsSlider="" class="swiper swiper-detailsanphamthumb">
            <div class="swiper-wrapper">
                @foreach ($data['sanphamhocvien'] as $item)
                    @php
                        $name = url($item["ten$lang"]) ?? '';
                        $description = $item["mota$lang"] ?? '';
                        $photoUrl = $item["photo"] ?? '';
                        $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 1140, 750, 1);
                    @endphp
                    <div class="swiper-slide">
                        <div class="aspect-w-5 bg-no-repeat overflow-hidden bg-cover aspect-h-3 rounded-xl" style="background-image: url({{ $photo }})">
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
            var swiper_detailsanphamthumb = new Swiper(".swiper-detailsanphamthumb", {
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 3000,
                },
                spaceBetween: 24,
                slidesPerView: 3,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    768: {
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 42,
                    }
                },
            });
            var swiper_detailsanpham = new Swiper(".swiper-detailsanpham", {
                loop: true,
                spaceBetween: 10,
                // navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev",
                // },
                thumbs: {
                    swiper: swiper_detailsanphamthumb,
                },
            });
        });
    </script>
@endpush
@endif