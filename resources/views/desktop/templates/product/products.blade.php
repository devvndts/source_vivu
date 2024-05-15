@extends('desktop.master')

@section('content')
{{-- @if(isset($background_category))
	@section('background_category')
	<div class="">
		<div class="bg-left-top category_bg_photo himg" style="background:url('{{ Thumb::Crop(UPLOAD_CATEGORY,$background_category,1800,400,1)}}') no-repeat ; background-size: cover;">
			<div class="container max-w-screen-xl"><h2 class="category-detail-title"><span>{{$title_crumb}}</span></h2></div>
		</div>
	</div>
	@endsection
@endif --}}

<div class="container max-w-screen-xl ">
	<div class="">
		{{-- <x-sidebarmenu class="w-full md:w-1/4" id="sidenavExample" bsParent="#sidenavExample" type="product" /> --}}
		<div>
			<x-shared.subtitle title="{{ $title_crumb }}" />
	
			@if(isset($row_detail) && $row_detail['noidung'.$lang])
				<div class="content-main">{!! $row_detail['noidung'.$lang] !!}</div>
			@endif

			{{-- @if (isset($row_detail) && $row_detail["level"] == 0)
				@php
					$product2Categories = get_categories('product', $lang, ["query" => ["level" => "1", "ids_level_1" => $row_detail["id"]]]);
				@endphp
				@if ($product2Categories)
					<div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
					@foreach ($product2Categories as $item)
					@php
						$name = $item->{"ten$lang"};
						$url = $item->{$sluglang};
						$img = Thumb::Crop(UPLOAD_CATEGORY, $item->photo, 150, 150, 2);
					@endphp
						<div class="cate-cat-item">
							<a href="{{ url($url) }}">
								<figure class="md:w-44 md:h-44 bg-[#E9ECEF] bg-opacity-50 rounded-full flex justify-center items-center overflow-hidden mx-auto mb-5 border-[#0F228B] border-solid ">
									<x-shared.image class="max-w-[150px]" src="{{ $img }}" />
								</figure>
								<h2 class="text-base font-medium text-center">{{ $name }}</h2>
							</a>
						</div>
					@endforeach   	
					</div>
				@endif
			@else --}}
				@if($products)
				{{-- <div class="flex flex-wrap -mx-4">
					@foreach ($products as $item)
						<x-product :item="$item" class="w-1/2 px-3 mb-5 lg:w-1/3 md:w-1/3"></x-product>	
					@endforeach
				</div>		 --}}
				<x-product.index class="mb-5">
					@foreach ($products as $item)
						<x-product.item :item="$item"></x-product.item>	
					@endforeach
				</x-product.index>
				@endif
				<div class="col-sm-12 dev-center dev-paginator">{{ $products->links() }}</div>
		</div>
	</div>
	
	
	{{-- <div class="product_layout_box">
		<div class="product_layout_left">@include('desktop.layouts.sidebar')</div>
		<div class="product_layout_right w-100">
			<div id="showcategory_products">
				@include('desktop.layouts.products',['product_class'=>'product__grid'])
				<div class="row">
					<div class="col-sm-12 dev-center dev-paginator">{{ $products->links() }}</div>
				</div>
			</div>
		</div>
	</div> --}}
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