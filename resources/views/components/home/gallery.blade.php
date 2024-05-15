@php
    $partner = get_photos('partner', $lang, ['order_by' => ['stt' => 'asc']]);
@endphp
<div class="pt-[78px] pb-[130px] bg-yodiva bg-no-repeat bg-cover">
    <div class="flex flex-wrap revealOnScroll justify-center mb-[30px]" data-animation="animate__zoomIn" timeout="500">
        <span class="font-title text-[48px] inline-block mr-5">Store Yodiva</span>
        <x-shared.image src="img/Spa.png" alt="Logo" class="" />
    </div>

    <div class="swiper swiper-gallery">
        <div class="swiper-wrapper">
            @foreach ($partner as $item)
                @php
                    $name = $item->{"ten$lang"};
                    $desc = $item->{"mota$lang"};
                    $photo = Thumb::Crop(UPLOAD_PHOTO, $item->photo, 400, 300, 1);
                    $url = $item->link;
                @endphp
                <div class="swiper-slide revealOnScroll" data-animation="animate__zoomIn" timeout="500">
                    <div>
                        <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="w-full" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            const swiper_gallery = new Swiper('.swiper-gallery', {
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 5000,
                },
                pagination: {
                    el: '.swiper-main-pagination',
                    clickable: true,
                },
                breakpoints: {
                    320: {
                        spaceBetween: 20,
                        slidesPerView: 2.4,
                    },
                    640: {
                        spaceBetween: 20,
                        slidesPerView: 3.3,
                        slidesOffsetBefore: 40,
                        slidesOffsetAfter: 40,
                    },
                    1024: {
                        // centeredSlides: true,
                        spaceBetween: 20,
                        slidesPerView: 4.4,
                        slidesOffsetBefore: 80,
                        slidesOffsetAfter: 80,
                    }
                },
            });
        });
    </script>
@endpush