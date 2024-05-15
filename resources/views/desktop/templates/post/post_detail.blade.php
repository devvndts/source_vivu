@extends('desktop.master')

@section('content')
<div class="container max-w-screen-xl ">
    {{-- <x-shared.subtitle title="{{ $title_crumb }}" /> --}}
    <div class="flex justify-between py-10">
        <div class="hidden w-1/4 mr-5 lg:block">
            <p class="mb-5 text-base font-bold">{{ __('Bài viết khác') }}</p>
            @if ($posts->count() > 0)
                @foreach ($posts as $item)
                @php
                    if ($loop->index > 4) break;
                    $data["name"] = $item->{"ten$lang"};
                    $data["desc"] = $item->{"mota$lang"};
                    $data["url"] = $item->{$sluglang};
                    $data["post_date"] = date('D m, Y', $item->ngaytao);
                    $post_type = $item->type ?? null;
                    $data["img"] = Thumb::Crop(UPLOAD_POST, $item->photo, 330, 245, 1, $post_type);
                @endphp
                    <x-blog.toppost :data="$data" />
                @endforeach
            @endif
        </div>
        <div class="w-full lg:w-3/4">
            @php
                $dataDetail["name"] = $row_detail["ten$lang"];
                $dataDetail["desc"] = $row_detail["mota$lang"];
                $dataDetail["content"] = $row_detail["noidung$lang"];
                $dataDetail["url"] = $row_detail[$sluglang];
                $dataDetail["post_date"] = date('D m, Y', $row_detail["ngaytao"]);
                $post_type = $row_detail["type"] ?? null;
                $dataDetail["img"] = Thumb::Crop(UPLOAD_POST, $row_detail["photo"], 1050, 615, 1, $post_type);
            @endphp
            <h1 class="text-3xl font-bold mb-7">{{ $dataDetail['name'] }}</h1>
            <div class="relative mb-5 overflow-hidden ">
                <figure class="z-10 bg-cover aspect-w-10 aspect-h-6" style="background-image: url({{ $config_base . $dataDetail["img"] }})"></figure>
            </div>

            <div class="flex flex-wrap justify-between">
                
                <div class="w-full ">
                    @if (isset($dataDetail['content']) && !empty($dataDetail['content']))
                    <x-shared.content>
                        {!! $dataDetail['content'] !!}
                    </x-shared.content>
                    @endif
                </div>
                <div class="w-full mt-4">
                    {{-- <p class="text-sm text-[#5D5F5F]">Written by</p>
                    <p class="mb-4 text-sm text-black">Admin</p> --}}
                    <p class="text-sm text-[#5D5F5F]">Follow us</p>
                    <x-shared.share2 />
                </div>
            </div>

            
        </div>
    </div>
    
</div>
{{-- <div class="flex flex-wrap justify-between max-w-screen-xl pt-5 mb-5 detail-page-post bortop">
    <div class="w-full">
        <div class="bg-white rounded">
            <x-shared.subtitle title="{{ $row_detail['ten'.$lang] }}" />
            <div class="mb-3 text-muted d-none"><small>{{ngaydang}}: {{date("d/m/Y h:i A",$row_detail['ngaytao'])}}</small></div>
    
            @if (@$hinhanhsp)
                @include('desktop.layouts.swiper', ['galPath' => UPLOAD_POST])
            @endif
    
            @if(isset($row_detail['video']) && $row_detail['video'] != '')
                <div class="content-video"><iframe src="//www.youtube.com/embed/{{Helper::getYoutube($row_detail['video'])}}" width="100%" height="0px" frameborder="0" allowfullscreen></iframe></div>
            @endif
    
            @if(isset($row_detail['noidung'.$lang]) && $row_detail['noidung'.$lang] != '')
                <div class="meta-toc">
                    <div class="box-readmore">
                        <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
                    </div>
                </div>
                <div class="content-main w-clear" id="toc-content">{!! $row_detail['noidung'.$lang] !!}</div>
                <x-shared.share />
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>{{ __('Nội dung đang cập nhật') }}</strong>
                </div>
            @endif
        </div>
        <div class="p-3 my-3 rounded othernews">
            <b class="othernews_title">{{baivietkhac}}:</b>
            <ul class="list-news-other">
                @if(isset($posts) && count($posts) > 0)
                    @foreach($posts as $k=>$v)
                    <li><a class="text-decoration-none" href="{{$v['tenkhongdauvi']}}" title="{{$v['ten'.$lang]}}">
                        {{$v['ten'.$lang]}}
                    </a></li>
                    @endforeach
                @endif
            </ul>
            <div class="row">
               <div class="col-sm-12 dev-center dev-paginator">{{ $posts->render('desktop.layouts.paginator') }}</div>
            </div>
        </div>
    
        <!--HỎI ĐÁP-->
        @include('desktop.layouts.hoidap') 
    </div>
</div> --}}
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
    {{-- @if (@$hinhanhsp)
        <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    @endif --}}

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
    {{-- @if (@$hinhanhsp)
        <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                const swiper = new Swiper('.swiper', {
                // Optional parameters
                // direction: 'vertical',
                // loop: true,
    
                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                },
    
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
    
                // And if we need scrollbar
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
                });
            });
        </script>
        
    @endif --}}
    <!-- Like Share -->
    <script src="//sp.zalo.me/plugins/sdk.js"></script>

    <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55e11040eb7c994c" async="async"></script>
    <script type="text/javascript">
        var addthis_config = addthis_config||{};
        addthis_config.lang = LANG
    </script>

    
@endpush


@push('strucdata')
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage":
            {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "{!!$row_detail['ten'.$lang]!!}",
            "image":
            [
                "{{ (isset($row_detail['photo']))?url('/').'/'.UPLOAD_POST.$row_detail['photo']:'' }}"
            ],
            "datePublished": "{{date('Y-m-d',$row_detail['ngaytao'])}}",
            "dateModified": "{{date('Y-m-d',$row_detail['ngaysua'])}}",
            "author":
            {
                "@type": "Person",
                "name": "{!!$setting['ten'.$lang]!!}",
                "url": "{{url()->current()}}"
            },
            "publisher":
            {
                "@type": "Organization",
                "name": "Google",
                "logo":
                {
                    "@type": "ImageObject",
                    "url": "{{ (isset($logo))?url('/').'/'.UPLOAD_PHOTO.$logo['photo']:'' }}"
                }
            },
            "description": "{{SEOMeta::getDescription()}}"
        }
    </script>
@endpush