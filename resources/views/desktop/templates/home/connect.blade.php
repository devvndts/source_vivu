@php
$connects = get_photos('connect',$lang='vi');
@endphp
<div class="py-16 connect-home">
    <div class="container">
        <x-title>
            <x-slot name='title'>
                KẾT NỐI VỚI
            </x-slot>
            <x-slot name='icon'>
            </x-slot>
        </x-title>
        
        <div class="connect-items md:flex md:flex-wrap md:-m-2">
            @foreach ($connects as $key => $item)
            @php
                $name = $item->{'ten'.$lang};
                $opt = Helper::JsonDecode($item->sl_options);
                $url = $item->link;
                $img = Thumb::Crop(UPLOAD_PHOTO,$item->photo,390,345,2,$item->type);
                $icon = Thumb::Crop(UPLOAD_PHOTO,$item->background,30,30,2,$item->type);
            @endphp
            <div class="connect-item md:w-[calc(100%/3)] p-2">
                <div class="p-3 bg-white rounded-md shadow-sm shadow-md connect-item__box">
                    <figure class="mb-5"><a href="{{ $url }}"><img class="w-full" src="{{ $img }}" alt="{{ $name }}"></a></figure>
                    <div>
                        <img class="!inline-block" src="{{ $icon }}" alt="{{ $name }}"> 
                        <a href="{{ $url }}" class="ml-3 text-base font-semibold text-primary">{{ $name }}</a>
                    </div>
                    <div class="h-[1px] bg-[#845536] mt-5 mb-3"></div>
                    <div class="flex justify-between">
                        <div class="flex-auto text-base font-semibold text-secondary"><img class="!inline-block mr-3" src="{{ asset('img/like.png') }}" alt="title"> {{ $opt["like"] }}</div>
                        <div class="min-w-0 text-base font-semibold text-secondary"><img class="!inline-block mr-3" src="{{ asset('img/comment.png') }}" alt="title"> {{ $opt["comment"] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
	$(document).ready(function(){
        // $('.connect-slick').slick({
        //     lazyLoad: 'ondemand',
        //     infinite: false,
        //     accessibility: false,
        //     slidesToShow: 3,
        //     slidesToScroll: 1,
        //     autoplay: JS_AUTOPLAY,
        //     autoplaySpeed: 3000,
        //     speed: 1000,
        //     arrows: true,
        //     centerMode: false,
        //     dots: false,
        //     draggable: true,
        //     responsive: [
        //         {
        //             breakpoint: 850,
        //             settings: {
        //             slidesToShow: 2
        //             }
        //         },{
        //             breakpoint: 600,
        //             settings: {
        //                 slidesToShow: 2
        //             }
        //         },
        //         {
        //             breakpoint: 430,
        //             settings: { 
        //                 slidesToShow: 1
        //             }
        //         }
        //     ]
        // });
	});
</script>
@endpush