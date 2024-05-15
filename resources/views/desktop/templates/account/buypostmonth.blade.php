@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-coin-form" class="manage-form-contain hidden-info-user" method="POST" enctype="multipart/form-data" action="{{ route('account.buyPostMonth') }}">
			@csrf

			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">
				@if($user['tongxu']>=$settingOption['goitheothang'])
					@if($user['vip']==1 && time()<$user['timeup'])
						<div class="manage-byumonth-alert">
							<i class="fal fa-info-circle mr-2"></i>Gói tin theo tháng của bạn đang còn hiệu lực sử dụng. Thời gian hết hạn là <strong>{{date('H:i:s d/m/Y', $user['timeup'])}}</strong>
						</div>
					@else
						<div class="manage-byumonth-alert">
							<i class="fal fa-info-circle mr-2"></i>Cần <strong style="color:red">{{$settingOption['goitheothang']}} xu</strong> để kích hoạt gói xem tin theo tháng. Vui lòng chọn xác nhận bên dưới để hoàn thành quá trình đăng ký.
						</div>
						<button type="submit" class="manage-form-submit">Xác nhận mua gói tin</button>
					@endif					
				@else
					<div class="manage-byumonth-alert">
						<i class="fal fa-info-circle mr-2"></i>Cần <strong style="color:red">{{$settingOption['goitheothang']}} xu</strong> để kích hoạt gói xem tin theo tháng. Hệ thống phát hiện tài khoản của bạn không đủ số xu để đăng ký gói tin ! Vui lòng nạp thêm xu và đăng ký lại
					</div>
				@endif
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
		
	</script>
@endpush


@push('strucdata')


@endpush