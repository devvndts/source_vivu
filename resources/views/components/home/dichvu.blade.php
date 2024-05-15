@php
    $gioi_thieu = get_static('text-dichvu', $lang);
    $name = $gioi_thieu->{'ten'.$lang} ?? '';
    $desc = $gioi_thieu->{'mota'.$lang} ?? '';
    $url = url('dich-vu');
    $dich_vu = get_posts('dich-vu', $lang, ['query' => ['noibat' => '1']]);
@endphp
<div class="bg-opacity-50 bg-secondary py-[105px] relative">
    <img src="img/sv-left.png" alt="l" class="absolute top-0 left-0">
    <img src="img/sv-right.png" alt="r" class="absolute top-0 right-0">
    <div class="container max-w-screen-xl mx-auto">
        <x-shared.title class="text-center revealOnScroll" data-animation="animate__zoomIn" timeout="500">
            <x-slot name="title">{{ $name }}</x-slot>
            <x-slot name="desc">{{ $desc }}</x-slot>
        </x-shared.title>
        <div class="text-center">
            <x-shared.readmore class="!inline-block" href="{{ $url }}" ></x-shared.readmore>
        </div>

        <div class="relative">
            <div class="swiper swiper-service mt-[80px]">
                <div class="swiper-wrapper">
                    @foreach ($dich_vu as $item)
                        @php
                            $name = $item->{"ten$lang"};
                            $desc = $item->{"mota$lang"};
                            $photo = Thumb::Crop(UPLOAD_POST, $item->photo, 400, 300, 1);
                            $url = $item->{$sluglang};
                        @endphp
                        <div class="text-center swiper-slide revealOnScroll" data-animation="animate__zoomIn" timeout="500">
                            <a href="{{ $url }}">
                                <div class="rounded-tl-[170px] rounded-tr-[170px] overflow-hidden border-[1px] border-solid border-primary">
                                    <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="" />
                                </div>
    
                                <div class="px-4 py-6 text-white bg-primary">
                                    <div class="text-lg uppercase font-title">{{ $name }}</div>
                                    <div class="my-[10px] text-sm">{{ $desc }}</div>
                                    <div class="text-base font-semibold uppercase"><span>{{ __('Xem thêm') }}</span></div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-full z-20 absolute top-1/2 -mt-5 left-2 lg:-left-12 inline-flex justify-center opacity-70 transition-all hover:opacity-100 items-center swiper-service-button-prev border-[1px] border-primary w-[40px] h-[40px]"><span class="material-icons">
                chevron_left
                </span></div>
            <div class="swiper-service-button-next z-20 absolute top-1/2 -mt-5 right-2 lg:-right-12 inline-flex justify-center opacity-70 hover:opacity-100 transition-all items-center border-[1px] border-primary w-[40px] h-[40px] rounded-full"><span class="material-icons">
                chevron_right
                </span></div>
        </div>
    </div>
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            const swiper_service = new Swiper('.swiper-service', {
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 5000,
                },
                navigation: {
                    nextEl: '.swiper-service-button-next',
                    prevEl: '.swiper-service-button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    820: {
                        slidesPerView: 3,
                        spaceBetween: 50,
                    }
                }
            });
        });
    </script>
@endpush