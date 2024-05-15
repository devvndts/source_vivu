@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-coin-form" class="manage-form-contain hidden-info-user">
			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">
				<div class="manage-form-tabs-list mb-3">
					<a class="manage-form-tabs-btn mr-2 manage-form-tabs-btn-active" data-id="#showtab-manage-nhanxu">Nhận xu</a>
					<a class="manage-form-tabs-btn" data-id="#showtab-manage-traxu">Trả xu</a>
				</div>

				<div class="manage-form-tabs">
					<div id="showtab-manage-nhanxu" class="manage-form-tab-item manage-form-tab-active">
						@if($coin_receip)
							<div class="manage-history-box">
								@foreach($coin_receip as $k=>$v)
									@php
										$user_nhan = $v['user_nhan'];
										$user_tra = $v['user_tra'];
										$post = $v['has_post'];
									@endphp
									<div class="manage-history-item">
										<div class="manage-history-title"><p class="manage-history-title-name"><i class="fas fa-coins mr-2"></i> Nhận xu</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
										<div class="manage-history-info">
											<div class="manage-history-flex"><p class="manage-history-status">+ {{$v['soxu']}} xu</p> <span class="mx-2">từ tài khoản</span><p class="manage-history-user">{{($v['typepage']=='nhantinthang') ? '@admin' : '@'.$user_tra['name']}}</p></div>
											@if(($v['typepage']=='nhantinthang'))
												<div class="manage-history-post">Với vai trò <a>cộng tác viên</a></div>
											@else											
												<div class="manage-history-post">Tin đăng <a href="{{$post['tenkhongdauvi']}}-{{$post['id']}}" target="_blank">'{{$post['tenvi']}}'</a></div>
											@endif
										</div>
									</div>
									
								@endforeach
							</div>
						@else
							<div class="manage-history-alert"><i class="fal fa-info-circle mr-2"></i>Không có dữ liệu</div>
						@endif
					</div>
					<div id="showtab-manage-traxu" class="manage-form-tab-item">
						@if($coin_pay)
							<div class="manage-history-box">
								@foreach($coin_pay as $k=>$v)									
									@php
										$user_nhan = $v['user_nhan'];
										$user_tra = $v['user_tra'];
										$post = $v['has_post'];
									@endphp
									
									<div class="manage-history-item">
										<div class="manage-history-title"><p class="manage-history-title-name"><i class="far fa-history mr-2"></i> Trả xu</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
										<div class="manage-history-info">
											<div class="manage-history-flex">Chuyển  <p class="manage-history-status ml-2">{{$v['soxu']}} xu</p> <span class="mx-2">tới tài khoản</span><p class="manage-history-user">{{($user_nhan) ? '@'.$user_nhan['name'] : 'admin' }}</p></div>
											@if($v['typepage']=='goitinthang')
												<div class="manage-history-post">Đăng ký gói tin xem theo tháng !</div>
											@else
												<div class="manage-history-post">Xem tin đăng <a href="{{$post['tenkhongdauvi']}}-{{$post['id']}}" target="_blank">'{{$post['tenvi']}}'</a></div>
											@endif											
										</div>
									</div>
									
									
								@endforeach
							</div>
						@else
							<div class="manage-history-alert"><i class="fal fa-info-circle mr-2"></i>Không có dữ liệu</div>
						@endif
					</div>
				</div>
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
		$('.manage-form-tabs-btn').click(function(){
			var e_id = $(this).attr('data-id');
			
			$('.manage-form-tab-item').removeClass('manage-form-tab-active');
			$(e_id).addClass('manage-form-tab-active');

			$('.manage-form-tabs-btn').removeClass('manage-form-tabs-btn-active');
			$(this).addClass('manage-form-tabs-btn-active');
		});
	</script>
@endpush


@push('strucdata')


@endpush