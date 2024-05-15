@php
$partners = get_photos('partner',$lang='vi',$options=null)->toArray();
@endphp
<div class="partner-home bg-[#F7FCF0] py-16">
    <div class="container">
        <x-title>
            <x-slot name='title'>
                mua sắm sản phẩm
            </x-slot>
            <x-slot name='icon'>
            </x-slot>
        </x-title>
        
        @if ($partners)
        <div class="partner-slick">
            @foreach ($partners as $item)
            @php
                $name = $item->{'ten'.$lang};
                $url = $item->link;
                $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_PHOTO,$item->photo,150,70,2,$item->type), $name, asset('img/noimage.png'));
            @endphp
            <div class="px-4 partner-item slick-slide">
                <a class="block border rounded-sm border-primary " href="{{ $url }}">
                    {!! $img !!}
                </a>
            </div>  
            @endforeach
        </div>
        @endif
    </div>
    
</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
	$(document).ready(function(){
        $('.partner-slick').slick({
            lazyLoad: 'ondemand',
            infinite: false,
            accessibility: false,
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: JS_AUTOPLAY,
            autoplaySpeed: 3000,
            speed: 1000,
            arrows: true,
            centerMode: false,
            dots: false,
            draggable: true,
            responsive: [
                {
                    breakpoint: 850,
                    settings: {
                    slidesToShow: 4
                    }
                },{
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 430,
                    settings: { 
                        slidesToShow: 2
                    }
                }
            ]
        });
	});
</script>
@endpush