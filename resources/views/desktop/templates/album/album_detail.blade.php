@extends('desktop.master')

@section('content')
<div class="center-layout mb-4">
    <div class="bg-white rounded py-2 px-3">
        <div class="title"><span>{{$row_detail['ten'.$lang]}}</span></div>
        <div class="mb-3 text-muted"><small>{{ngaydang}}: {{date("d/m/Y h:i A",$row_detail['ngaytao'])}}</small></div>
        <div class="content-main w-clear">
            @if(count($hinhanhsp)>0)
                <div class="product__grid product__grid--4 mb-4">
                @foreach($hinhanhsp as $k=>$v)
                    <div class="product-items">
                        <div class="product-items__image">
                            <a href="{{UPLOAD_ALBUM.$v['photo']}}" data-fancybox="gallery_album" class="himg aspect-ratio aspect-ratio--1-1">
                                <img src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_ALBUM,$v['photo'],300,300,1,$v['type']):'' }}" alt="{{$v['ten'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',300,300,1)}}" />
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif

            <div class="clear"></div>
            <div class="row">
               <div class="col-sm-12 dev-center dev-paginator">{{ $albums->render('desktop.layouts.paginator') }}</div>
            </div>
        </div>

        @if(isset($row_detail['noidung'.$lang]) && $row_detail['noidung'.$lang] != '')
            <div class="meta-toc">
                <div class="box-readmore">
                    <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
                </div>
            </div>
            <div class="content-main w-clear" id="toc-content">{!! $row_detail['noidung'.$lang] !!}</div>
            <div class="share">
                <b>Chia sẻ:</b>
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

    <div class="bg-white rounded py-2 px-3">
        <div class="title">{{$other_title_crumb}}</div>
        <div class="content-main w-clear">
            @if(count($albums)>0)
                <div class="product__grid product__grid--4 pd-10">
                @foreach($albums as $k=>$v)
                    <div class="product-items">
                        <div class="product-items__image">
                            <a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1">
                                <img src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_ALBUM,$v['photo'],300,300,1,$v['type']):'' }}" alt="{{$v['tenkhongdau'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',300,300,1)}}" />
                            </a>
                        </div>
                        <div class="product-items__info">
                            <h3><a class="product-items__name" href="tui-deo-cheo-dang-hop-dung-minigo-unisex-limited-hoa-van-star-of-david">{{$v['ten'.$lang]}}</a></h3>
                            <p class="time-news">Ngày đăng: {{date("d/m/Y h:i A",$v['ngaytao'])}}</p>
                            <div style="font-size:14px;text-align: justify;">{{Str::limit($v['mota'.$lang],80)}}</div>
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>Không tìm thấy kết quả</strong>
                </div>
            @endif

            <div class="clear"></div>
            <div class="row">
               <div class="col-sm-12 dev-center dev-paginator">{{ $albums->render('desktop.layouts.paginator') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }} ">
    <style>
    .fancybox-thumbs {
        top: auto;
        width: auto;
        bottom: 0;
        left: 0;
        right: 0;
        height: 95px;
        padding: 10px 10px 5px 10px;
        box-sizing: border-box;
        background: rgba(0, 0, 0, 0.3);
    }

    .fancybox-show-thumbs .fancybox-inner {
        right: 0;
        bottom: 95px;
    }
    </style>
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
	<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <script>
    $('[data-fancybox="gallery_album"]').fancybox({
        thumbs: {
        autoStart: true,
        axis: 'x'
        }
    })
    </script>
@endpush
