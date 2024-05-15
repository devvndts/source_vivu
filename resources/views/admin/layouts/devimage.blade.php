
@for($i=0;$i<$amount_images;$i++)
    <input type="hidden" name="data[photo{{($i>0) ? $i : ''}}]" id="show-gallery-namephoto-{{$i}}" value="">
    <input type="hidden" name="data[idphoto{{($i>0) ? $i : ''}}]" id="show-gallery-idphoto-{{$i}}" value="">
    <p id="show-gallery-photo-{{$i}}" class="show-gallery-photo"><img src="{{ ($rowItem['photo'.(($i>0) ? $i : '')]) ? config('config_upload.UPLOAD_GALLERY').$rowItem['photo'.(($i>0) ? $i : '')] : asset('img/noimage1.png') }}" alt=""></p>

    <div class="mb-3 miko-upload-image" data-toggle="modal" data-target="#modal_upload_image_{{$i}}">
        <p class="miko-upload-icon">
            <i class="fas fa-folder-open"></i>
            <span>Chọn hình ảnh trong thư viện</span>
        </p>
    </div>

    <div class="modal fade modal_upload_image modal_upload_one" id="modal_upload_image_{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="mr-2 fas fa-photo-video"></i> Thư viện ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body show-gallery-images"></div>
                <div class="modal-footer">
                    <p class="btn bg-gradient-primary miko-submit-gallery miko-submit-gallery-{{$i}}" data-op="{{$i}}">Xác nhận</p>
                </div>
            </div>
        </div>
    </div>
@endfor

<a class="miko-upload-setting" href="{{ route('admin.gallery.fileupload') }}" target="_blank"><i class="mr-1 fas fa-file-upload"></i> Quản lý thư viện ảnh</a>