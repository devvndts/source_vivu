@extends('desktop.master')

@section('content')
@php
@endphp
	@isset($partner)
		<div class="partner-home py-2 py-lg-5">
			<div class="home-title"><span>Đơn vị đã hợp tác</span></div>
			<div class="container-2 mx-auto">
				<div class="partner-items">
					@foreach ($partner as $key => $item)
						@php
							$name = $item['ten'.$lang];
							$url = $item['link'];
							$img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_PHOTO,$item['photo'],200,60,2,$item['type']), $name, asset('img/noimage.png'));
						@endphp	
						<div class="partner-item px-4 py-3">
							<a href="{{ $url }}">{!! $img !!}</a>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		@endisset
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