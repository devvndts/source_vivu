@php
    $productNoibat = get_products('product', $lang, ['query' => ['noibat' => '1']]);
@endphp
@if ($productNoibat)
<div class="pb-12">
    <div class="container max-w-screen-xl">
        <x-shared.title class="text-center">
            <x-slot name="title">{{ __('Sản phẩm') }}</x-slot>
        </x-shared.title>
        <div class="relative">
            <div class="swiper-home-product-button-prev w-[40px] h-[40px] bg-primary text-white inline-flex justify-center items-center rounded-full absolute left-0 top-1/2 -mt-5 z-20">
                <span class="material-icons">
                    chevron_left
                    </span>
            </div>
            <div class="swiper-home-product-button-next w-[40px] h-[40px] bg-primary text-white inline-flex justify-center items-center rounded-full absolute right-0 top-1/2 -mt-5 z-20">
                <span class="material-icons">
                    chevron_right
                    </span>
            </div>
            <div class="swiper swiper-home-product max-w-[1050px] mx-auto">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($productNoibat as $item)
                    @php
                        $name = $item->{'ten'.$lang} ?? '';
                        $desc = $item->{'mota'.$lang} ?? '';
                        $url = url($item->{$sluglang} ?? '');
                        $img = Thumb::Crop(UPLOAD_PRODUCT, $item->photo ?? '', 300, 430, 1);   
                    @endphp
                    <div class="swiper-slide revealOnScroll" data-animation="animate__fadeInUp" timeout="500">
                        <a href="{{ $url }}">
                            <figure class="mb-[5px] mx-auto overflow-hidden">
                                <x-shared.image class="w-full transition duration-300 ease-in-out hover:scale-110" src="{{ $img }}" />
                            </figure>
                            <h3 class="text-base font-semibold text-center uppercase line-clamp-2">{{ $name }}</h3>
                        </a>
                    </div>
                    @endforeach
                </div>
                <!-- If we need navigation buttons -->
                
            </div>
            <div class="flex justify-center">
                <x-shared.readmore class="my-10" href="{{ url('san-pham') }}" >
                </x-shared.readmore>
            </div>
        </div>
        
    </div>
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            const swiperHomeProduct = new Swiper('.swiper-home-product', {
                loop: true,
                autoplay: JS_AUTOPLAY && {
                    delay: 5000,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 12,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 78,
                    }
                },
                navigation: {
                    nextEl: '.swiper-home-product-button-next',
                    prevEl: '.swiper-home-product-button-prev',
                },
            });
        });
    </script>
@endpush
@endif