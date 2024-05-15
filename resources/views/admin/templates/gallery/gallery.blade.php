@extends('admin.master')

@section('content')
<form id="fileupload-form">
	@csrf
	<div class="card-footer text-sm sticky-top d-none">
        <button type="submit" class="btn btn-sm bg-gradient-primary gallery-submit"><i class="far fa-save mr-2"></i>Thêm mới</button> 
    </div>

    <div id="gallery-show-upload" class="gallery-show-upload gallery-images-main">
    	<span class="gallery-btn-close d-none"><i class="far fa-times"></i></span>
    	<svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="#26b99acc"><path d="M19.5 13c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h7c1.695 1.942 2.371 3 4 3h13v7.82c-1.169-1.124-2.754-1.82-4.5-1.82-3.584 0-6.5 2.916-6.5 6.5 0 1.747.695 3.331 1.82 4.5z"/></svg>
    	<p class="gallery-show-title">Chọn hoặc kéo thả hình ảnh</p>
    	<p class="gallery-show-btn"><span>Chọn hình</span></p>
	    <div class="form-group" id="photo-upload-group">
	        <input type="file" name="files[]" id="upload-gallery" multiple="multiple">
	        <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
	        <input type="hidden" class="act-filer" name="level" value="man">
	        <input type="hidden" class="folder-filer" name="model" value="gallery">
	        <input type="hidden" class="folder-filer" name="type" value="gallery">
	        <input type="hidden" name="hash" value="gallery" />
	    </div>
	</div>


	<div class="form-group form-group-gallery form-group-gallery-main gallery-images-main">
        <div class="action-filer mt-3 mb-3">
        	@php
        		$folder_gallery = config('config_all.folder_gallery');
        	@endphp

        	<select name="gallery_folder" class="gallery-folder mr-2" id="gallery-folder">
        		<option value="">Tất cả hình ảnh</option>
        		@foreach($folder_gallery as $k=>$v)
        			<option value="{{$v['type']}}">{{$v['name']}}</option>
        		@endforeach
        	</select>
            <a class="btn btn-sm bg-gradient-primary text-white check-all-gallery mr-2 {{($galleries) ? '' : 'd-none'}}"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
            {{--<button type="button" class="btn btn-sm bg-gradient-success text-white sort-filer mr-1"><i class="fas fa-random mr-2"></i>Sắp xếp</button>--}}
            <a class="btn btn-sm bg-gradient-danger text-white delete-all-gallery {{($galleries) ? '' : 'd-none'}}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
        </div>
        <div class="alert my-alert alert-sort-filer alert-info text-sm text-white bg-gradient-info"><i class="fas fa-info-circle mr-2"></i>Có thể chọn nhiều hình để di chuyển</div>

        <div id="gallery-show-display">
        	@include('admin.layouts.show_gallery')
        </div>
    </div>
</form>
@endsection


<!--css thêm cho mỗi trang-->
@push('css')
	<link rel="stylesheet" href="{{ asset('css/admin/gallery.css') }} ">
@endpush


<!--js thêm cho mỗi trang-->
@push('js')
	<script>
		$('.gallery-submit, .gallery-btn-close').click(function(){
			$('#gallery-show-upload').toggle();
		});
	</script>

	<script>
		/* Thêm hình vô thư viện */
		$('body').on('change', '#upload-gallery', function(){
			var formData = new FormData($('#fileupload-form')[0]);

			$.ajax({
		      url: "{{route('admin.gallery.save')}}",
		      type: 'POST',
		      dataType: "html",
		      data: formData,
		      processData: false,
		      contentType: false,
		      success: function(result) {
		      	$('#gallery-show-display').html(result);
		      	$('.check-all-gallery').removeClass('d-none');
		      	$('.delete-all-gallery').removeClass('d-none');
		      }
		   });
		});


		/* Thay đổi thư mục chọn hiển thị */
		$('body').on('change', '#gallery-folder', function(){
			var folder = $(this).val();

			$.ajax({
		      url: "{{route('admin.gallery.change')}}",
		      type: 'GET',
		      dataType: "html",
		      data: {folder:folder},
		      success: function(result) {
		      	$('#gallery-show-display').html(result);
		      	$('.check-all-gallery').removeClass('d-none');
		      	$('.delete-all-gallery').removeClass('d-none');
		      }
		   });
		});


		/* Delete a gallery item */
		$("body").on("click",".miko-gallery-delete",function(){
			var id = $(this).data("id");
			var folder = $(this).data("folder");
			var str = id+","+folder;
			confirmDialog("delete-gallery","Bạn có chắc muốn xóa hình ảnh này ?",str);
        });

        /* Delete all gallery */
		$("body").on("click",".delete-all-gallery",function(){
			var folder = $(".folder-filer").val();
			confirmDialog("delete-all-gallery","Bạn có chắc muốn xóa các hình ảnh đã chọn ?",folder);
        });

        /* Check all filer */
		$('body').on('click','.check-all-gallery', function(){
			var e_parent = $('.miko-gallery-contain');
			var input = e_parent.find('input.gallery-checkbox');
			//console.log(input)

			if($(this).hasClass('active'))
			{
				$('.miko-gallery-tool').removeClass('miko-tool-active');				
				$(this).removeClass('active');
				input.each(function(){
					$(this).prop('checked',false);
				});
			}
			else
			{
				$('.miko-gallery-tool').addClass('miko-tool-active');
				$(this).addClass('active');
				input.each(function(){
					$(this).prop('checked',true);
				});
			}
		});
	</script>
@endpush