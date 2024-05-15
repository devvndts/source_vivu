@if($galleries)
	@php
		$url_gallery = config('config_upload.UPLOAD_GALLERY');
	@endphp
	<div class="miko-gallery-contain">
		@foreach($galleries as $k=>$v)
			<div class="miko-gallery-item miko-gallery-item-{{$v['id']}}">
				<div class="miko-gallery-img"><img src="{{ config('config_upload.UPLOAD_GALLERY').$v['photo'] }}" alt=""></div>
				<p class="miko-gallery-name"><span>{{$v['photo']}}</span></p>
				<ul class="miko-gallery-tool d-flex align-items-center justify-content-between">
					<li class="ml-2">
						<a class="miko-gallery-delete" data-id="{{$v['id']}}" data-folder="gallery"><i class="fas fa-trash-alt"></i></a>
					</li>
					<li class="mr-1">
						<div class="custom-control custom-checkbox d-inline-block align-middle text-md">
							<input type="checkbox" class="custom-control-input gallery-checkbox" id="gallery-checkbox-{{$v['id']}}" value="{{$v['id']}}">
							<label for="gallery-checkbox-{{$v['id']}}" class="custom-control-label font-weight-normal"></label>
						</div>
					</li>
				</ul>
				<input type="hidden" class="" value="{{$v['stt']}}" placeholder="Số thứ tự" data-info="stt" data-id="{{$v['id']}}"/>
				<input type="hidden" class="" value="{{$v['tenvi']}}" placeholder="Tiêu đề" data-info="tieude" data-id="{{$v['id']}}"/>
			</div>
		@endforeach
	</div>
@endif




@if($galleries)
{{--
<div class="jFiler-items my-jFiler-items jFiler-row">
    <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
        @foreach($galleries as $v)
            @php
            	$folder_url = Helper::GetFolder('gallery',true);
            @endphp
			<li class="jFiler-item my-jFiler-item my-jFiler-item-{{$v['id']}} col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6" data-id="{{$v['id']}}">
				<div class="jFiler-item-container">
					<div class="jFiler-item-inner">
						<div class="jFiler-item-thumb">
							<div class="jFiler-item-thumb-image">
								<img src="{{$folder_url.$v['photo']}}" alt="{{$v['tenvi']}}"><i class="fas fa-arrows-alt"></i>
							</div>
						</div>
						<p class="gallery-image-name"><span>{{$v['photo']}}</span></p>
						<div class="jFiler-item-assets jFiler-row">
							<ul class="list-inline pull-right d-flex align-items-center justify-content-between">
								<li class="ml-1">
									<a class="icon-jfi-trash jFiler-item-trash-action my-jFiler-item-trash" data-id="{{$v['id']}}" data-folder="gallery"></a>
								</li>
								<li class="mr-1">
									<div class="custom-control custom-checkbox d-inline-block align-middle text-md">
										<input type="checkbox" class="custom-control-input filer-checkbox" id="filer-checkbox-{{$v['id']}}" value="{{$v['id']}}">
										<label for="filer-checkbox-{{$v['id']}}" class="custom-control-label font-weight-normal"></label>
									</div>
								</li>
							</ul>
						</div>
						<input type="hidden" class="form-control form-control-sm my-jFiler-item-info rounded mb-1" value="{{$v['stt']}}" placeholder="Số thứ tự" data-info="stt" data-id="{{$v['id']}}"/>
						<input type="hidden" class="form-control form-control-sm my-jFiler-item-info rounded" value="{{$v['tenvi']}}" placeholder="Tiêu đề" data-info="tieude" data-id="{{$v['id']}}"/>
					</div>
				</div>
			</li>
        @endforeach
    </ul>
</div>
--}}
@endif