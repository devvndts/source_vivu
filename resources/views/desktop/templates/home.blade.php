@php
    $text_general = get_static('text-general', $lang);
    // $dich_vu = get_posts('dich-vu', $lang, ['query' => ['noibat' => '1']]);
    // $tin_tuc = get_posts('tin-tuc', $lang, ['query' => ['noibat' => '1']]);
    // $feedback = get_posts('feedback', $lang, ['order_by' => ['stt' => 'asc']]);
    // $text_feedback = get_static('text-feedback', $lang);
    // $hoi_dap = get_posts('hoi-dap', $lang, ['limit' => 5]);
    // $slogan = get_posts('slogan', $lang, ['order_by' => ['stt' => 'asc']]);
    // $gioi_thieu = get_static('gioi-thieu', $lang);
    // $criteria = get_posts('criteria', $lang, ['order_by' => ['stt' => 'asc']]);
    // $partner = get_photos('partner', $lang, ['order_by' => ['stt' => 'asc']]);
    // $quangcao = get_photos('quangcao', $lang, ['order_by' => ['stt' => 'asc']]);
    // $banner_1 = get_static_photo('banner_1');
    
    // $productCategories = get_categories('product', $lang, ['query' => ['level' => '0']]);
    // $productNoibat = get_products('product', $lang, ['query' => ['noibat' => '1']]);
    // $partner = get_photos('partner', $lang, ['order_by' => ['stt' => 'asc'], 'limit' => 12]);
@endphp
@extends('desktop.master')
@section('element_detail', 'home_content')
@section('content')
    <x-home.bandangtimkiem></x-home.bandangtimkiem>
    <x-home.khuvucganday></x-home.khuvucganday>
    <x-home.nhungdiadiemnoibat></x-home.nhungdiadiemnoibat>
    {{-- <x-home.gioithieuchung></x-home.gioithieuchung>
    <x-home.giatri></x-home.giatri>
    <div class="relative overflow-hidden">
        <img src="public/pts/dichvudaotao.png" alt="dichvudaotao" class="absolute top-0 left-0 z-10 ">
        <img src="public/pts/chuongtrinh.png" alt="chuongtrinh" class="absolute -bottom-[270px] right-0 z-10 ">
        <div class="relative z-30">
            <x-home.dichvudaotao></x-home.dichvudaotao>
        </div>
    </div>
    <x-home.chuongtrinhdaotao></x-home.chuongtrinhdaotao>
    <x-home.doinguchuyengia></x-home.doinguchuyengia>
    <x-home.quangcao></x-home.quangcao>
    <x-home.danhgia></x-home.tintuc>
    <x-home.tintuc></x-home.tintuc>
    <x-home.doitac></x-home.doitac> --}}
    
@endsection


<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush
<!--js thêm cho mỗi trang-->
@push('js_page')
    <script>
        $(document).ready(function() {
            // var swiperNews = new Swiper(".swiper-news", {
            //     effect: "coverflow",
            //     grabCursor: true,
            //     centeredSlides: true,
                
            //     coverflowEffect: {
            //         rotate: 0,
            //         stretch: 70,
            //         depth: 100,
            //         scale: 0.9,
            //         modifier: 2,
            //         slideShadows: false,
            //     },
            //     loop: true,
            //     navigation: {
            //         nextEl: '.swiper-news-button-next',
            //         prevEl: '.swiper-news-button-prev',
            //     },
            //     pagination: {
            //         el: '.swiper-news-pagination',
            //     },
            //     breakpoints: {
            //         320: {
            //             slidesPerView: 1,
            //         },
            //         1024: {
            //             slidesPerView: 1.3,
            //         }
            //     }
            // });
            // const swiperQuangcao = new Swiper('.swiper-quangcao', {
            //     loop: true,
            //     slidesPerView: 1,
            // });
            // var swiperHomeProduct = new Swiper('.swiper-home-product', {
            //     loop: true,
            //     speed: 800,
            //     slidesPerView: 1,
            //     navigation: {
            //         nextEl: '.swiper-home-product-button-next',
            //         prevEl: '.swiper-home-product-button-prev',
            //     },
            // });
            // var swiperHomeProductName = new Swiper('.swiper-home-product-name', {
            //     loop: true,
            //     speed: 800,
            //     slidesPerView: 1,
            // });
            // swiperHomeProduct.on('slideChange', function () {
            //     let index = swiperHomeProduct.realIndex;
            //     let per= (parseInt(index)+1)*10;
            //     swiperHomeProduct.slideToLoop(index, 800, null);
            //     swiperHomeProductName.slideToLoop(index, 800, null);
            // });
            // const swiperCriteria = new Swiper('.swiper-criteria', {
            //     loop: true,
            //     breakpoints: {
            //         320: {
            //             slidesPerView: 2,
            //         },
            //         1024: {
            //             slidesPerView: 4,
            //         }
            //     }
            // });
            // const swiperPartner = new Swiper('.swiper-partner', {
            //     loop: true,
            //     spaceBetween: 24,
            //     navigation: {
            //         nextEl: '.swiper-partner-button-next',
            //         prevEl: '.swiper-partner-button-prev',
            //     },
            //     pagination: {
            //         el: '.swiper-partner-pagination',
            //     },
            //     breakpoints: {
            //         320: {
            //             slidesPerView: 2,
            //         },
            //         640: {
            //             slidesPerView: 3,
            //         }
            //     }
            // });
            // const swiperFeedback = new Swiper('.swiper-feedback', {
            //     loop: true,
            //     effect: 'fade',
            //     fadeEffect: {
            //         crossFade: true
            //     },
            //     slidesPerView: 1,
            //     navigation: {
            //         nextEl: '.swiper-feedback-button-next',
            //         prevEl: '.swiper-feedback-button-prev',
            //     },
            // });
        });
    </script>
@endpush
