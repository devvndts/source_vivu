<!--css thêm cho mỗi trang-->
@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/gallery.css') }} ">
@endpush


<div class="miko-upload-image mb-3" data-toggle="modal" data-target="#modal_upload_image_multy">
	<p class="miko-upload-icon">
		<i class="fas fa-folder-open"></i>
		<span>Chọn hình ảnh trong thư viện</span>
	</p>
</div>

<div class="modal fade modal_upload_image modal_upload_multy" id="modal_upload_image_multy" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-photo-video mr-2"></i> Thư viện ảnh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body show-gallery-images"></div>
            <div class="modal-footer">
                <p class="btn bg-gradient-primary miko-submit-gallery miko-submit-gallery-multy" data-op="multy" data-path="{{config('config_upload.UPLOAD_GALLERY')}}">Xác nhận</p>
            </div>
        </div>
    </div>
</div>

<div id="show-gallery-photo-multy" class="show-gallery-photo show-gallery-multy-photo">
    @if($gallery_multy)
        @include('admin.ajax.loadmultyimage')
    @endif
</div>