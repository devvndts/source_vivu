@extends('desktop.master')

@section('element_detail','page-login')

@section('content')
	<div class="container my-6">
		@php		
			$validates = ($errors->any()) ? $errors->toArray() : null;
		@endphp
		<div class="mb-5 login-layout">
			<form id="login-form" action="{{ route('account.signin') }}" method="POST" class="change-css-date">
				@csrf
				<div class="login-form-title">Đăng ký</div>

				<div class="login-form-ghichu">
					<i class="mr-2 fal fa-comment-alt-exclamation"></i>Hoàn thành tất cả các thông tin yêu cầu bên dưới để đăng ký tài khoản
				</div>

				<div class="login-form-box">
					<label for="name">Họ và tên</label>
					<p>
						<input id="name" type="text" name="name" placeholder="" value="{{ old('name') }}">
						<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 28 28"><path d="M24 22h-24v-20h24v20zm-1-19h-22v18h22v-18zm-4 13v1h-4v-1h4zm-6.002 1h-10.997l-.001-.914c-.004-1.05-.007-2.136 1.711-2.533.789-.182 1.753-.404 1.892-.709.048-.108-.04-.301-.098-.407-1.103-2.036-1.305-3.838-.567-5.078.514-.863 1.448-1.359 2.562-1.359 1.105 0 2.033.488 2.545 1.339.737 1.224.542 3.033-.548 5.095-.057.106-.144.301-.095.41.14.305 1.118.531 1.83.696 1.779.41 1.773 1.503 1.767 2.56l-.001.9zm-9.998-1h8.999c.003-1.014-.055-1.27-.936-1.473-1.171-.27-2.226-.514-2.57-1.267-.174-.381-.134-.816.119-1.294.921-1.739 1.125-3.199.576-4.111-.332-.551-.931-.855-1.688-.855-.764 0-1.369.31-1.703.871-.542.91-.328 2.401.587 4.09.259.476.303.912.13 1.295-.342.757-1.387.997-2.493 1.252-.966.222-1.022.478-1.021 1.492zm18-3v1h-6v-1h6zm0-3v1h-6v-1h6zm0-3v1h-6v-1h6z"/></svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['name'])) ? $validates['name'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<label for="ngaysinh">Ngày sinh</label>
					<p>
						<input id="ngaysinh" type="text" name="ngaysinh" placeholder="" value="{{ old('ngaysinh') }}">
						<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 28 28"><path d="M24 23h-24v-19h4v-3h4v3h8v-3h4v3h4v19zm-1-15h-22v14h22v-14zm-16.501 8.794l1.032-.128c.201.93.693 1.538 1.644 1.538.957 0 1.731-.686 1.731-1.634 0-.989-.849-1.789-2.373-1.415l.115-.843c.91.09 1.88-.348 1.88-1.298 0-.674-.528-1.224-1.376-1.224-.791 0-1.364.459-1.518 1.41l-1.032-.171c.258-1.319 1.227-2.029 2.527-2.029 1.411 0 2.459.893 2.459 2.035 0 .646-.363 1.245-1.158 1.586.993.213 1.57.914 1.57 1.928 0 1.46-1.294 2.451-2.831 2.451-1.531 0-2.537-.945-2.67-2.206zm9.501 2.206h-1.031v-6.265c-.519.461-1.354.947-1.969 1.159v-.929c1.316-.576 2.036-1.402 2.336-1.965h.664v8zm7-14h-22v2h22v-2zm-16-3h-2v2h2v-2zm12 0h-2v2h2v-2z"/></svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['ngaysinh'])) ? $validates['ngaysinh'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<label for="phonenumber">Số điện thoại</label>
					<p>
						<input id="phonenumber" type="text" name="phonenumber" placeholder="" value="{{ old('phonenumber') }}">
						<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 28 28"><path d="M18 24h-12c-1.104 0-2-.896-2-2v-20c0-1.104.896-2 2-2h12c1.104 0 2 .896 2 2v20c0 1.104-.896 2-2 2zm1-5.083h-14v3.083c0 .552.449 1 1 1h12c.552 0 1-.448 1-1v-3.083zm-7 3c-.553 0-1-.448-1-1s.447-1 1-1c.552 0 .999.448.999 1s-.447 1-.999 1zm7-17h-14v13h14v-13zm-1-3.917h-12c-.551 0-1 .449-1 1v1.917h14v-1.917c0-.551-.448-1-1-1zm-4.5 1.917h-3c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h3c.276 0 .5.224.5.5s-.224.5-.5.5z"/></svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['phonenumber'])) ? $validates['phonenumber'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<label for="username">Tên tài khoản</label>
					<p>
						<input id="username" type="text" name="username" placeholder="" value="{{ old('username') }}">
						<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 28 28"><path d="M12 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zm8.127 19.41c-.282-.401-.772-.654-1.624-.85-3.848-.906-4.097-1.501-4.352-2.059-.259-.565-.19-1.23.205-1.977 1.726-3.257 2.09-6.024 1.027-7.79-.674-1.119-1.875-1.734-3.383-1.734-1.521 0-2.732.626-3.409 1.763-1.066 1.789-.693 4.544 1.049 7.757.402.742.476 1.406.22 1.974-.265.586-.611 1.19-4.365 2.066-.852.196-1.342.449-1.623.848 2.012 2.207 4.91 3.592 8.128 3.592s6.115-1.385 8.127-3.59zm.65-.782c1.395-1.844 2.223-4.14 2.223-6.628 0-6.071-4.929-11-11-11s-11 4.929-11 11c0 2.487.827 4.783 2.222 6.626.409-.452 1.049-.81 2.049-1.041 2.025-.462 3.376-.836 3.678-1.502.122-.272.061-.628-.188-1.087-1.917-3.535-2.282-6.641-1.03-8.745.853-1.431 2.408-2.251 4.269-2.251 1.845 0 3.391.808 4.24 2.218 1.251 2.079.896 5.195-1 8.774-.245.463-.304.821-.179 1.094.305.668 1.644 1.038 3.667 1.499 1 .23 1.64.59 2.049 1.043z"/></svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['username'])) ? $validates['username'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<label for="password">Mật khẩu</label>
					<p>
						<input id="password" type="password" name="password" placeholder="" >
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 640 512">
							<path d="M637 485.25L23 1.75A8 8 0 0 0 11.76 3l-10 12.51A8 8 0 0 0 3 26.75l614 483.5a8 8 0 0 0 11.25-1.25l10-12.51a8 8 0 0 0-1.25-11.24zM320 96a128.14 128.14 0 0 1 128 128c0 21.62-5.9 41.69-15.4 59.57l25.45 20C471.65 280.09 480 253.14 480 224c0-36.83-12.91-70.31-33.78-97.33A294.88 294.88 0 0 1 576.05 256a299.73 299.73 0 0 1-67.77 87.16l25.32 19.94c28.47-26.28 52.87-57.26 70.93-92.51a32.35 32.35 0 0 0 0-29.19C550.3 135.59 442.94 64 320 64a311.23 311.23 0 0 0-130.12 28.43l45.77 36C258.24 108.52 287.56 96 320 96zm60.86 146.83A63.15 63.15 0 0 0 320 160c-1 0-1.89.24-2.85.29a45.11 45.11 0 0 1-.24 32.19zm-217.62-49.16A154.29 154.29 0 0 0 160 224a159.39 159.39 0 0 0 226.27 145.29L356.69 346c-11.7 3.53-23.85 6-36.68 6A128.15 128.15 0 0 1 192 224c0-2.44.59-4.72.72-7.12zM320 416c-107.36 0-205.47-61.31-256-160 17.43-34 41.09-62.72 68.31-86.72l-25.86-20.37c-28.48 26.28-52.87 57.25-70.93 92.5a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448a311.25 311.25 0 0 0 130.12-28.43l-29.25-23C389.06 408.84 355.15 416 320 416z"></path>
						</svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['password'])) ? $validates['password'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<label for="repassword">Nhập lại mật khẩu</label>
					<p>
						<input id="repassword" type="password" name="repassword" placeholder="" >
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 640 512">
							<path d="M637 485.25L23 1.75A8 8 0 0 0 11.76 3l-10 12.51A8 8 0 0 0 3 26.75l614 483.5a8 8 0 0 0 11.25-1.25l10-12.51a8 8 0 0 0-1.25-11.24zM320 96a128.14 128.14 0 0 1 128 128c0 21.62-5.9 41.69-15.4 59.57l25.45 20C471.65 280.09 480 253.14 480 224c0-36.83-12.91-70.31-33.78-97.33A294.88 294.88 0 0 1 576.05 256a299.73 299.73 0 0 1-67.77 87.16l25.32 19.94c28.47-26.28 52.87-57.26 70.93-92.51a32.35 32.35 0 0 0 0-29.19C550.3 135.59 442.94 64 320 64a311.23 311.23 0 0 0-130.12 28.43l45.77 36C258.24 108.52 287.56 96 320 96zm60.86 146.83A63.15 63.15 0 0 0 320 160c-1 0-1.89.24-2.85.29a45.11 45.11 0 0 1-.24 32.19zm-217.62-49.16A154.29 154.29 0 0 0 160 224a159.39 159.39 0 0 0 226.27 145.29L356.69 346c-11.7 3.53-23.85 6-36.68 6A128.15 128.15 0 0 1 192 224c0-2.44.59-4.72.72-7.12zM320 416c-107.36 0-205.47-61.31-256-160 17.43-34 41.09-62.72 68.31-86.72l-25.86-20.37c-28.48 26.28-52.87 57.25-70.93 92.5a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448a311.25 311.25 0 0 0 130.12-28.43l-29.25-23C389.06 408.84 355.15 416 320 416z"></path>
						</svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['repassword'])) ? $validates['repassword'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<label for="email">Email</label>
					<p>
						<input id="email" type="email" name="email" placeholder="" value="{{ old('email') }}">
						<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 28 28"><path d="M24 21h-24v-18h24v18zm-23-16.477v15.477h22v-15.477l-10.999 10-11.001-10zm21.089-.523h-20.176l10.088 9.171 10.088-9.171z"/></svg>
					</p>
					<span class="login-form-alert">{{(isset($validates['email'])) ? $validates['email'][0] : ''}}</span>
				</div>
				<div class="login-form-box">
					<div style="display: flex; align-items: center;">
						<input id="dieukhoan" type="checkbox" name="dieukhoan" placeholder="" value="1" class="mr-1">
						<label for="dieukhoan" style="text-transform: none;font-weight: 100; font-size: 14px;margin: 0;">Tôi đồng ý với điều khoản dịch vụ và chính sách quyền riêng tư!</label>
					</div>
					<span class="login-form-alert">{{(isset($validates['dieukhoan'])) ? $validates['dieukhoan'][0] : ''}}</span>
				</div>
				<div class="login-form-flex">
					<div class="login-form-flexreset">
						<p class="login-form-signin-btn"><a href="{{route('account.login')}}">Đăng nhập</a> nếu đã có tài khoản !</p>
					</div>
					<button type="submit" class="login-form-submit">Đăng ký</button>
				</div>
			</form>
		</div>
	</div>
	
@endsection


@push('css_page')
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ asset('plugins/jquery-ui-1-13/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('css/login.css') }} ">
	<style>
		.ui-datepicker .ui-datepicker-title select{color: #000;}
	</style>
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
	<script src="{{ asset('plugins/jquery-ui-1-13/jquery-ui.min.js') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

	<script>
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
	</script>
@endpush


@push('strucdata')


@endpush