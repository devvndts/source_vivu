@extends('desktop.master')

@section('content')
<div class="center-layout py-4 bortop padlr">
	<div class="bg-white rounded">
		<h2 class="home-title"><span>Feedback</span></h2>
		@if($danhgias)
			<div class="feedback__grid__layout">
				@foreach($danhgias as $k=>$v)
					@php
						$product = $v['has_product'];
						$arr_name = explode(' ', $v['tenvi']);
						$name = $arr_name[count($arr_name)-1];
					@endphp

					<div class="home-custom-item">
						<a class="himg aspect-ratio aspect-ratio--1-1" title="{{$product['ten'.$lang]}}">
			                <img class="lazy loaded" data-src="{{ Thumb::Crop(UPLOAD_PRODUCT,$product['photo'],300,300,2,$product['type']) }}" src="{{ Thumb::Crop(UPLOAD_PRODUCT,$product['photo'],300,300,2,$product['type']) }}" data-was-processed="true">
			            </a>
			            <div class="home-custom-info">	
			            	<div>
			            		<span class="home-custom-img">{{Str::substr($name, 0, 1);}}</span>
			            	</div>		            	
			            	<div class="home-custom-rating">			            		
			            		<div class="home-custom-right">
			            			<div class="home-custom-detail">
			            				<p class="home-custom-name">{{$v['ten'.$lang]}}</p>
			            			</div>
			            			@for($i=1;$i<=$v['star'];$i++)
										<i class="fas fa-star"></i>
									@endfor
									@for($i=$v['star']+1;$i<=5;$i++)
										<i class="far fa-star"></i>
									@endfor	
			            			<div class="home-custom-descript">{{$v['noidung'.$lang]}}</div>	            			
			            		</div>
			            	</div>
			            </div>
					</div>
				@endforeach
			</div>
		@endif
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