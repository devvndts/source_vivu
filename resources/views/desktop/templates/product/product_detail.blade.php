@php
    // $sale = get_sales('sale','vi')->toArray();
    $ajaxGiamoi = $row_detail['giamoi'];
    $ajaxGia = $row_detail['gia'];
    $ajaxGiakm = $row_detail['giakm'];

    // if (isset($sale[0]) && $sale[0]->hienthi && $sale[0]->sale_date > Carbon\Carbon::now()) {
    //     $ajaxGiamoi = $row_detail['sale_giamoi'];
    //     $ajaxGiakm = $row_detail['sale_giakm'];
    // }
    // $pricebetween = Helper::GetPriceBetween($row_detail['id']);
    // dd($pricebetween);
@endphp
@extends('desktop.master')
@section('element_detail', 'product_detail_content')
@section('center_detail', '')
@section('content')
<div class="container max-w-screen-xl pt-10">
    {{-- @include('desktop.layouts.product_top') --}}
    @php
    $ketnoi = get_photos('ketnoi', $lang);
    $default_sell = $row_detail['sell'] ?? 0;
    //### phần trăm đánh giá
    if ($info_rating == null) {
        $info_rating = [];
    }
    $phantram_onestar = isset($info_rating['allrating']) && $info_rating['allrating'] > 0 ? round(($info_rating['onestar'] * 100) / $info_rating['allrating']) : 0;
    $phantram_twostar = isset($info_rating['allrating']) && $info_rating['allrating'] > 0 ? round(($info_rating['twostar'] * 100) / $info_rating['allrating']) : 0;
    $phantram_threestar = isset($info_rating['allrating']) && $info_rating['allrating'] > 0 ? round(($info_rating['threestar'] * 100) / $info_rating['allrating']) : 0;
    $phantram_fourstar = isset($info_rating['allrating']) && $info_rating['allrating'] > 0 ? round(($info_rating['fourstar'] * 100) / $info_rating['allrating']) : 0;
    $phantram_fivestar = isset($info_rating['allrating']) && $info_rating['allrating'] > 0 ? round(($info_rating['fivestar'] * 100) / $info_rating['allrating']) : 0;
    $average_score = isset($info_rating['allrating']) && $info_rating['allrating'] > 0 ? round($info_rating['maxstar'] / $info_rating['allrating']) : 0;
    @endphp
    <div class="flex flex-wrap justify-between detail detail__container" id="page-product-detail">
        <div class="w-full lg:w-[47%] detail__left" id="gallery-photo-main">
            @include('desktop.templates.product.product-detail-image')
        </div>
        <div class="w-full min-w-0 lg:flex-1 lg:ml-5 detail_product_sticky">
            @include('desktop.templates.product.product-detail-info')
            
        </div>
    </div>
    @include('desktop.templates.product.product_content')
    <div class="mt-6 mb-10 text-4xl font-bold text-center text-primary">{{ __('site.product_other') }}</div>
    <div class="mb-5 product-swiper swiper">
        <div class="swiper-wrapper">
            @foreach ($products as $item)
            <x-product.item :item="$item" class="hidden !shadow-none [.swiper-initialized_&]:block swiper-slide "></x-product.item>	
            @endforeach
        </div>
    </div>
    {{-- <x-shared.readmore class="!flex mx-auto my-6 w-fit
    
    " title="{{ __('site.readmore') }}" href="san-pham">
        <x-slot name="icon"></x-slot>
    </x-shared.readmore> --}}
</div>
@endsection
<!--css thêm cho mỗi trang-->
@push('css_page')
    {{-- <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}"> --}}
@endpush
<!--js thêm cho mỗi trang-->
@push('js_page')
    <script>
        $(document).ready(function() {
            var slider__content__swiper = new Swiper(`.product-swiper`, {
                    slidesPerView: 2,
                    spaceBetween: 10,
                    speed: 800,
                    loop: true,
                    autoHeight: true,
                    pagination: {
                        el: `.product-swiper-pagination`,
                        type: "fraction",
                    },
                    navigation: {
                        nextEl: `.product-swiper-next`,
                        prevEl: `.product-swiper-prev`,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 4,
                        },
                    },
                });
        });
        // $(window).on('load', function() {
        //     var e_content_show = $('.product_active_tab').attr('data-id');
        //     $('.product-detail-content-item').removeClass('active_content');
        //     $(e_content_show).addClass('active_content');
        //     if ($("#gallery-photo-show-main").exists()) {
        //         $('.gallery-photo-item').removeClass('gallery-photo-show');
        //         $('#gallery-photo-show-main').addClass('gallery-photo-show');
        //     }
        // });
        // $('.product-detail-tab').click(function(){
        // 	var e_content_show = $(this).attr('data-id');
        // 	$('.product-detail-content-item').removeClass('active_content');
        // 	$(e_content_show).addClass('active_content');
        // 	$('.product-detail-tab').removeClass('product_active_tab');
        // 	$(this).addClass('product_active_tab');
        // });
        // $('.detail__product_shop').click(function() {
        //     $('.product_cuahang_main').addClass('product_cuahang_active');
        // });
        // $('.product_cuahang_close').click(function() {
        //     $('.product_cuahang_main').removeClass('product_cuahang_active');
        // });
    </script>
    {{-- <script src="{{ asset('js/product.js') }}"></script> --}}
@endpush
@push('strucdata')
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "{!! $row_detail['ten' . $lang] !!}",
            "image": [
                "{{ isset($row_detail['photo']) ? url('/') . '/' . UPLOAD_PRODUCT . $row_detail['photo'] : '' }}"
            ],
            "description": "{{ SEOMeta::getDescription() }}",
            "sku": "SP0{{ $row_detail['id'] }}",
            "mpn": "925872",
            "brand": {
                "@type": "Thing",
                @php
                    $productList = $setting['ten' . $lang];
                    if (isset($pro_list['ten' . $lang])) {
                        $productList = $pro_list['ten' . $lang];
                    }
                    $productList = $productList ?? '';
                @endphp "name": "{{ $productList }}"
            },
            "review": {
                "@type": "Review",
                "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                },
                "author": {
                    "@type": "Person",
                    "name": "{!! $setting['ten' . $lang] ?? '' !!}"
                }
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.4",
                "reviewCount": "89"
            },
            "offers": {
                "@type": "Offer",
                "url": "{{ url()->current() }}",
                "priceCurrency": "VND",
                "price": "{{ $row_detail['gia'] ?? 0 }}",
                "priceValidUntil": "2020-11-05",
                "itemCondition": "https://schema.org/UsedCondition",
                "availability": "https://schema.org/InStock",
                "seller": {
                    "@type": "Organization",
                    "name": "Executive Objects"
                }
            }
        }
    </script>
@endpush
