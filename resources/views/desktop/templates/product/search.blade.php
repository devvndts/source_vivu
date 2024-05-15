@extends('desktop.master')

@section('content')
@if(isset($background_category))
	@section('background_category')
		<div class="category_bg_photo himg" style="background:url('{{ Thumb::Crop(UPLOAD_CATEGORY,$background_category,1440,255,1)}}') no-repeat center center; background-size: cover;">
			<div class="center-layout"><h2 class="category-detail-title"><span>{{$title_crumb}}</span></h2></div>
		</div>
	@endsection
@endif

<div class="container max-w-screen-xl py-4 bortop padlr">
	<div class="bg-white rounded">
		<x-shared.subtitle title="{{ $title_crumb }}" />
		<div class="product_layout_box">
			<div id="showcategory_products">
				@include('desktop.layouts.products')
				<div class="row">
			        <div class="col-sm-12 dev-center dev-paginator">{{ $products->links() }}</div>
			    </div>
			</div>
		</div>
	</div>
</div>

<!--HỎI ĐÁP-->
{{--
@include('desktop.layouts.hoidap')
--}}

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