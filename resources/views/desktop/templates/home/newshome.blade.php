@php
$queryValues = ["noibat"=>"1"];
$tintucs = get_posts('tintuc',$lang,["query"=>$queryValues]);
$baochi = get_static('text-baochi2',$lang);
@endphp
<div class="py-16 news-article-home">
    <div class="container">
        <div class="flex flex-wrap justify-between news-article-home-wrap">
            <div class="w-full rounded-lg news-home lg:p-7 lg:shadow-xl lg:w-1/2">
                <div class="mb-4 text-xl font-bold text-center">BÀI VIẾT TIN TỨC</div>
                <div class="news-home-items">
                    @foreach ($tintucs as $key => $item)
                    @php
                        $name = $item->{'ten'.$lang};
                        $url = $item->{$sluglang};
                        $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_POST,$item->photo,300,200,2,$item->type), $name, asset('img/noimage.png'));
                        $date = date('d/m/Y', $item->ngaytao);
                        $desc = $item->{'mota'.$lang};
                    @endphp
                    <div class="flex justify-between py-5 news-home-item">
                        <a href="{{ $img }}" class="news-home-item__image w-[40%] ">
                            {!! $img !!}
                        </a>
                        <div class="flex-1 min-w-0 ml-6 news-home-item__info">
                            <div class="mt-4 mb-2 text-base text-gray-700">{{ $date }}</div>
                            <div class="mb-2 text-base font-medium text-[#000] line-clamp-2">{{ $name }}</div>
                            <div class="text-sm text-black line-clamp-2">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex mt-4">
                    <x-button title="{{ __('site.readmore') }}" href="#" class="block mx-auto w-fit">
                        <x-slot name="icon"></x-slot>
                    </x-button>
                </div>
            </div>
            @isset($baochi)
            @php
                $name = $baochi->{'ten'.$lang};
                $url = url("bao-chi");
                $img = sprintf('<img class="w-full" src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_STATICPOST,$baochi->photo,545,415,1,$baochi->type), $name, asset('img/noimage.png'));
                $date = date('d/m/Y', $baochi->ngaytao);
                $desc = $baochi->{'mota'.$lang};
            @endphp
            <div class="flex flex-col w-full min-w-0 article-home lg:ml-8 lg:flex-1 p-7">
                <div class="mb-4 text-xl font-bold text-center">BÁO CHÍ NÓI GÌ VỀ NATURAL PHARM</div>
                <div class="">
                    <a href="{{ $url }}" class="block mb-8">
                        {!! $img !!}
                    </a>
                    <div class="">
                        <div class="mt-4 mb-2 text-base text-gray-700">{{ $date }}</div>
                        <div class="mb-2 text-base font-medium text-[#000] line-clamp-2">{{ $name }}</div>
                        <div class="text-sm text-black line-clamp-3">{{ $desc }}</div>
                    </div>
                </div>
                <div class="flex mt-5">
                    <x-button title="{{ __('site.readmore') }}" href="{{ $url }}" class="block mx-auto w-fit">
                        <x-slot name="icon"></x-slot>
                    </x-button>
                </div>
            </div>
            @endisset
        </div>
    </div>
</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
	$(document).ready(function(){
	});
</script>
@endpush