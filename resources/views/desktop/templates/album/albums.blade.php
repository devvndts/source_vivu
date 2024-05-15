@extends('desktop.master')

@section('content')
<div class="center-layout pb-3">
    <div class="bg-white rounded py-2 px-3">
        <div class="title">{{$title_crumb}}</div>
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
                            <p class="time-news">{{ngaydang}}: {{date("d/m/Y h:i A",$v['ngaytao'])}}</p>
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
               <div class="col-sm-12 dev-center dev-paginator">{{ $albums->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

<!--css thêm cho mỗi trang-->
@section('css_page')

@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection


@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush