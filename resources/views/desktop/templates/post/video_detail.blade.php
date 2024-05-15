@extends('desktop.master')

@section('content')
<div class="center-layout pt-5 mb-5 detail-page-post bortop">
    <div class="bg-white rounded">
        <div class="title-main"><span>{{$row_detail['ten'.$lang]}}</span></div>
        <div class="mb-3 text-muted d-none"><small>{{ngaydang}}: {{date("d/m/Y h:i A",$row_detail['ngaytao'])}}</small></div>

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
            <div class="share">
                <div class="social-plugin d-flex flex-wrap w-clear">
                    <div class="addthis_inline_share_toolbox_qj48"></div>
                    <div class="zalo-share-button ml-2" data-href="{{Helper::getCurrentPageURL()}}" data-oaid="{{($settingOption['oaidzalo']!='')?$settingOption['oaidzalo']:'579745863508352884'}}" data-layout="1" data-color="blue" data-customize=false></div>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                <strong>{{ __('Nội dung đang cập nhật') }}</strong>
            </div>
        @endif
    </div>
    <div class="rounded p-3 my-3 othernews">
        <b class="othernews_title">{{videokhac}}:</b>
        <ul class="list-news-other list-video-other mt-2">
            @if(isset($posts) && count($posts) > 0)
                <div class="video__flex">
                    @foreach($posts as $k=>$v)
                        <div class="post-video-items">
                            <a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1 box-post-img" title="{{$v['ten'.$lang]}}">
                                <img class="lazy loaded" data-src="{{ Helper::GetThumbYoutube($v['video']) }}"  sizes="auto" srcset="{{ Helper::GetThumbYoutube($v['video']) }} 1024w, {{ Helper::GetThumbYoutube($v['video']) }} 600w" src="{{ Helper::GetThumbYoutube($v['video']) }}" data-was-processed="true">
                            </a>
                            <h3 class="box-post-name"><a href="{{$v['tenkhongdau'.$lang]}}">{{$v['ten'.$lang]}}</a></h3>
                            <div class="box-post-detail">
                                <p class="box-post-date">{{date('d/m/Y',$v['ngaytao'])}}</p>
                            </div>
                        </div>
                    @endforeach
                </div> 
            @endif
        </ul>
        <div class="row">
           <div class="col-sm-12 dev-center dev-paginator">{{ $posts->render('desktop.layouts.paginator') }}</div>
        </div>
    </div>

    <!--HỎI ĐÁP-->
    @include('desktop.layouts.hoidap')
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
    <link rel="stylesheet" type="text/css" href="{{asset('css/video.css')}}">
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
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