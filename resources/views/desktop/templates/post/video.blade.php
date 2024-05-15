@extends('desktop.master')



@section('content')

<div class="center-layout py- bortop">

    <div class="rounded py-2 px-3 mt-4">

        @if($danhmucparent)

            @foreach($danhmucparent as $l=>$list)

                @php

                    $posts = Helper::GetVideos($list['id'],$list['type']);

                @endphp

                @if($posts)

                    <div class="boxvideo-category">

                        <h2 class="boxvideo-category-title">{{$list['ten'.$lang]}} <i class="far fa-list-music ml-2 mr-2"></i> ({{count($posts)}} videos)</h2>

                        <div class="boxvideo-listitem">

                            <div class="content-main w-clear">

                                @if(count($posts)>0)

                                    <div class="video__owl owl-carousel owl-theme">

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

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        @endif

    </div>

</div>

@endsection



<!--css thêm cho mỗi trang-->

@push('css_page')

    <link rel="stylesheet" type="text/css" href="{{asset('css/video.css')}}">

@endpush



<!--js thêm cho mỗi trang-->

@push('js_page')

    <script>

        if($(".video__owl").exists()) {

            var owl = $('.video__owl');



            owl.owlCarousel({

                items: 5,

                autoplay: false,

                loop: false,

                lazyLoad: true,

                mouseDrag: true,

                autoplayHoverPause:true,

                dots: true,

                margin: 8,

                nav:true,                

                responsiveClass:true,

                responsive:{

                    0:{

                        items:2,

                        nav:true,

                        margin: 8,

                        dots:false

                    },

                    501:{

                        items:3,

                        nav:true,

                        margin: 8,

                        dots:false

                    },

                    651:{

                        items:5,

                        nav:true,

                        margin: 8,

                        dots:false

                    },

                    1025:{

                        items:5,

                        nav:true,

                        margin: 8,

                        dots:false

                    }

                }

            });

        }

    </script>

@endpush



@push('strucdata')

    @include('desktop.layouts.strucdata')

@endpush