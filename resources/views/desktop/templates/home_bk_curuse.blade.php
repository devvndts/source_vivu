@extends('desktop.master')
@section('content')
<h1 class="d-none">{{app('setting')['tenvi']}}</h1>
<!--TIÊU CHÍ-->
<div class="home-tieuchi-container bortop padlr">
	<div class="center-layout home-tieuchi-main">
		<div class="home-tieuchi-left">
			<span>Nhập mã <strong>{{$coupon_noibat['ma'] ?? ''}}</strong></span>
			<div>{{$coupon_noibat['noidung'.$lang]??''}}</div>
		</div>
		<span class="home-tieuchi-border"></span>
		<div class="home-tieuchi-center home-tieuchi-item">Hàng chĩnh hãng 100%</div>
		<span class="home-tieuchi-border"></span>
		<div class="home-tieuchi-right home-tieuchi-item">Kiểm tra hàng khi thanh toán</div>
	</div>
</div>
<!--SẢN PHÂM-->
<div class="home-danhmuc-container bortop padlr">
	<div class="center-layout home-danhmuc-main">
		<h2 class="home-title"><span>Sản phẩm</span></h2>
		<div class="//auto-width">
			<div class="home-danhmuc-list">
				@php
					$danhmuc_cap3 = app('danhmuc_cap3');
				@endphp
				@if($danhmuc_cap3)
					@foreach($danhmuc_cap3 as $k=>$v)
						<a class="home-danhmuc-item himg" href="{{$v['tenkhongdau'.$lang]}}">
							<p class="home-danhmuc-name"><span>{{$v['ten'.$lang]}}</span></p>
							<img class="home-danhmuc-img /lazy /loaded"src="{{ Thumb::Crop(UPLOAD_CATEGORY,$v['photo'],260,320,2,$v['type']) }}" alt="{{$v['ten'.$lang]}}" width="130" height="160">
						</a>
					@endforeach
						<a class="home-danhmuc-item display-relative" href="san-pham">
							<p>Xem tất cả</p>
						</a>
				@endif
			</div>
		</div>
	</div>
</div>
<!--Quảng cáo-->
<div class="home-ads bortop padlr">
	<div class="center-layout px-0">
		@if($quangcaos)
			<div class="quangcao__owl owl-carousel owl-theme">
				@foreach($quangcaos as $k=>$value)
					<a href="{{$value['link']}}" target="_blank" class="himg">
						<img class="owl-lazy" data-src="{{ (isset($value['photo']))?Thumb::Crop(UPLOAD_PHOTO,$value['photo'],1224,350,1):'' }}" sizes="100vw" alt="{{$value['tenvi']}}" width="1224px" height="350px">
					</a>
				@endforeach
			</div>
		@endif
	</div>
</div>
<!--HOT DEAL-->
<div class="home-hot-deal bortop padlr">
	<h2 class="home-title"><span>Sản phẩm nổi bật</span></h2>
	<div class="center-layout px-0">
		@if($products)
			<div class="">
				<div class="/home-product-new product__grid--4">
					@foreach($products as $k=>$v)
						<div class="box-product-item">
							<div class="box-product-img">
								<a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1" title="{{$v['ten'.$lang]}}">
					                <img class="lazy loaded" src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],277,310,2,$v['type']) }}" alt="{{$v['ten'.$lang]}}" width="277" height="310">
					                <span class="box-product-iconnew">
					                	@if($v['noibat'])<img src="img/icon/new.png" alt="icon new" width="50" height="28">@endif
					                	@if($v['muanhieu'])<img src="img/icon/best.png" alt="icon new" width="65" height="37">@endif
					                </span>				                
					                <span class="box-product-outstock"><img src="img/icon_outstock.png" alt="outstock"></span>
					            </a>				            
					            <div class="box-product-btncart /btn-buy-cart change-prop-btn" data-code="" data-id="{{$v['id']}}" data-action="addnow"><img src="img/icon_cart.png" alt="cart" width="38" height="38"></div>
					            @php
			            			$colors = Helper::GetCheckColor($v);
			            			$sizes = Helper::GetCheckSize($v);
			            			$pricebetween = Helper::GetPriceBetween($v['id']);
			            		@endphp	
			            		@if($colors)
			            			<input type="hidden" name="cart-color" value="{{$colors[0]['id']}}">
				            	@endif
				            	@if($sizes)
			            			<input type="hidden" name="cart-size" value="{{$sizes[0]['id']}}">
				            	@endif
				            </div>
				            <div class="box-product-info">
				            	<div class="box-product-detail">
				            		<h3 class="box-product-name"><a href="{{$v['tenkhongdau'.$lang]}}">{{$v['ten'.$lang]}}</a></h3>
				            		<div class="box-product-brand">{{$v['belong_to_brand']['ten'.$lang]??''}}</div>
				            		<div class="box-product-price">
				            			<p class="box-product-newprice">{{Helper::Format_Money($pricebetween['giamin'])}}</p>
				            			<span>-</span>
				            			<p class="box-product-oldprice">{{Helper::Format_Money($pricebetween['giamax'])}}</p>
				            		</div>
				            		{{--
				            		<div class="box-product-price">
				            			<p class="box-product-newprice">{{($v['giamoi']>0) ? Helper::Format_Money($v['giamoi']) : (($v['gia']>0) ? Helper::Format_Money($v['gia']) : 'Liên hệ' )}}</p>
				            			<p class="box-product-oldprice">{!! ($v['giamoi']>0) ? '<span>-</span>'.Helper::Format_Money($v['gia']) : '' !!}</p>
				            		</div>
				            		--}}
				            	</div>
				            </div>
						</div>
					@endforeach
				</div>			
			</div>
			@if(count($products)>3)
				<p class="home-product-more display-relative"><a href="san-pham">Xem thêm</a></p>
			@endif
		@endif
	</div>	
</div>
<!--GIỚI THIỆU-->
<div class="home-intro-container">
	<div class="center-layout home-intro-main">
		<div class="home-intro-left"><a class="himg"><img class="lazy loaded" src="{{ (isset($gioithieu['photo']))?Thumb::Crop(UPLOAD_STATICPOST,$gioithieu['photo'],515,470,1,$gioithieu['type']): app('noimage') }}" alt="{{$gioithieu['ten'.$lang]}}" width="515" height="470"></a></div>
		<div class="home-intro-right">
			<div class="home-intro-info">
				<p class="home-intro-name">{{$gioithieu['ten'.$lang]}}</p>
				<div class="home-intro-desc">{!! $gioithieu['mota'.$lang] !!}</div>
			</div>
		</div>
	</div>
</div>
<!--SEARCH GOOGLE-->
<div class="home-searchgg-container bortop padlr">
	<div class="center-layout">
		<h2 class="home-title mb-4"><span>Tìm kiếm nhiều nhất</span></h2>
		<div class="home-search-tags">
			@if($tag_search)
				@foreach($tag_search as $k=>$v)
					<a class="home-search-tags-item" data-value="{{$v['ten'.$lang]}}"><i class="far fa-search"></i> {{$v['ten'.$lang]}}</a>
				@endforeach
			@endif
		</div>
	</div>
</div>
<div class="home-searchgg-container pb-5 bortop padlr">
	<div class="center-layout home-searchgg-main">
		<h2 class="home-title mb-4"><span>Tìm kiếm từ lovefish</span></h2>		
		<div class="home-searchgg-box">			
			<div class="gcse-search"></div>	
			<p class="home-searchgg-exam">VD: Quy trình setup bể cá, phân bón thủy sinh là gì, vi sinh dinh dưỡng...</p>	
		</div>		
	</div>
</div>
<!--BRAND-->
<div class="home-brand-container">
	@if($brands)
		@foreach($brands as $b=>$brand)
			@php
				$pos_bg = ($b==0) ? 'top' : (($b==count($brands)-1) ? 'bottom' : 'center');
				$products = $brand['has_product'];
			@endphp
		<div class="home-brand-main {{($b%2!=0) ? 'home-brand-main-fix': ''}} bortop padlr" style="background:url('{{ (isset($brand['photo2']))?Thumb::Crop(UPLOAD_BRAND,$brand['photo2'],1440,635,1,$v['type']): '#fff'}}') no-repeat center {{$pos_bg}};">
			<div class="center-layout home-brand-box">
				<a href="{{$brand['tenkhongdau'.$lang]}}" class="home-brand-img display-relative"><img class="lazy loaded" src="{{ (isset($brand['photo']))?Thumb::Crop(UPLOAD_BRAND,$brand['photo'],506,722,1,$brand['type']): app('noimage') }}" alt="{{$brand['ten'.$lang]}}" width="506" height="722"></a>
				<div class="home-brand-list">
					<p class="home-brand-name">{{$brand['ten'.$lang]}}</p>
					<div class="fix_carousel_owl">
						<div class="product_owl_tab owl-carousel owl-theme fix-carousel-off">
							@foreach($products as $k=>$v)
								@if($k==0 || $k%6==0)<div class="box_product_owl">@endif
								<div class="box-product-item">
									<div class="box-product-img">									
										<a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1" title="{{$v['ten'.$lang]}}">
							                <img class="lazy loaded" src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],209,239,2,$v['type']) }}" alt="{{$v['ten'.$lang]}}" width="209" height="239">
							                <span class="box-product-iconnew">
							                	@if($v['noibat'])<img src="img/icon/new.png" alt="icon new" width="50" height="28">@endif
							                	@if($v['muanhieu'])<img src="img/icon/best.png" alt="icon new" width="65" height="37">@endif
							                </span>	
											<span class="box-product-outstock"><img src="img/icon_outstock.png" alt="outstock"></span>
							            </a>
							            <div class="box-product-btncart /btn-buy-cart change-prop-btn" data-code="" data-id="{{$v['id']}}" data-action="addnow"><img src="img/icon_cart.png" alt="cart" width="38" height="38"></div>
							            @php
					            			$colors = Helper::GetCheckColor($v);
					            			$sizes = Helper::GetCheckSize($v);
					            			$pricebetween = Helper::GetPriceBetween($v['id']);
					            		@endphp	
					            		@if($colors)
					            			<input type="hidden" name="cart-color" value="{{$colors[0]['id']}}">
						            	@endif
						            	@if($sizes)
					            			<input type="hidden" name="cart-size" value="{{$sizes[0]['id']}}">
						            	@endif
						            </div>
						            <div class="box-product-info">
						            	<div class="box-product-detail">
						            		<div class="box-product-price">
						            			<p class="box-product-newprice">{{Helper::Format_Money($pricebetween['giamin'])}}</p>
						            			<span>-</span>
						            			<p class="box-product-oldprice">{{Helper::Format_Money($pricebetween['giamax'])}}</p>
						            		</div>
						            		{{--
						            		<div class="box-product-price">
						            			<p class="box-product-newprice">{{($v['giamoi']>0) ? Helper::Format_Money($v['giamoi']) : (($v['gia']>0) ? Helper::Format_Money($v['gia']) : 'Liên hệ' )}}</p>
						            			<p class="box-product-oldprice">{!! ($v['giamoi']>0) ? '<span>-</span>'.Helper::Format_Money($v['gia']) : '' !!}</p>
						            		</div>
						            		--}}
						            	</div>
						            </div>
								</div>											
								@if(($k+1)%6==0 || ($k+1)>=count($products))</div>@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	@endif
</div>
<!--KẾT NỐI-->
<div class="home-ketnoi-container bortop padlr">
	<div class="center-layout-ketnoi home-ketnoi-main">
		<div class="home-ketnoi-left">
			<p class="home-ketnoi-slogan">Kết nối với</p>
			<span class="home-ketnoi-name"><img src="{{ (isset($photo_static['logo']['photo']))?Thumb::Crop(UPLOAD_PHOTO,$photo_static['logo']['photo'],240,0,2):'' }}" onerror=src="{{asset('img/noimage.png')}}" alt="Logo"></span>
			<div class="home-ketnoi-mangxahoi">
				@php
					$mangxahoi = app('mangxahoi');
				@endphp
				@if($mangxahoi)
					@foreach($mangxahoi as $k=>$v)
						<a target="_blank" href="{{$v['link']}}" class=""><img src="{{ (isset($v['photo']))?UPLOAD_PHOTO.$v['photo']:'' }}" alt="{{$v['ten'.$lang]}}"></a>
					@endforeach	
				@endif
			</div>
		</div>
		<div class="home-ketnoi-right">
			@if($ketnoi)
				<div class="ketnoi_owl owl-carousel owl-theme">
					@foreach($ketnoi as $k=>$v)
						<div class="home-ketnoi-item">
							<div class="home-ketnoi-img"><img src="{{ (isset($v['background']))?Thumb::Crop(UPLOAD_PHOTO,$v['background'],210,162,1):'' }}" alt="{{$v['ten'.$lang]}}"></div>
							<div class="home-ketnoi-info">
								<p>{{$v['prename']}}</p>
								<span>Like us on {{$v['ten'.$lang]}}</span>
								<a href="{{$v['link']}}" targat="_blank" class="home-ketnoi-icon"><img src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PHOTO,$v['photo'],50,0,2):'' }}" onerror=src="{{asset('img/noimage.png')}}" alt="Logo"></a>
							</div>
						</div>
					@endforeach	
				</div>
			@endif
		</div>
	</div>
</div>
<!--KHÁCH HÀNG-->
{{-- <div class="home-customer bortop padlr">
	<h2 class="home-title"><span>Feedback khách hàng</span></h2>
	<div class="center-layout px-0 home-custom-main fix_carousel_owl"> --}}
		{{--@if(count($khachhangs)>3)<a href="khach-hang-danh-gia" class="home-custom-btn">Xem tất cả</a>@endif--}}
		@if($khachhangs)
			{{-- <div class="khachhang__owl owl-carousel owl-theme">
				@foreach($khachhangs as $k=>$v)
					@php
						$product = $v['has_product'];
						$arr_name = explode(' ', $v['tenvi']);
						$name = $arr_name[count($arr_name)-1];
						//$userrating = json_decode($v['userrating'],true);
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
			</div> --}}
			{{--
			<div class="khachhang__owl owl-carousel owl-theme">
				@foreach($khachhangs as $k=>$v)
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
			--}}
		@endif
	{{-- </div>
</div> --}}
<!--PRESS NEW-->
<div class="home-news bortop padlr">
	<h2 class="home-title"><span>Blog chia sẻ</span></h2>
	<div class="center-layout px-0">
		<div class="home-top-tabs">
			<span class="home-tab-item home-tab-post" data-type="tintuc">Bài viết</span>
			<span class="home-tab-item home-tab-post" data-type="video">Video</span>
		</div>
		<div id="home-tab-show-post" class=""></div>
	</div>
</div>
<!--HỎI ĐÁP-->
@include('desktop.layouts.hoidap')
<!--NHÀ CUNG CẤP-->
<div class="home-supplier bortop padlr">
	<h2 class="home-title"><span>Nhà cung cấp chính hãng</span></h2>
	<div class="home-supplier-main">
		<div class="center-layout px-0 fix_carousel_owl">
			<div class="nhacungcap_owl owl-carousel owl-theme fix-carousel-off">
				@if($nhacungcap)
					@foreach($nhacungcap as $k=>$v)
						<a class="nhacungcap_item" target="_blank" href="{{$v['link']}}" class=""><img src="{{ Thumb::Crop(UPLOAD_PHOTO,$v['photo'],250,100,2,$v['type']) }}" width="250" height="100" alt="{{$v['ten'.$lang]}}"></a>
					@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
<!--CHÍNH SÁCH-->
<div class="home-chinhsach bortop padlr">	
	<div class="center-layout px-0 home-chinhsach-main">
		@php
			$chinhsachs = app('chinhsachs');
		@endphp
		@if($chinhsachs)
			@foreach($chinhsachs as $k=>$v)
				@if($v['noibat']==1)
				<a class="chinhsach_item" target="_blank" href="{{$v['tenkhongdau'.$lang]}}" class="">
					<img src="{{ Thumb::Crop(UPLOAD_POST,$v['icon'],30,0,1,$v['type']) }}" width="30" height="30">
					<span>{{$v['ten'.$lang]}}</span>
				</a>
				@endif
			@endforeach
		@endif
	</div>
</div>
@endsection
<!--js thêm cho mỗi trang-->
@push('js_page')
<script async src="https://cse.google.com/cse.js?cx=78701a61bff88b6e3"></script>
<script>
	$(document).ready(function(){
		$('.home-tab-post').click(function(){
			var type = $(this).attr('data-type');
			LoadPostData(type);
			$('.home-tab-post').removeClass('home-tab-active');
			$(this).addClass('home-tab-active');
		});
		$('.home-search-tags-item').click(function(){
			var value = $(this).attr('data-value');
			$('input[name="search"]').val(value);
			$('.gsc-search-button').trigger('click');
		});
	});
	$(window).on('load', function () {
		$(".gsc-input").attr('placeholder', 'Nhập câu hỏi...');
		var e = $("body").find(".home-tab-post").eq(0);
		if(e.exists()){
			var type = e.attr('data-type');		
			LoadPostData(type);
			$('.home-tab-post').removeClass('home-tab-active');
			e.addClass('home-tab-active');
		}
	});
	function LoadPostData(type)
	{
		$.ajax({
			url: "{{ route('ajax.loadPostlist') }}",
			type: 'GET',
			dataType: 'html',
			async: false,
			data: {type:type},
			success:function(data)
			{
				$('#home-tab-show-post').html(data);
				var w_window = $(window).width();
				var owl = $('.post__owl__tab');
				owl.owlCarousel({
					items: 4,
					autoplay: false,
					loop: false,
					lazyLoad: true,
					mouseDrag: true,
					autoplayHoverPause:true,
					margin: 34,
					nav: false,
					dots: true,
					responsiveClass:true,
				    responsive:{
				        0:{
				            items:2,
				            nav:false,
				            margin: 10,
				            dots:false
				        },
				        651:{
				            items:3,
				            nav:false,
				            margin: 10,
				            dots:false
				        },
				        1025:{
				            items:4,
				            nav:false,
				            margin: 34,
				            dots:false
				        }
				    }
				});	
			}
		});
	}
</script>
@endpush
@push('strucdata')
	@include('desktop.layouts.strucdata')
@endpush