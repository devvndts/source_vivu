<div class="detail__gallery_left">
	@if($gallery_color)
		@foreach($gallery_color as $k=>$v)
			<a class="thumb-pro-detail gallery-photo-scroll" data-zoom-id="Zoom-1" href="#gallery-photo-{{$v['id']}}" title="{{$v['ten'.$lang]}}">
				<img src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],800,0,1,$v['com']):'' }}" alt="{{$v['ten'.$lang]}}">
			</a>
		@endforeach
	@endif
</div>
<div class="detail__gallery_right">
	@if($gallery_color)
		@foreach($gallery_color as $k=>$v)
			<a id="gallery-photo-{{$v['id']}}" href="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],800,0,1,$v['com']):'' }}" title="{{$v['ten'.$lang]}}"><img src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],800,0,1,$v['com']):'' }}" alt="{{$v['ten'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',800,0,1)}}"></a>
		@endforeach
	@else
		<a href="{{ (isset($row_detail['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$row_detail['photo'],800,0,1,$row_detail['type']):'' }}" title="{{$row_detail['ten'.$lang]}}"><img src="{{ (isset($row_detail['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$row_detail['photo'],800,0,1,$row_detail['type']):'' }}" alt="{{$row_detail['ten'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',800,0,1)}}"></a>
	@endif
</div>