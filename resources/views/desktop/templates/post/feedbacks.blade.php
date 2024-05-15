@extends('desktop.master')

@section('content')
<div class="center-layout py-3 bortop">
    <div class="rounded py-2 px-0">
        <div class="home-title"><span>{{$title_crumb}}</span></div>
        <div class="content-main w-clear">
            @if(count($posts)>0)
                <div class="khachhang__flex">
					@foreach($posts as $k=>$v)
						@php
							$userrating = json_decode($v['userrating'],true);
						@endphp
						<div class="home-custom-item">
							<a class="himg aspect-ratio aspect-ratio--1-1" title="{{$v['ten'.$lang]}}">
				                <img class="lazy loaded" data-src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_POST,$v['photo'],385,248,1,$v['type']): app('noimage') }}" data-srcset="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_POST,$v['photo'],385,248,1,$v['type']):app('noimage') }} 1024w, {{ (isset($v['photo']))?Thumb::Crop(UPLOAD_POST,$v['photo'],385,248,1,$v['type']):app('noimage') }} 600w" data-sizes="auto" alt="{{$v['ten'.$lang]}}" sizes="auto" srcset="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_POST,$v['photo'],385,248,1,$v['type']):app('noimage') }} 1024w, {{ (isset($v['photo']))?Thumb::Crop(UPLOAD_POST,$v['photo'],385,248,1,$v['type']):app('noimage') }} 600w" src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_POST,$v['photo'],385,248,1,$v['type']):app('noimage') }}" data-was-processed="true">
				            </a>
				            <div class="home-custom-info">	
				            	<div>
				            		<span class="home-custom-img"><img src="{{ (isset($userrating['photo']))?Thumb::Crop(UPLOAD_POST,$userrating['photo'],53,0,1,$v['type']): app('noimage') }}"></span>
				            	</div>		            	
				            	<div class="home-custom-rating">			            		
				            		<div class="home-custom-right">
				            			<div class="home-custom-detail">
				            				<p class="home-custom-name">{{$userrating['ten']}}</p>
				            			</div>
				            			@for($i=0;$i<$userrating['star'];$i++)
				            				<i class="fas fa-star"></i>
				            			@endfor		
				            			<div class="home-custom-descript">{{$v['mota'.$lang]}}</div>	            			
				            		</div>
				            	</div>
				            </div>
						</div>
					@endforeach							
				</div>
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>{{khongtimthayketqua}}</strong>
                </div>
            @endif

            <div class="clear"></div>
            <div class="row">
               <div class="col-sm-12 dev-center dev-paginator">{{ $posts->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')

@endpush

@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush