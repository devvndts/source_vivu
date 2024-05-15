@if($items)	
<div class="">
	<div class="post__owl post__owl__tab owl-carousel owl-theme dot_dev">
		@foreach($items as $k=>$v)
			<div class="box-post-item">
				<a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1 box-post-img" title="{{$v['ten'.$lang]}}">
					@if($v['type']!='video')
	                	<img class="lazy loaded" data-src="{{ Thumb::Crop(UPLOAD_POST,$v['photo'],280,203,1,$v['type']) }}" data-srcset="{{ Thumb::Crop(UPLOAD_POST,$v['photo'],280,203,1,$v['type']) }} 1024w, {{ Thumb::Crop(UPLOAD_POST,$v['photo'],280,203,1,$v['type']) }} 600w" data-sizes="auto" alt="{{$v['ten'.$lang]}}" sizes="auto" srcset="{{ Thumb::Crop(UPLOAD_POST,$v['photo'],280,203,1,$v['type']) }} 1024w, {{ Thumb::Crop(UPLOAD_POST,$v['photo'],280,203,1,$v['type']) }} 600w" src="{{ Thumb::Crop(UPLOAD_POST,$v['photo'],280,203,1,$v['type']) }}" data-was-processed="true" width="280" height="203">
	                @else
	                	<img class="lazy loaded" data-src="{{ Helper::GetThumbYoutube($v['video']) }}"  sizes="auto" srcset="{{ Helper::GetThumbYoutube($v['video']) }} 1024w, {{ Helper::GetThumbYoutube($v['video']) }} 600w" src="{{ Helper::GetThumbYoutube($v['video']) }}" data-was-processed="true" width="280" height="203">
	                @endif
	            </a>
	            <h3 class="box-post-name limit-2"><a href="{{$v['tenkhongdau'.$lang]}}">{{$v['ten'.$lang]}}</a></h3>
	            <div class="box-post-detail">
		            <p class="box-post-date">{{date('d/m/Y',$v['ngaytao'])}}</p>
		            <div class="box-post-descript">{{Str::limit($v['mota'.$lang],110)}}</div>
		        </div>
			</div>
		@endforeach
	</div>
</div>
@endif