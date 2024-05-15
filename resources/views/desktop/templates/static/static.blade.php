@extends('desktop.master')

@section('content')
    <div class="container max-w-screen-xl">
        <x-shared.subtitle title="{{ $row_detail['ten'.$lang] ?? $title_crumb }}" />
        
        @if (@$hinhanhsp)
            @include('desktop.layouts.swiper',['galPath' => UPLOAD_STATICPOST])
        @endif
        <div class="hidden mb-3 text-muted"><small>{{ __('Ngày đăng') }}: {{date("d/m/Y h:i A",$row_detail['ngaytao'])}}</small></div>
        @if(isset($row_detail['noidung'.$lang]) && $row_detail['noidung'.$lang] != '')
            <div class="meta-toc">
                <div class="box-readmore">
                    <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
                </div>
            </div>
            <div class="content-main w-clear" id="toc-content">{!! $row_detail['noidung'.$lang] !!}</div>
            <x-shared.share />
            <!--HỎI ĐÁP-->
            {{--@include('desktop.layouts.hoidap')--}}
        @else
            <div class="alert alert-warning" role="alert">
                <strong>{{ __('Nội dung đang cập nhật') }}</strong>
            </div>
        @endif
    </div>
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
                "{{ (isset($row_detail['photo']))?url('/').'/'.UPLOAD_STATICPOST.$row_detail['photo']:'' }}"
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