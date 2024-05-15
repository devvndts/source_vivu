@extends('desktop.master')

@section('element_detail','page-login')

@section('content')
	<div class="login-layout mb-5">
		<form id="login-form" action="{{ route('account.resetAccount') }}" method="POST">
			@csrf
			<div class="login-form-title login-formreset-title">Quên mật khẩu ?</div>
			<div class="login-form-inform">Nhập Email đăng ký để lấy lại Mật khẩu</div>
			<div class="login-form-box">
				<p>
					<input id="email" type="email" name="email" placeholder="Email" required>
					<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 28 28"><path d="M12 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zm8.127 19.41c-.282-.401-.772-.654-1.624-.85-3.848-.906-4.097-1.501-4.352-2.059-.259-.565-.19-1.23.205-1.977 1.726-3.257 2.09-6.024 1.027-7.79-.674-1.119-1.875-1.734-3.383-1.734-1.521 0-2.732.626-3.409 1.763-1.066 1.789-.693 4.544 1.049 7.757.402.742.476 1.406.22 1.974-.265.586-.611 1.19-4.365 2.066-.852.196-1.342.449-1.623.848 2.012 2.207 4.91 3.592 8.128 3.592s6.115-1.385 8.127-3.59zm.65-.782c1.395-1.844 2.223-4.14 2.223-6.628 0-6.071-4.929-11-11-11s-11 4.929-11 11c0 2.487.827 4.783 2.222 6.626.409-.452 1.049-.81 2.049-1.041 2.025-.462 3.376-.836 3.678-1.502.122-.272.061-.628-.188-1.087-1.917-3.535-2.282-6.641-1.03-8.745.853-1.431 2.408-2.251 4.269-2.251 1.845 0 3.391.808 4.24 2.218 1.251 2.079.896 5.195-1 8.774-.245.463-.304.821-.179 1.094.305.668 1.644 1.038 3.667 1.499 1 .23 1.64.59 2.049 1.043z"/></svg>
				</p>
			</div>			
			<div class="login-form-flex">
				<a class="login-form-reset" href="">
				<svg class="mr-2" clip-rule="evenodd" width="20" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z" fill-rule="nonzero"/></svg> Quay về trang chủ</a>
				<button type="submit" class="login-form-submit">Lấy lại mật khẩu</button>
			</div>
		</form>
	</div>
@endsection

<!--js thêm cho mỗi trang-->

@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/login.css') }} ">
@endpush

@push('js_page')
	
@endpush


@push('strucdata')


@endpush