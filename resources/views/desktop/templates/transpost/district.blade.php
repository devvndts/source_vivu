@if($district)
	@if($transpost_type=='ViettelPost')
		@foreach($district as $k=>$v)
			<div class="location-option" data-value="{{$v['DISTRICT_ID']}}" data-box="district" type="{{$transpost_type}}">{{$v['DISTRICT_NAME']}}</div>
		@endforeach
	@endif
@endif