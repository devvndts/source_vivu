@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
		//dd(date('d/m/Y',1657707728));
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-form" action="{{ route('account.manage') }}" method="POST" enctype="multipart/form-data" class="manage-form-contain hidden-info-account change-css-date">
			@csrf

			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">
				@if(isset($validates['otp']))<span class="login-form-alert login-form-alert-top">{{$validates['otp'][0]}}</span>@endif
				<div class="manage-form-field">
					<label for="username">Tên tài khoản</label>
					<input id="username" type="text" name="username" class="manage-form-field-input css-notallower" placeholder="" value="{{ $user['username'] }}" readonly="">
					<span class="login-form-alert">{{(isset($validates['username'])) ? $validates['username'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<label for="email">Email @if($user['email_new_kichhoat'])<span class="manage-email-verified">(Đã xác minh)</span>@endif</label>
					<div class="manage-form-email-pap">
						<input id="email" type="email" name="email" class="manage-form-field-input" placeholder="" value="{{ (old('email')) ? old('email') : $user['email'] }}">
						<span id="email-loading-gif"><img src="img/icon/loading.gif" alt="loading"></span>
					</div>
					<span class="login-form-alert">{{(isset($validates['email'])) ? $validates['email'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<label for="phonenumber">Điện thoại</label>
					<input id="phonenumber" type="text" name="phonenumber" class="manage-form-field-input" placeholder="" value="{{ $user['phonenumber'] }}">
					<span class="login-form-alert">{{(isset($validates['phonenumber'])) ? $validates['phonenumber'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<label for="name">Họ tên</label>
					<input id="name" type="text" name="name" placeholder="" class="manage-form-field-input" value="{{ $user['name'] }}">
					<span class="login-form-alert">{{(isset($validates['name'])) ? $validates['name'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<p class="manage-form-field-title">Giới tính</p>
					<div class="manage-form-field-sex">
						<input type="radio" id="sex_nam" name="gioitinh" value="0" {{ ($user['gioitinh']==0) ? 'checked' : '' }}>
						<label for="sex_nam">Nam</label><br>
						<input type="radio" id="sex_nu" name="gioitinh" value="1" {{ ($user['gioitinh']==1) ? 'checked' : '' }}>
						<label for="sex_nu">Nữ</label><br>
						<input type="radio" id="sex_khac" name="gioitinh" value="2" {{ ($user['gioitinh']==2) ? 'checked' : '' }}>
						<label for="sex_khac">Khác</label><br>
					</div>
				</div>
				<div class="manage-form-field">
					<label for="ngaysinh">Ngày sinh</label>
					<input id="ngaysinh" type="text" name="ngaysinh" placeholder="" class="manage-form-field-input" value="{{ date('d/m/Y',$user['ngaysinh']) }}">
					<span class="login-form-alert">{{(isset($validates['ngaysinh'])) ? $validates['ngaysinh'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<label for="somomo">Số tài khoản Momo</label>
					<input id="somomo" type="text" name="somomo" placeholder="Nhập số điện thoại" class="manage-form-field-input" value="{{ $user['somomo'] }}">
					<span class="login-form-alert">{{(isset($validates['somomo'])) ? $validates['somomo'][0] : ''}}</span>
				</div>
				<div class="manage-form-field">
					<label for="nganhang">Ngân hàng</label>
					<div class="manage-form-input">
						<input id="nganhang" type="text" name="" placeholder="Chọn ngân hàng" class="manage-form-field-input" value="{{ ($user['nganhang']) ? $nganhang_active['ten'.$lang] : 'Chọn ngân hàng' }}" readonly="">
						<span class="login-form-arrow"><i class="fas fa-caret-down"></i></span>
					</div>					
					<span class="login-form-alert">{{(isset($validates['nganhang'])) ? $validates['nganhang'][0] : ''}}</span>					
					@if($nganhangs)
					<div class="manage-form-nganhang-contain">
						<div class="manage-form-nganhang-list">
							@foreach($nganhangs as $k=>$v)
								<div class="manage-form-nganhang-item">
									<span class="himg"><img src="{{Thumb::Crop(UPLOAD_POST,$v['photo'],100,0,2)}}" alt="" width="100" height="100"></span>
									<label for="bank-id-{{$v['id']}}" class="manage-form-nganhang-label">
										<input type="radio" id="bank-id-{{$v['id']}}" class="manage-bank-radio" name="nganhang" value="{{$v['id']}}" {{ ($user['nganhang']==$v['id']) ? 'checked' : '' }}>
									</label>
								</div>
							@endforeach
						</div>
					</div>
					@endif
				</div>
				<div class="manage-form-field">
					<label for="sotaikhoan">Số tài khoản</label>
					<input id="sotaikhoan" type="text" name="sotaikhoan" placeholder="Nhập địa chỉ" class="manage-form-field-input" value="{{ $user['sotaikhoan'] }}">
					<span class="login-form-alert">{{(isset($validates['sotaikhoan'])) ? $validates['sotaikhoan'][0] : ''}}</span>					
				</div>				
				{{-- <button type="submit" class="manage-form-submit">Lưu</button> --}}
				<a class="manage-form-submit">Lưu</a>
			</div>
			<input type="hidden" name="otp" value="">
		</form>
	</div>

	<div class="manage-form-otp">
		<div class="manage-contain-otp">
			<span class="manage-close-otp"><i class="fal fa-times"></i></span>
			<p class="manage-title-otp">Nhập mã OTP</p>
			<p class="manage-title-des">Kiểm tra email để nhận mã xác thực !</p>
			<div class="manage-form-list-otp">
				<input type="number" name="maotp[]" class="manage-form-field-otp" value="">
				<input type="number" name="maotp[]" class="manage-form-field-otp" value="">
				<input type="number" name="maotp[]" class="manage-form-field-otp" value="">
				<input type="number" name="maotp[]" class="manage-form-field-otp" value="">
				<input type="number" name="maotp[]" class="manage-form-field-otp" value="">
				<input type="number" name="maotp[]" class="manage-form-field-otp" value="">
			</div>
			<span class="login-form-alert d-none" id="show-alert-otp">Chưa nhập mã xác thực !</span>	
		</div>
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
	<!-- daterangepicker -->
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

	<script>
		$('.manage-form-submit').click(function(){
			$('#loading_order').show();
			if(!$('#email-loading-gif').hasClass('email-loading-active')){
				//e.preventDefault();
				$('#email-loading-gif').addClass('email-loading-active');				
			}

			//### Kiểm tra  ngân hàng, số tài khoản hoặc số momo ==> gửi otp tới số điện thoại đã đăng ký
			var somomo = $('#somomo').val();
			var nganhang = $('input[name="nganhang"]:checked').val();
			var sotaikhoan = $('#sotaikhoan').val();

			$.ajax({
				url: '{{route('ajax.checkOTP')}}',
				type: "POST",
				dataType: 'json',
				async: true,
				data: {somomo:somomo, nganhang:nganhang, sotaikhoan:sotaikhoan, _token:$('meta[name="csrf-token"]').attr('content')},
				success: function(result_data){
					if(result_data.result==true){
						//console.log(result_data);
						$('#manage-form')[0].submit();
					}else{
						//$('input[name="otp"]').val(result_data.otp);
						$('.manage-form-otp').addClass('manage-form-otp-active');
						var e_num_1 = $('.manage-form-field-otp').eq(0);
						var e_num_2 = $('.manage-form-field-otp').eq(1);
						var e_num_3 = $('.manage-form-field-otp').eq(2);
						var e_num_4 = $('.manage-form-field-otp').eq(3);
						var e_num_5 = $('.manage-form-field-otp').eq(4);
						var e_num_6 = $('.manage-form-field-otp').eq(5);

						e_num_1.val('');
						e_num_2.val('');
						e_num_3.val('');
						e_num_4.val('');
						e_num_5.val('');
						e_num_6.val('');

						e_num_1.focus();
						e_num_1.keyup(function(){
							e_num_2.focus();
						});
						e_num_2.keyup(function(){
							e_num_3.focus();
						});
						e_num_3.keyup(function(){
							e_num_4.focus();
						});
						e_num_4.keyup(function(){
							e_num_5.focus();
						});
						e_num_5.keyup(function(){
							e_num_6.focus();
						});
						e_num_6.keyup(function(){							
							var arr_number_otp = $('input[name="maotp[]"]').map(function(){return $(this).val();}).get();
							arr_number_otp = arr_number_otp.join('');
							$('input[name="otp"]').val(arr_number_otp);
							if(arr_number_otp.length==6){
								$('.manage-close-otp').trigger('click');
								$('#manage-form')[0].submit();
							}else{
								$('#show-alert-otp').removeClass('d-none').addClass('d-block');
							}
							//console.log(arr_number_otp.length);
						});
					}
					$('#loading_order').hide();
				}
			});
		});


		/*$('#manage-form').submit(function(e){
			if(!$('#email-loading-gif').hasClass('email-loading-active')){
				e.preventDefault();
				$('#email-loading-gif').addClass('email-loading-active');
			}

			//### Kiểm tra  ngân hàng, số tài khoản hoặc số momo ==> gửi otp tới số điện thoại đã đăng ký
			var somomo = $('#somomo').val();
			var nganhang = $('input[name="nganhang"]:checked').val();
			var sotaikhoan = $('#sotaikhoan').val();

			$.ajax({
				url: '{{route('ajax.checkOTP')}}',
				type: "POST",
				dataType: 'json',
				async: true,
				data: {somomo:somomo, nganhang:nganhang, sotaikhoan:sotaikhoan, _token:$('meta[name="csrf-token"]').attr('content')},
				success: function(result_data){
					if(result_data.result==true){
						console.log(result_data);
						//$('#manage-form')[0].submit();
					}else{						
						$('input[name="otp"]').val(result_data.otp);
						$('.manage-form-otp').addClass('manage-form-otp-active');
					}
					e.preventDefault();
				}
			});
		});*/


		$('.manage-close-otp').click(function(){
			$('input[name="otp"]').val('');
			$('.manage-form-otp').removeClass('manage-form-otp-active');
		});


		$('.manage-bank-radio').click(function(){
			$('.manage-form-nganhang-item').removeClass('manage-form-nganhang-item-active');
			$(this).parents('.manage-form-nganhang-item').addClass('manage-form-nganhang-item-active');
		});

		$('.manage-bank-radio').each(function(){
			if($(this).is(':checked')) {
			 	$(this).parents('.manage-form-nganhang-item').addClass('manage-form-nganhang-item-active');
			}
			
		});


		$('#nganhang').click(function(){
			$('.manage-form-nganhang-contain').slideToggle();
		});


		$('#ngaysinh').datepicker({
			changeYear: true,
			changeMonth: true,
			yearRange: '1900:c',
			maxDate: '+10Y',
			dateFormat: 'dd/mm/yy'	
		});

		var cleave = new Cleave('#phonenumber', {
		    phone: true,
		    phoneRegionCode: 'vn'
		});		

		var cleave = new Cleave('#somomo', {
		    phone: true,
		    phoneRegionCode: 'vn'
		});	
	</script>
@endpush


@push('strucdata')


@endpush