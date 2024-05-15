@if($city)
	@if($transpost_type=='ViettelPost')		
		@foreach($city as $k=>$v)
			<div class="location-option" data-value="{{$v['PROVINCE_ID']}}" data-box="city" type="{{$transpost_type}}">{{$v['PROVINCE_NAME']}}</div>
		@endforeach
	@endif
@endif