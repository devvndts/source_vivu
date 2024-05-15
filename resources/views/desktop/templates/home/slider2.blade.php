@php
    $slider2 = get_photos('slide2',$lang='vi');
@endphp
@isset($slider2)
<div class="slider2-home">
<div class="container">
    <div class="text-red-900 slider-main">
        @foreach ($slider2 as $key => $item)
        @php
            $name = $item->{"ten$lang"};
            $desc = $item->{"mota$lang"};
            $url = $item->link;
            $opt = Helper::JsonDecode($item->sl_options);
            $xhtmlName = ($name) ? sprintf('<h5 class="text-[20px] line-clamp-2 md:text-[32px] md:line-clamp-3 leading-tight text-center md:text-left"><a href="%s">%s</a></h5>', $url, $name) : '';
            $xhtmlDesc = ($desc) ? sprintf('<p class="md:w-1/4 md:mt-[320px] text-[14px] line-clamp-4 text-last-center text-justify md:text-left">%s</p>', $desc) : '';
            $xhtmlSlogan = ($opt["slogan$lang"]) ? sprintf('<div class="text-center md:text-left"><span class="text-[12px] md:text-[14px]">%s</span></div>',$opt["slogan$lang"]) : '';
            $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_PHOTO,$item->photo,550,570,2,$item->type), $name, asset('img/noimage.png'));
        @endphp
        <div class="slider2-item slick-slide">
            <div class="slider2-item__box md:flex md:flex-nowrap md:justify-between pb-[24px] md:pb-0">
                <a class="md:w-[43.5%]" href="{{ $url }}">
                    {!! $img !!}
                </a>
                <div class="slider2-item__info md:w-[27.5%] md:mt-[130px]">
                    {!! $xhtmlSlogan !!}
                    {!! $xhtmlName !!}
                </div>
                {!! $xhtmlDesc !!}
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>
@endisset
<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
	$(document).ready(function(){
		$('.slider-main').slick({
            lazyLoad: 'ondemand',
            infinite: false,
            accessibility: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: JS_AUTOPLAY,
            autoplaySpeed: 3000,
            speed: 1000,
            arrows: true,
            centerMode: false,
            dots: false,
            draggable: true,
        });
	});
</script>
@endpush