@foreach($gallery_multy as $k=>$v)
	<div class="miko-gallery-item">
		<div class="miko-gallery-img"><img src="{{config('config_upload.UPLOAD_GALLERY').$v['photo']}}" alt=""></div>
		<p class="miko-gallery-name"><span>{{$v['photo']}}</span></p>
		<ul class="miko-gallery-tool d-flex align-items-center justify-content-between">
			<li class="ml-2"><a class="miko-gallery-multy-delete" data-id="{{$v['id']}}" data-folder="gallery"><i class="fas fa-trash-alt"></i></a></li>
		</ul>
	</div>
@endforeach