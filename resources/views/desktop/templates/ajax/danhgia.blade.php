@if(isset($danhgia_list) && $danhgia_list)
	@foreach($danhgia_list as $k=>$v)
		@php
			$arr_name = explode(' ', $v['tenvi']);
			$name = $arr_name[count($arr_name)-1];
			$photos = json_decode($v['photo'], true);
		@endphp
		<div class="box-danhgia-item">
			<span class="box-danhgia-char">{{Str::substr($name, 0, 1);}}</span>
			<div class="box-danhgia-info">
				<div class="box-danhgia-infoname">
					<div class="box-danhgia-name mr-2">{{$v['tenvi']}}</div>
					<div class="box-danhgia-time">{{Helper::TimeElapsed($v['ngaytao'])}}</div>
				</div>
				<div class="box-danhgia-infostar">
					<div class="box-danhgia-star-list mr-2">
						@for($i=1;$i<=$v['star'];$i++)
							<i class="fas fa-star"></i>
						@endfor
						@for($i=$v['star']+1;$i<=5;$i++)
							<i class="far fa-star"></i>
						@endfor
					</div>
					<div class="box-danhgia-confirm"><i class="far fa-badge-check"></i> <span>Đã mua sản phẩm</span></div>
				</div>
				<div class="box-danhgia-content mt-3">{{$v['noidungvi']}}</div>
				<div class="box-danhgia-photos mt-3">
					@if($photos)
						@foreach($photos as $p=>$photo)
							<a href="{{UPLOAD_IMAGE.$photo}}" class="mr-1"><img src="{{Thumb::Crop(UPLOAD_IMAGE,$photo,88,88,2)}}" alt=""></a>
						@endforeach
					@endif
				</div>
				<div class="box-danhgia-date mt-2">{{date('d/m/Y', $v['ngaytao'])}} lúc {{date('h:m', $v['ngaytao'])}}</div>
			</div>
		</div>
	@endforeach

	@if(isset($danhgia_list) && !is_array($danhgia_list))
		<div class="clear"></div>
        <div class="row">
           <div class="col-sm-12 dev-center dev-paginator">{{ $danhgia_list->links() }}</div>
        </div>
    @endif
@endif