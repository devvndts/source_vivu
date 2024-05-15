<div class="model_changecart_view">
	<div class="model_changecart_left">		
		<div class="gallery_cart_product owl-carousel owl-theme">
			<a class="thumb-pro-detail gallery-photo-scroll" data-zoom-id="Zoom-1" href="#gallery-photo-main" title="{{$row_detail['ten'.$lang]}}">
				@php
					$img = Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 430, 430, 2, $row_detail['type']);
				@endphp
				<x-shared.image src="{{ $img }}" />
			</a>
			@if($hinhanhsp)
				@foreach($hinhanhsp as $k=>$v)
				<a class="thumb-pro-detail gallery-photo-scroll" data-zoom-id="Zoom-1" href="#gallery-photo-{{$v['id']}}" >
					@php
						$img = Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 430, 430, 2, $v['type']);
					@endphp
					<x-shared.image src="{{ $img }}" />
				</a>
				@endforeach
			@endif
		</div>
		
	</div>
	<div class="model_changecart_right">
		<div class="model_changecart_fix">
			<div class="detail__name">{{$row_detail['ten'.$lang]}}</div>

			<div class="flex justify-between detail__price_contain">
				{{-- <div class="flex items-end detail__price">						
					<div class="detail__price--new detail__price--new{{$row_detail['id']}}">{{Helper::Format_Money($giamoi)}}</div>	
					@if($gia > $giamoi)
						<div class="detail__price--old detail__price--old{{$row_detail['id']}}">{{Helper::Format_Money($gia)}}</div>
					@endif
					<div class="detail__price--km detail__price--km{{$row_detail['id']}} {{($giakm>0) ? '': 'd-none'}}">-{{$giakm}}%</div>				
				</div> --}}
				@if ($row_detail["giamoi"] > 0)
					<div class="flex">
						<div class="detail__price--new font-semibold text-2xl text-primary detail__price--new{{$row_detail['id']}}">{{Helper::Format_Money($row_detail["giamoi"])}}</div>	
						<div class="ml-5 leading-6 text-base text-white py-[2px] px-[7px] rounded-[3px] bg-primary detail__price--km detail__price--km{{$row_detail['id']}} {{($row_detail["giakm"]>0) ? '': 'hidden'}}">-{{$row_detail["giakm"]}}%</div>
					</div>
					<div class="detail__price--old font-semibold text-base mt-3 text-black text-opacity-50 line-through detail__price--old{{$row_detail['id']}}">{{Helper::Format_Money($row_detail["gia"])}}</div>
				@else
					<div class="detail__price--new detail__price--new{{ $row_detail['id'] }}">{{ Helper::Format_Money($row_detail["gia"]) }}</div>	
				@endif
			</div>

			<div class="mb-2 font-weight-bold detail__properties__masp">Mã sản phẩm: <span class="sku{{$row_detail['id']}}">{{$row_detail['masp']}}</span></div>

			@if($mau!='')
			@php
				$masp_colors = ($row_detail['masp_color']!='') ? json_decode($row_detail['masp_color'],true) : null;
			@endphp

			<div class="py-2 detail__properties detail__properties__color">
				<div class="mb-2 detail__properties__name">Màu sắc: <span id="color-current"></span></div>
				<div class="flex-wrap d-flex">
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

			@if($size!='')
				<div class="py-3 detail__properties detail__properties__size">
					<div class="detail__properties__name d-none">Size: <span id="size-current"></span></div>
					<div class="flex-wrap d-flex" id="product_detail_size">
						@foreach ($size as $key => $value)
							<a class="size-pro-detail text-decoration-none mr-1 {{($key == 0) ? 'active' : ''}} {{($key == 0 && count($size) > 1) ? 'SizefirstOption' : ''}}" data-id="{{$row_detail['id']}}">
								<input type="radio" value="{{$value['id']}}" class="detail__properties-items js-select-variant !min-w-[20px] !min-h-[20px] !text-xs" name="size-pro-detail" {{($key == 0) ? 'checked' : ''}}>
								{{$value['ten'.$lang]}}
							</a>
						@endforeach
					</div>
				</div>
			@endif

			{{-- @if($row_detail['mota'.$lang] != '')
			<div class="my-2 detail__properties__des">
				<div class="product_detail_des">{!! $row_detail['mota'.$lang] !!}</div>
			</div>
			@endif --}}

			{{-- @php
				$cta = get_photos('cta', 'vi', ['order_by' => ['stt' => 'asc']])->toArray();
				$ctaLink = ($row_detail["cta_link"]) ? mb_unserialize($row_detail["cta_link"] ?? '') : null;
			@endphp
			<div class="flex flex-wrap my-5 align-baseline">
				@if ($cta && $ctaLink)
					@foreach ($cta as $item)
						@if ($ctaLink[$item->id])
							@php
								$url = $ctaLink[$item->id];
								$img = Thumb::Crop(UPLOAD_PHOTO,$item->photo,25,25,2);
							@endphp
							<a href="{{ $url }}" target="_blank" class="inline-block mr-4">
								<x-shared.image src="{{ $img }}" />
							</a>
						@endif
						
					@endforeach
				@endif
			</div> --}}


			{{-- <x-shared.readmore href="{{ url($row_detail[$sluglang]) }}" /> --}}
			<button type="button" class="flex w-full rounded-[3px] py-3 items-center justify-center detail__button bg-secondary js-action-cart" data-id="{{$row_detail['id']}}" data-oldcode="{{$code}}" data-action="changenow">
				<span class="text-lg font-bold text-white"><i class="mr-2 fal fa-shopping-bag"></i> {{ ($code!='') ? 'Cập nhật' : 'Thêm vào giỏ' }}</span>
			</button>
		</div>
	</div>
</div>

{{-- <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}"> --}}
<script src="{{ asset('js/product.js') }}"></script>