@extends('desktop.master')
@section('element_detail','product_detail_content')
@section('center_detail','center-layout container')
@section('content')
@include('desktop.layouts.product_top')
@php
	$default_sell = $row_detail['sell'] ?? 0;
	//### phần trăm đánh giá
	if ($info_rating == null) $info_rating = array();
	$phantram_onestar = (isset($info_rating['allrating']) && $info_rating['allrating']>0) ? round(($info_rating['onestar'] * 100) / $info_rating['allrating']) : 0;
	$phantram_twostar = (isset($info_rating['allrating']) && $info_rating['allrating']>0) ?  round(($info_rating['twostar'] * 100) / $info_rating['allrating']) : 0;
	$phantram_threestar = (isset($info_rating['allrating']) && $info_rating['allrating']>0) ?  round(($info_rating['threestar'] * 100) / $info_rating['allrating']) : 0;
	$phantram_fourstar = (isset($info_rating['allrating']) && $info_rating['allrating']>0) ?  round(($info_rating['fourstar'] * 100) / $info_rating['allrating']) : 0;
	$phantram_fivestar = (isset($info_rating['allrating']) && $info_rating['allrating']>0) ?  round(($info_rating['fivestar'] * 100) / $info_rating['allrating']) : 0;
	$average_score = (isset($info_rating['allrating']) && $info_rating['allrating']>0) ?  round($info_rating['maxstar'] / $info_rating['allrating']) : 0;
@endphp
<div class="detail detail__container" id="page-product-detail">
	<div class="detail__left" id="gallery-photo-main">
		@if($gallery_color)
			@foreach($gallery_color as $g=>$gal)
				<div id="gallery-photo-show-{{$g}}" class="clearfix gallery-photo-item">
					@php 
						$galleries = $gal;
					@endphp				
					<div class="detail__gallery_right">
						@if($galleries)
							<div class="detail__gallery_list">
								@foreach($galleries as $k=>$v)
									<a id="gallery-photo-{{$v['id']}}" title="{{$v['ten'.$lang]}}"><img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],560,610,1,$v['com']) }}" alt="{{$v['ten'.$lang]}}"></a>
								@endforeach
							</div>
						@endif
					</div>
					<div class="detail__gallery_left">
						@if($galleries)
							<div class="detail__gallery_auto">
							@foreach($galleries as $k=>$v)
								<a class="thumb-pro-detail gallery-photo-scroll" data-zoom-id="Zoom-1" href="#gallery-photo-{{$v['id']}}" title="{{$v['ten'.$lang]}}">
									<img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],560,610,1,$v['com']) }}" alt="{{$v['ten'.$lang]}}">
								</a>
							@endforeach
							</div>
						@endif
					</div>
				</div>
			@endforeach
		@else
			<div id="gallery-photo-show-main" class="clearfix gallery-photo-item">			
				<div class="detail__gallery_right">
					<div class="detail__gallery_list slick-product-one">
						<a id="gallery-photo-main" title="{{$row_detail['ten'.$lang]}}" class="gallery-photo-first"><img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$row_detail['photo'],1108,1240,2,$row_detail['type']) }}" alt="{{$row_detail['ten'.$lang]}}"></a>
						@if($hinhanhsp)
							@foreach($hinhanhsp as $k=>$v)
								<a id="gallery-photo-{{$v['id']}}" title="{{$v['ten'.$lang]}}"><img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],1108,1240,2,$v['type']) }}" alt="{{$v['ten'.$lang]}}"></a>
							@endforeach
						@endif
					</div>					
					@if($hinhanhsp)
						<div class="detail__gallery_mainthumb">
							<div class="/detail__gallery_thumb /owl-carousel /owl-theme slick-product-list">
								<a title="{{$row_detail['ten'.$lang]}}" class="gallery-thumb-first"><img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$row_detail['photo'],1108,1240,2,$row_detail['type']) }}" alt="{{$row_detail['ten'.$lang]}}"></a>
								@foreach($hinhanhsp as $k=>$v)
									<a id="gallery-photo-{{$v['id']}}" title="{{$v['ten'.$lang]}}"><img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],1108,1240,2,$v['type']) }}" alt="{{$v['ten'.$lang]}}"></a>
								@endforeach
							</div>
						</div>
					@endif
				</div>
				<div class="detail__gallery_left"></div>
			</div>			
		@endif
	</div>
	<div class="detail_product_sticky">
		<div class="detail__right bortop">
			<div class="detail__name">{{$row_detail['ten'.$lang]}}</div>
			<div class="d-flex justify-content-between detail__price_contain">
				<div class="d-flex align-items-end detail__price">
					<div class="detail__price--new detail__price--new{{$row_detail['id']}}">{{Helper::Format_Money($giamoi)}}</div>	
					@if($gia > $giamoi)
						<div class="detail__price--old detail__price--old{{$row_detail['id']}}">{{Helper::Format_Money($gia)}}</div>
					@endif
					<div class="detail__price--km detail__price--km{{$row_detail['id']}} {{($giakm>0) ? '': 'd-none'}}">-{{$giakm}}%</div>				
				</div>
				<div class="detail__product_rating">
					@if ($average_score)
					<div class="detail_rating_count">
						@for($i=1;$i<=$average_score;$i++)
							<i class="fas fa-star"></i>
						@endfor
						@for($i=$average_score+1;$i<=5;$i++)
							<i class="far fa-star"></i>
						@endfor
						{{$average_score}}.0 ({{($info_rating['allrating']) ? $info_rating['allrating'] : 0}} lượt đánh giá)
					</div>
					@endif
					<div class="detail_order_count">
						{{$count_luotmua+$default_sell}} lượt mua <span class="mx-1">|</span> <strong id="isStock">{{($row_detail['soluong']>0 ? 'Còn hàng' : 'Hết hàng')}}</strong>
					</div>
				</div>
			</div>
			<div class="font-weight-bold detail__properties__masp mb-2">Mã sản phẩm: <span class="sku{{$row_detail['id']}}">{{$row_detail['masp']}}</span></div>
			@if($mau!='')
				@php
					$masp_colors = ($row_detail['masp_color']!='') ? json_decode($row_detail['masp_color'],true) : null;
				@endphp
			<div class="detail__properties detail__properties__color py-2">
				<div class="detail__properties__name mb-2">Màu sắc: <span id="color-current"></span></div>
				<div class="d-flex flex-wrap">
					@foreach ($mau as $key => $value)
						@if($value['loaihienthi'] == 1)
							<div class="color-pro-detail {{($key == 0) ? 'active' : ''}} {{($key == 0 && count($mau) > 1) ? 'ColorfirstOption' : ''}}" data-id="{{$row_detail['id']}}" data-masp="{{($masp_colors[$value['id']]) ? $masp_colors[$value['id']] : $row_detail['masp']}}" title="{{$value['ten'.$lang]}}">
								<input class="detail__properties-items js-select-variant" style="background-image: url({{UPLOAD_COLOR.$value['photo']}})" type="radio" value="{{$value['id']}}" name="color-pro-detail" >
							</div>
						@else
							<div class="color-pro-detail {{($key == 0) ? 'active' : ''}} {{($key == 0 && count($mau) > 1) ? 'ColorfirstOption' : ''}}" data-id="{{$row_detail['id']}}" data-masp="{{($masp_colors[$value['id']]) ? $masp_colors[$value['id']] : $row_detail['masp']}}" title="{{$value['ten'.$lang]}}">
								<input class="detail__properties-items js-select-variant" style="background-color: #{{$value['mau']}}" type="radio" value="{{$value['id']}}" name="color-pro-detail" >
							</div>
						@endif
					@endforeach
				</div>
			</div>
			@endif
			@if(isset($size) && count($size)>0)
				@php
					// dd($size);
				@endphp
				<div class="detail__properties detail__properties__size py-3">
					<div class="detail__properties__name d-none">Size: <span id="size-current"></span></div>
					<div class="d-flex flex-wrap" id="product_detail_size">
						@foreach ($size as $key => $value)
						@php
							$priceSold = ($value["gia"] > $value["giamoi"] && $value["giamoi"]>0) ? $value["giamoi"] : $value["gia"];
						@endphp
							<a class="size-pro-detail text-decoration-none mr-1 {{($key == 0) ? 'active' : ''}} {{($key == 0) ? 'SizefirstOption' : ''}}" data-id="{{$row_detail['id']}}">
								<input type="radio" value="{{$value['id']}}" class="detail__properties-items js-select-variant" name="size-pro-detail" {{($key == 0) ? 'checked' : ''}}>
								{{$value['ten'.$lang]}}
								<span>{{ Helper::Format_Money($priceSold) }}</span>
							</a>
						@endforeach
					</div>
				</div>
			@endif
			<!--nếu sản phẩm ko có size và màu thì lấy phiên bản mẫu-->
			@if(isset($size) && count($size)==0)
				@php
					$sample_product = $row_detail['has_product_options_sample'];
				@endphp
				<div class="detail__properties detail__properties__size py-3 d-none">
					<div class="d-flex flex-wrap" id="product_detail_size">
						<a class="size-pro-detail text-decoration-none mr-1 active SizefirstOption" data-id="{{$row_detail['id']}}">
							<input type="radio" value="0" class="detail__properties-items js-select-variant" name="size-pro-detail" checked>
						</a>
					</div>
				</div>
			@endif
			@if($row_detail['mota'.$lang] != '')
				<div class="detail__properties__des my-2">
					<div class="product_detail_des">{!! $row_detail['mota'.$lang] !!}</div>
				</div>
			@endif
			<div class="detail__button__grid py-2 fix_button_cart mobile_button_cart {{($is_soluong) ? 'btn-cart-grid' : 'btn-cart-hidden'}}" id="show_btn_mobile_conhang">
				<button type="button" class="d-flex justify-content-center align-items-center detail__button detail__wishlist js-action-cart" data-id="{{$row_detail['id']}}" data-action="addnow">
					<span><i class="fal fa-shopping-bag mr-2"></i> Thêm vào giỏ</span>
				</button>
				{{--
				<button type="button" class="d-flex justify-content-center align-items-center detail__button detail__buynow js-action-cart" data-id="{{$row_detail['id']}}" data-action="buynow">
					<span>Mua ngay</span>				
				</button>
				--}}
			</div>
			<div class="contact-phone">
				<ul>
					<li>
						<a target="_blank" href="https://zalo.me/{{ preg_replace('/[^0-9]/','',$settingOption['zalo']) }}">
							<p> <i class="fa fa-comment"></i> Chat Zalo </p>
							<p>Giải đáp và hỗ trợ ngay tức thì</p>
						</a>
					</li>
					<li>
						<a target="_blank" href="{{ $settingOption['messenger'] }}">
							<p> <i class="fa fa-facebook-square"></i> Chat Facebook </p>
							<p>Giải đáp và hỗ trợ ngay tức thì</p>
						</a>
					</li>
				</ul>
			</div>
			<div class="my-3 detail__product_tags">
				<span class="mr-2"><i class="fas fa-tags mr-1"></i> Từ khóa:</span>
				@if($tags)
					@foreach($tags as $k=>$v)
						<a href="tags/{{$v['tenkhongdau'.$lang]}}">{{$v['ten'.$lang]}}</a>
					@endforeach
				@endif
			</div>
			<div class="detail__button__grid py-2 {{($is_soluong) ? 'fix_button_cart btn-cart-grid' : 'btn-cart-hidden'}}" id="show_btn_conhang">
				<div class="detail__properties detail__properties_quantity py-0" id="show_soluong_khung">
					<div class="detail__properties__name d-none">Số lượng:</div>
					<div class="d-flex quantity">
						<button type="button" class="quantity__button quantity__button--minus js-change-quantity" data-action="minus"></button>
						<input type="text" id="quantity" value="1">
						<button type="button" class="quantity__button quantity__button--plus js-change-quantity" data-action="plus"></button>
					</div>
				</div>
				<button type="button" class="d-flex justify-content-center align-items-center detail__button detail__wishlist js-action-cart" data-id="{{$row_detail['id']}}" data-action="addnow">
					<span><i class="fal fa-shopping-bag mr-2"></i> Thêm vào giỏ</span>
				</button>
				{{--
				<button type="button" class="d-flex justify-content-center align-items-center detail__button detail__buynow js-action-cart" data-id="{{$row_detail['id']}}" data-action="buynow">
					<span>Mua ngay</span>
					<i class="fal fa-shopping-bag ml-2"></i>
				</button>
				--}}
			</div>
			<div class="{{($is_soluong) ? 'btn-hethang-hidden' : 'fix_button_cart btn-hethang-show'}}" id="show_btn_hethang">
				<button type="button" class="justify-content-center align-items-center btn-hethang-css">						
					<i class="fas fa-hourglass-end"></i>
					<span class="ml-2"> Tạm hết hàng</span>
				</button>
			</div>
			{{-- <div class="my-3 detail__product_shop">
				<i class="far fa-map-marker-question"></i> Tìm cửa hàng
			</div> --}}
		</div>
		</div>
		<div class="bg-white rounded py-5">	
		<div class="py-5 center-layout bortop">
			@include('desktop.templates.product.product_content')
		</div>
	</div>
</div>
<div>
	<!--ĐÁNH GIÁ-->
	{{-- @include('desktop.layouts.cuahang') --}}
	<!--ĐÁNH GIÁ-->
	{{-- @include('desktop.layouts.danhgia') --}}
	<!--HỎI ĐÁP-->
	{{-- @include('desktop.layouts.hoidap') --}}
	<div class="bg-white py-4 bortop">
		<div class="center-layout container clearfix">
			<div class="home-title"><span>Sản phẩm liên quan</span></div>
			@include('desktop.layouts.products')
			<div class="row">
		        <div class="col-sm-12 dev-center dev-paginator">{{ $products->links() }}</div>
		    </div>
		</div>
	</div>
</div>
@endsection
<!--css thêm cho mỗi trang-->
@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/magiczoomplus.css') }} ">
	<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/slick/slick.css') }}">
  	<link rel="stylesheet" href="{{ asset('plugins/slick/slick-theme.css') }}">
@endpush
<!--js thêm cho mỗi trang-->
@push('js_page')
	<script src="{{ asset('plugins/slick/slick.js') }}" charset="utf-8"></script>
	<script src="{{ asset('js/magiczoomplus.js') }}"></script>
	<script>
		$(window).on('load', function () {
			var e_content_show = $('.product_active_tab').attr('data-id');
			$('.product-detail-content-item').removeClass('active_content');
			$(e_content_show).addClass('active_content');
			if($("#gallery-photo-show-main").exists()){
				$('.gallery-photo-item').removeClass('gallery-photo-show');	
				$('#gallery-photo-show-main').addClass('gallery-photo-show');
			}
		});
		// $('.product-detail-tab').click(function(){
		// 	var e_content_show = $(this).attr('data-id');
		// 	$('.product-detail-content-item').removeClass('active_content');
		// 	$(e_content_show).addClass('active_content');
		// 	$('.product-detail-tab').removeClass('product_active_tab');
		// 	$(this).addClass('product_active_tab');
		// });
		$('.detail__product_shop').click(function(){
			$('.product_cuahang_main').addClass('product_cuahang_active');
		});
		$('.product_cuahang_close').click(function(){
			$('.product_cuahang_main').removeClass('product_cuahang_active');
		});
	</script>
	<script>
		$('.slick-product-one').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  fade: true,
		  asNavFor: '.slick-product-list'
		});
		$('.slick-product-list').slick({
		  slidesToShow: 6,
		  slidesToScroll: 1,
		  asNavFor: '.slick-product-one',
		  dots: false,
		  focusOnSelect: true,
		  vertical:true,
		  verticalSwiping:true,
		  infinite:false,		  
		  responsive: [
		  	{
		      breakpoint: 1025,
		      settings: {
		        slidesToShow: 8,
		        slidesToScroll: 1,
		        infinite: false,
		        dots: false,
		        vertical:false,
		  		verticalSwiping:false,
		      }
		    },
		    {
		      breakpoint: 801,
		      settings: {
		        slidesToShow: 6,
		        slidesToScroll: 1,
		        vertical:false,
		        verticalSwiping:false,
		      }
		    },
		    {
		      breakpoint: 361,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 1,
		        vertical:false,
		        verticalSwiping:false,
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
		});
	</script>
	{{--<script src="{{ asset('js/product.js') }}"></script>--}}
@endpush
@push('strucdata')
	<script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "{!!$row_detail['ten'.$lang]!!}",
            "image":
            [
            	"{{ (isset($row_detail['photo']))?url('/').'/'.UPLOAD_PRODUCT.$row_detail['photo']:'' }}"
            ],
            "description": "{{SEOMeta::getDescription()}}",
            "sku":"SP0{{$row_detail['id']}}",
            "mpn": "925872",
            "brand":
            {
                "@type": "Thing",
				@php
					$productList = $setting['ten'.$lang];
					if (isset($pro_list['ten'.$lang])) {
						$productList = $pro_list['ten'.$lang];
					}
					$productList = $productList ?? '';
				@endphp
                "name": "{{$productList}}"
            },
            "review":
            {
                "@type": "Review",
                "reviewRating":
                {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                },
                "author":
                {
                    "@type": "Person",
                    "name": "{!!$setting['ten'.$lang] ?? ''!!}"
                }
            },
            "aggregateRating":
            {
                "@type": "AggregateRating",
                "ratingValue": "4.4",
                "reviewCount": "89"
            },
            "offers":
            {
                "@type": "Offer",
                "url": "{{url()->current()}}",
                "priceCurrency": "VND",
                "price": "{{$row_detail['gia'] ?? 0}}",
                "priceValidUntil": "2020-11-05",
                "itemCondition": "https://schema.org/UsedCondition",
                "availability": "https://schema.org/InStock",
                "seller":
                {
                    "@type": "Organization",
                    "name": "Executive Objects"
                }
            }
        }
    </script>
@endpush