<div class="header-top display-relative">
	<div class="center-layout ">
		<div class="header-top-checkcart"><a href="{{route('cart.checkcart')}}">Kiểm tra đơn hàng</a></div>
		<div class="header-top-slogan"><marquee>{!! $settingOption['marquee'] !!}</marquee></div>
		<div class="header-top-mxh">
			@php
				$mangxahoi = app('mangxahoi_f');
			@endphp
			@foreach($mangxahoi as $k=>$v)
				<a target="_blank" href="{{$v['link']}}" class=""><img src="{{ (isset($v['photo']))?UPLOAD_PHOTO.$v['photo']:'' }}" alt="{{$v['ten'.$lang]}}"></a>
			@endforeach			
		</div>
	</div>
</div>

<div id="header">
	<div class="header-contain center-layout">
		<div class="header-left">
			<a href="" class="header-logo">
				<img src="{{ (isset($photo_static['logo']['photo']))?Thumb::Crop(UPLOAD_PHOTO,$photo_static['logo']['photo'],180,0,2):'' }}" onerror=src="{{asset('img/noimage.png')}}" alt="Logo">
			</a>
		</div>
		<div class="header-menu">
			<ul id="menu-main">
				<li><a>Lovefish Aqua</a>
					<ul>
						<li><a href="gioi-thieu">Giới thiệu</a></li>
						<li><a href="chinh-sach">Chính sách</a></li>
					</ul>
				</li>
				<li><a href="san-pham">Sản phẩm</a>
					{!! Helper::showCategoryMenuMulty('menu-main-sub'); !!}
				</li>
				<li><a>Tài nguyên</a>
					<ul>
						<li><a href="tin-tuc">Blog chia sẻ</a></li>
						<li><a href="khach-hang-danh-gia">Feedback</a></li>
						<li><a href="video">Video</a></li>
						<li><a href="cau-hoi">Câu hỏi</a></li>
					</ul>
				</li>
				<li><a href="ho-tro">Hỗ trợ</a>
					<ul>
						<li><a href="lien-he">Liên hệ</a></li>
						<li><a href="cau-hoi">Đặt câu hỏi</a></li>
					</ul>
				</li>
			</ul>				
		</div>	
		<div class="header-right">
			@if(isset($danhmuc3) || isset($thuonghieus))
			<a class="filter-product-btn ml-4"><i class="fal fa-filter"></i></a>
			@endif
			<div class="header-menu-btn ml-4" data-id="#modal-menu"><span></span></div>
			<a class="header-cart ml-3 fix_cart_count">
				<span class="count-cart ajax-count-cart">{{app('share_all_cart')}}</span>
			</a>
			<div class="header-search">
				<button type="button" class=""><img src="{{asset('img/icon/search.png')}}" alt="search"></button>
			</div>			
		</div>		
	</div>

	<!--Box search-->
	<div class="header-search-container">
		<div class="center-layout header-search-main">
			<span class="header-search-close"><svg class="icon icon--close" viewBox="0 0 19 19" role="presentation"> <path d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z" fill="currentColor" fill-rule="evenodd"></path> </svg></span>
			<div class="header-search-top">
				<input type="text" id="keyword_mobile" placeholder="{{ __('Tìm kiếm') }}" onkeypress="doEnter(event,'keyword_mobile');">
				<button type="button" onclick="onSearch('keyword_mobile');" class=""><img src="{{asset('img/icon/search.png')}}" alt="search"></button>
			</div>
			<div class="header-search-bot">
				<div class="row header-search-inner">					
					<div class="col-5 header-search-left">
						<div class="header-search-sticky">
							<p class="header-search-title mb-3">Từ khóa nổi bật</p>
							@php
								$tagproduct = app('tagproduct');
							@endphp
							@if($tagproduct)
								<div class="header-search-tags">
									@foreach($tagproduct as $k=>$v)
										<a class="header-search-tag-item" href="tags/{{$v['tenkhongdau'.$lang]}}">{{$v['ten'.$lang]}}</a>
									@endforeach
								</div>
							@endif
						</div>
					</div>
					<div class="col-7 header-search-right">
						<p class="header-search-title mb-3">Danh mục nổi bật</p>
						<div class="home-danhmuc-list home-danhmuc-list-res">
							@php
								$danhmuc_cap3 = app('danhmuc_cap3');
							@endphp
							@if($danhmuc_cap3)
								@foreach($danhmuc_cap3 as $k=>$v)
									<a class="home-danhmuc-item himg" href="{{$v['tenkhongdau'.$lang]}}">
										<p class="home-danhmuc-name"><span>{{$v['ten'.$lang]}}</span></p>
										<img class="home-danhmuc-img /lazy /loaded"src="{{ Thumb::Crop(UPLOAD_CATEGORY,$v['photo'],390,480,2,$v['type']) }}" alt="{{$v['ten'.$lang]}}" width="130" height="160">
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
		</div>
	</div>
</div>

<div id="modal-menu">
	<div class="center-layout px-0">
		<div class="modal-menu-close-main"><span class="modal-menu-close"></span></div>
		{{--
		<div class="header-search res-header-search">
			<input type="text" id="keyword" placeholder="Search" onkeypress="doEnter(event,'keyword');">
			<button type="button" onclick="onSearch('keyword');" class=""><img src="{{asset('img/search.png')}}" alt="search"></button>
		</div>--}}
		<div class="modal-menu-container">
			<ul id="menu-side-mobile">
				<li>
					<div class="menu-side-title"><a href="">Home</a></div>
				</li>
				<li>
					<div class="menu-side-title">
						<a>Lovefish Aqua</a>
						<span><i class="fal fa-chevron-down"></i></span>
					</div>
					<ul>
						<li><a href="gioi-thieu">Giới thiệu</a></li>
						<li><a href="chinh-sach">Chính sách</a></li>
					</ul>
				</li>
				<li>
					<div class="menu-side-title">
						<a href="san-pham">Sản phẩm</a>
						<span><i class="fal fa-chevron-down"></i></span>
					</div>
					{!! Helper::showCategoryMenuMulty('menu-sidebar'); !!}					
				</li>
				<li>
					<div class="menu-side-title">
						<a>Tài nguyên</a>
						<span><i class="fal fa-chevron-down"></i></span>
					</div>
					<ul>
						<li><a href="tin-tuc">Blog chia sẻ</a></li>
						<li><a href="khach-hang-danh-gia">Feedback</a></li>
						<li><a href="video">Video</a></li>
						<li><a href="cau-hoi">Câu hỏi</a></li>
					</ul>
				</li>
				<li>
					<div class="menu-side-title">
						<a href="ho-tro">Hỗ trợ</a>
						<span><i class="fal fa-chevron-down"></i></span>
					</div>
					<ul>
						<li><a href="lien-he">Liên hệ</a></li>
						<li><a href="cau-hoi">Đặt câu hỏi</a></li>
					</ul>
				</li>
			</ul>			
		</div>
	</div>
</div>