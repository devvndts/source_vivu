@if($galleries)
	<div class="action-filer mb-3">
    	@php
    		$folder_gallery = config('config_all.folder_gallery');
    	@endphp

    	<select name="gallery_folder" class="gallery-folder mr-2" id="gallery-folder">
    		<option value="">Tất cả hình ảnh</option>
    		@foreach($folder_gallery as $k=>$v)
    			<option value="{{$v['type']}}">{{$v['name']}}</option>
    		@endforeach
    	</select>        
    </div>
	@php
		$url_gallery = config('config_upload.UPLOAD_GALLERY');
	@endphp
	<div class="miko-loadimage-contain">
		@foreach($galleries as $k=>$v)
			<div class="miko-loadimage-item miko-loadimage-{{$v['folder']}}" data-id="{{$v['id']}}" data-photo-url="{{$v['photo']}}" data-path="{{$url_gallery}}">
				<img src="{{ config('config_upload.UPLOAD_GALLERY').$v['photo'] }}" alt="">
			</div>
		@endforeach
	</div>
@endif