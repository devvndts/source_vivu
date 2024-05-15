@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-coin-form" class="manage-form-contain" action="{{route('account.report')}}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">
				<div class="manage-form-field">
					<label for="tieude">Tiêu đề</label>
					<input id="tieude" type="text" name="tieude" class="manage-form-field-input" placeholder="" value="" required>
					<span class="login-form-alert">{{(isset($validates['tieude'])) ? $validates['tieude'][0] : ''}}</span>
				</div>

				<div class="manage-form-field">
					<label for="ghichu">Ghi chú</label>
					<textarea id="ghichu" name="ghichu" class="manage-form-field-textarea" rows="3" placeholder=""></textarea>
					<span class="login-form-alert">{{(isset($validates['ghichu'])) ? $validates['ghichu'][0] : ''}}</span>
				</div>

				<div class="postnews-image postnews-form-img">
					<span id="photoUpload-preview-rp" class="manage-form-img-preview">
						<img src="img/icon/icon_camera.png" alt="camera">
					</span>
					<p class="postnews-image-label">Hình đính kèm</p>
					<label class="module-upload-file css-upload-file" id="photo-zone-rp" for="file-zone-rp" data-preview="photoUpload-preview-rp">
						<input type="file" name="file" id="file-zone-rp">
					</label>
				</div>
				
				<button type="submit" class="manage-form-submit">Gửi đóng góp</button>
			</div>
		</form>
	</div>
@endsection

@push('css_page')
	<link rel="stylesheet" href="{{ asset('plugins/jquery-ui-1-13/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('css/manage.css') }} ">
@endpush

<!--js thêm cho mỗi trang-->

@push('js_page')	
	<script src="{{ asset('plugins/jquery-ui-1-13/jquery-ui.min.js') }}"></script>

	<script>
		var cleave = new Cleave('#giatrinap', {
		    numeral: true
		});		
	</script>
@endpush


@push('strucdata')


@endpush