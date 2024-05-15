@if($result)
<div class="delivery__owl owl-carousel owl-theme">
	@foreach($result as $k=>$v)
		@php
			//dd($result);
		@endphp
		<div class="delivery_option">
			<input type="radio" class="custom-control-input" id="delivery-option-{{$k}}" name="option_delivery" data-type="{{$transpost_type}}" value="{{$v['MA_DV_CHINH']}}" required="">
			<div class="delivery_option_item">
				<div class="delivery_option_left"><i class="fas fa-truck"></i></div>
				<div class="delivery_option_right">
					<p class="delivery_option__name">{{$v['TEN_DICHVU']}}</p>
					<div class="delivery_option_info">
						<p class="delivery_option_time">Dự kiến giao hàng trong {{$v['THOI_GIAN']}}</p>
						<p class="delivery_option_ship"><i class="fas fa-money-bill-alt"></i> <span class="delivery_option_price" data-price-original="{{$v['GIA_CUOC']}}">{{Helper::Format_Money($v['GIA_CUOC'] + $insurance_price)}}</span></p>
					</div>
				</div>
			</div>
			<label class="" for="delivery-option-{{$k}}"></label>
		</div>
	@endforeach
</div>
@endif