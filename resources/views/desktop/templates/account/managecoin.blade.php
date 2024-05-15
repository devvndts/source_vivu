@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-coin-form" action="{{ route('account.managecoin') }}" method="POST" enctype="multipart/form-data" class="manage-form-contain hidden-info-user">
			@csrf

			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">
				<div class="manage-form-guide"><a href="huong-dan-nap-rut-xu" target="_blank"><i class="fal fa-bullseye-pointer mr-2"></i>Hướng dẫn nạp/rút xu</a></div>
				<div class="manage-form-field">
					<label for="tongxu">Số xu hiện có</label>
					<input id="tongxu" type="text" class="manage-form-field-input" placeholder="" value="{{$user['tongxu']}}" readonly="">					
				</div>
				<div class="manage-form-field">
					<label for="hinhthuc">Hình thức</label>
					<select name="hinhthuc" class="manage-form-field-select manage-form-hinhthuc">
						<option value="">Chọn hình thức ---</option>
						<option value="0">Nạp xu</option>
						<option value="1">Rút xu</option>
					</select>
					<span class="login-form-alert">{{(isset($validates['hinhthuc'])) ? $validates['hinhthuc'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<label for="phuongthuc">Phương thức thanh toán</label>
					<select name="phuongthuc" class="manage-form-field-select">
						<option value="">Chọn phương thức ---</option>
						<option value="0">Thanh toán qua momo</option>
						<option value="1">Thanh toán qua tài khoản ngân hàng</option>
					</select>
					<span class="login-form-alert">{{(isset($validates['phuongthuc'])) ? $validates['phuongthuc'][0] : ''}}</span>
				</div>

				<div id="manage-form-show-phuongthuc" class="mb-4">
					<div class="manage-form-show-item manage-form-show-item-0">{!! $thanhtoanmomo['noidung'.$lang] !!}</div>
					<div class="manage-form-show-item manage-form-show-item-1">{!! $thanhtoannganhang['noidung'.$lang] !!}</div>
				</div>

				<div class="manage-form-field">
					<label for="giatrixunap" class="d-flex">Giá trị nạp/rút (xu) <span id="show_coin_convert" class="ml-2 d-none"></span></label>
					<input id="giatrixunap" type="text" name="giatrixunap" class="manage-form-field-input" placeholder="" value="0">
					<span class="login-form-alert">{{(isset($validates['giatrixunap'])) ? $validates['giatrixunap'][0] : ''}}</span>
				</div>
				<div class="manage-form-field d-none" id="show_magiaodich">
					<label for="magiaodich">Mã giao dịch (momo/ngân hàng)</label>
					<input id="magiaodich" type="text" name="magiaodich" class="manage-form-field-input" placeholder="" value="">
					<span class="login-form-alert">{{(isset($validates['magiaodich'])) ? $validates['magiaodich'][0] : ''}}</span>

					<div class="postnews-image postnews-form-img mt-4">
						<span id="photoUpload-code" class="manage-form-img-preview">
							<img src="img/icon/icon_camera.png" alt="camera">
						</span>
						<p class="postnews-image-label">Mã code giao dịch</p>
						<label class="module-upload-file css-upload-file" id="photo-code-zone" for="code-zone" data-preview="photoUpload-code">
							<input type="file" name="file" id="code-zone">
						</label>
					</div>

				</div>
				<input type="hidden" id="coin-setting" value="{{$settingOption['giatrixu']}}" name="">
				<button type="submit" class="manage-form-submit">Gửi yêu cầu</button>
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
		$('.manage-form-hinhthuc').change(function(){
			var val = $(this).val();
			if(val==0){
				$('#show_magiaodich').addClass('d-block');
				$('#show_magiaodich').removeClass('d-none');
			}else if(val==1){
				$('#show_magiaodich').addClass('d-none');
				$('#show_magiaodich').removeClass('d-block');
			}
		});

		$('select[name="phuongthuc"]').change(function(){
			var value = $(this).val();
			console.log(value);
			$('.manage-form-show-item').removeClass('manage-form-show-item-active');
			$('.manage-form-show-item-'+value).addClass('manage-form-show-item-active');
		});
	</script>

	<script>
		var cleave = new Cleave('#giatrixunap', {
		    numeral: true
		});		

		$('#giatrixunap').keyup(function(){
			var coin_setting = $('#coin-setting').val();
			var soxu = $(this).val();
			var quydoi = soxu*coin_setting;

			if(soxu>0){
				$('#show_coin_convert').removeClass('d-none').addClass('d-block').text('( ='+quydoi+' VNĐ )');
			}else{
				$('#show_coin_convert').addClass('d-none').removeClass('d-block');
			}
		});
	</script>
@endpush


@push('strucdata')


@endpush