@if ($gallery_color)
    @foreach ($gallery_color as $g => $gal)
        <div id="gallery-photo-show-{{ $g }}" class="clearfix gallery-photo-item">
            @php
                $galleries = $gal;
            @endphp
            <div class="detail__gallery_right">
                @if ($galleries)
                    <div class="detail__gallery_list">
                        @foreach ($galleries as $k => $v)
                            <a id="gallery-photo-{{ $v['id'] }}" title="{{ $v['ten' . $lang] }}">
                                <img
                                    src="{{ Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 600, 790, 1, $v['com']) }}"
                                    alt="{{ $v['ten' . $lang] }}">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="detail__gallery_left">
                @if ($galleries)
                    <div class="detail__gallery_auto">
                        @foreach ($galleries as $k => $v)
                            <a class="thumb-pro-detail gallery-photo-scroll" data-zoom-id="Zoom-1"
                                href="#gallery-photo-{{ $v['id'] }}" title="{{ $v['ten' . $lang] }}">
                                <img src="{{ Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 600, 790, 1, $v['com']) }}"
                                    alt="{{ $v['ten' . $lang] }}">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@else
    <div class="relative">
        <div class="relative">
            @php
                $item = $row_detail;
                $imgBig = Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 600, 790, 3, $row_detail['type']);
                $imgSmall = Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 600, 790, 3, $row_detail['type']);
            @endphp
            <a href="{{ $imgBig }}" class="MagicZoom !mx-auto !block  w-fit" id="mg_zoom" data-options="zoomMode: off" >
                <img class="w-full" src="{{ $imgSmall }}" />
            </a>
        </div>
        <div class="absolute z-20 mg-thumbs left-3 top-3 ">
            <div class="w-11 mg-thumbs-slick">
                @php
                    $item = $row_detail;
                    $imgBig = Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 600, 790, 3, $row_detail['type']);
                    $imgSmall = Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 600, 790, 3, $row_detail['type']);
                    $imgTiny = Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 200, 260, 3, $row_detail['type']);
                @endphp
                <div class="my-1 slick-slide">
                    <a data-zoom-id="mg_zoom" class="border h-11 block bg-white border-solid border-black overflow-hidden rounded-md [.slick-current_&]:opacity-100 opacity-50" href="{{ $imgBig }}" data-image="{{ $imgSmall }}">
                        <img class="w-full " src="{{ $imgTiny }}" />
                    </a>
                </div>

                @if ($hinhanhsp)
                    @foreach ($hinhanhsp as $item)
                    @php
                        $imgBig = Thumb::Crop(UPLOAD_PRODUCT, $item['photo'], 600, 790, 3, $item['type']);
                        $imgSmall = Thumb::Crop(UPLOAD_PRODUCT, $item['photo'], 600, 790, 3, $item['type']);
                        $imgTiny = Thumb::Crop(UPLOAD_PRODUCT, $item['photo'], 200, 260, 3, $item['type']);
                    @endphp
                    <div class="my-1 slick-slide">
                        <a data-zoom-id="mg_zoom" class="border  h-11 border-black border-solid overflow-hidden rounded-md [.slick-current_&]:opacity-100 block bg-white opacity-50" href="{{ $imgBig }}" data-image="{{ $imgSmall }}">
                            <img class="w-full " src="{{ $imgTiny }}" />
                        </a>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- <div id="gallery-photo-show-main" class="gallery-photo-item">
        <div class="flex flex-wrap justify-between detail__gallery_right">
            <div class="w-full lg:w-[86%] lg:order-1 ml-2 detail__gallery_list slick-product-one">
                <a href="{{ Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 900, 670, 2, $row_detail['type']) }}" id="gallery-photo-main" title="{{ $row_detail['ten' . $lang] }}"
                    class="gallery-photo-first MagicZoom" data-options="zoomPosition: inner">
                    <img class="mx-auto"
                        src="{{ Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 550, 410, 2, $row_detail['type']) }}"
                        alt="{{ $row_detail['ten' . $lang] }}">
                </a>
                @if ($hinhanhsp)
                    @foreach ($hinhanhsp as $k => $v)
                        <a href="{{ Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 900, 670, 2, $row_detail['type']) }}" id="gallery-photo-{{ $v['id'] }}" title="{{ $v['ten' . $lang] }}" class="MagicZoom" data-options="zoomPosition: inner">
                            <img
                                src="{{ Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 550, 410, 1, $v['type']) }}"
                                alt="{{ $v['ten' . $lang] }}">
                            </a>
                    @endforeach
                @endif
            </div>
            @if ($hinhanhsp)
                <div class="flex-1 min-w-0 detail__gallery_mainthumb">
                    <div class="/detail__gallery_thumb /owl-carousel /owl-theme slick-product-list">
                        <a title="{{ $row_detail['ten' . $lang] }}"
                            class="inline-flex p-1 mb-4 shadow-sm gallery-thumb-first ">
                            <img
                                src="{{ Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 100, 100, 2, $row_detail['type']) }}"
                                alt="{{ $row_detail['ten' . $lang] }}">
                        </a>
                        @foreach ($hinhanhsp as $k => $v)
                            <a id="gallery-photo-{{ $v['id'] }}" title="{{ $v['ten' . $lang] }}"
                                class="inline-flex p-1 mb-4 shadow-sm ">
                                <img
                                    src="{{ Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 100, 100, 2, $v['type']) }}"
                                    alt="{{ $v['ten' . $lang] }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div> --}}
@endif

<!--css thêm cho mỗi trang-->
@push('css_page')
    <link rel="stylesheet" href="{{ asset('css/magiczoomplus.css') }} ">
@endpush
<!--js thêm cho mỗi trang-->
@push('js_page')
    <script src="{{ asset('js/magiczoomplus.js') }}"></script>
    <script>
        $('.mg-thumbs-slick').slick({
            slidesToShow: 14,
            slidesToScroll: 1,
            dots: false,
            infinite: false,
            vertical: true,
            verticalSwiping: true,
            focusOnSelect: true,
            arrows: false,
            autoplay: false,
        }).on('afterChange', function(event, slick, currentSlide, nextSlide){
            var img = slick.$slides[currentSlide].children[0].dataset.image;
            MagicZoom.update("mg_zoom", img, img);
        });
    </script>
@endpush