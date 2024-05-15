<div class="photoUpload-zone">
	<div class="photoUpload-detail" id="photoUpload-preview2"><img class="rounded" src="{{ Helper::GetFolder($folder_upload,true).$rowItem['photo2'] }}" onerror=src="{{asset('img/noimage1.png')}}" alt="Alt Photo"/></div>
	<label class="photoUpload-file" id="photo-zone2" for="file-zone2">
		<input type="file" name="file2" id="file-zone2">
		<i class="fas fa-cloud-upload-alt"></i>
		<p class="photoUpload-drop">Kéo và thả hình vào đây</p>
		<p class="photoUpload-or">hoặc</p>
		<p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
	</label>
	@if($request->category=='man')
		<div class="photoUpload-dimension">{{ "Width: ".$config[$type]['width']*$config[$type]['ratio']." px - Height: ".$config[$type]['height']*$config[$type]['ratio']." px (".$config[$type]['img_type'].")" }}</div>
	@else
		<div class="photoUpload-dimension">{{ "Width: ".$config[$type]['width_'.$request->category]." px - Height: ".$config[$type]['height_'.$request->category]." px (".$config[$type]['img_type'].")" }}</div>
	@endif
</div>