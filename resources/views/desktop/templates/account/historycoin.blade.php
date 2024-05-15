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
				@php
					$tinhtrang = config('config_type.newsletter.naprutxu.tinhtrang');
				@endphp

				<div class="manage-form-tabs-list mb-3">
					<a class="manage-form-tabs-btn mr-2 manage-form-tabs-btn-active" data-id="#showtab-manage-nhanxu">Lịch sử nạp xu</a>
					<a class="manage-form-tabs-btn" data-id="#showtab-manage-traxu">Lịch sử rút xu</a>
				</div>

				<div class="manage-form-tabs">
					<div id="showtab-manage-nhanxu" class="manage-form-tab-item manage-form-tab-active">
						@if($nap_wait)
						<p class="manage-form-tab-status text-warning">Chờ xử lý</p>
						<div class="manage-history-box">
							@foreach($nap_wait as $k=>$v)
								<div class="manage-history-item">
									<div class="manage-history-title"><p class="manage-history-title-name">Mã xử lý: {{$v['maxuly']}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
									<div class="manage-history-info">
										<div class="manage-history-coin-flex">
											<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
											<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
										</div>
										<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>									
									</div>
								</div>
							@endforeach
						</div>
						@endif

						@if($nap_sucess)
						<p class="manage-form-tab-status text-success">Đã xử lý</p>
						<div class="manage-history-box">
							@foreach($nap_sucess as $k=>$v)
								<div class="manage-history-item">
									<div class="manage-history-title"><p class="manage-history-title-name">Mã xử lý: {{$v['maxuly']}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
									<div class="manage-history-info">
										<div class="manage-history-coin-flex">
											<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
											<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
										</div>
										<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>
										{{-- <p class="manage-history-status manage-history-status-{{$v['tinhtrang']}}">{{$tinhtrang[$v['tinhtrang']]}}</p> --}}
									</div>
								</div>
							@endforeach
						</div>
						@endif

						@if($nap_cancel)
						<p class="manage-form-tab-status text-danger">Bị từ chối</p>
						<div class="manage-history-box">
							@foreach($nap_cancel as $k=>$v)
								<div class="manage-history-item">
									<div class="manage-history-title"><p class="manage-history-title-name">Mã xử lý: {{$v['maxuly']}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
									<div class="manage-history-info">
										<div class="manage-history-coin-flex">
											<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
											<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
										</div>
										<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>
										@if($v['lydo']!='')<p class="manage-history-status manage-history-status-danger">Lý do: {{$v['lydo']}}</p>@endif
										{{-- <p class="manage-history-status manage-history-status-{{$v['tinhtrang']}}">{{$tinhtrang[$v['tinhtrang']]}}</p> --}}
									</div>
								</div>
							@endforeach
						</div>
						@endif
					</div>
					<div id="showtab-manage-traxu" class="manage-form-tab-item">
						@if($rut_wait)
						<p class="manage-form-tab-status text-warning">Chờ xử lý</p>
						<div class="manage-history-box">
							@foreach($rut_wait as $k=>$v)
								<div class="manage-history-item">
									<div class="manage-history-title"><p class="manage-history-title-name">Mã xử lý: {{$v['maxuly']}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
									<div class="manage-history-info">
										<div class="manage-history-coin-flex">
											<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
											<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
										</div>
										<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>									
									</div>
								</div>
							@endforeach
						</div>
						@endif

						@if($rut_sucess)
						<p class="manage-form-tab-status text-success">Đã xử lý</p>
						<div class="manage-history-box">
							@foreach($rut_sucess as $k=>$v)
								<div class="manage-history-item">
									<div class="manage-history-title"><p class="manage-history-title-name">Mã xử lý: {{$v['maxuly']}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
									<div class="manage-history-info">
										<div class="manage-history-coin-flex">
											<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
											<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
										</div>
										<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>
										{{-- <p class="manage-history-status manage-history-status-{{$v['tinhtrang']}}">{{$tinhtrang[$v['tinhtrang']]}}</p> --}}
									</div>
								</div>
							@endforeach
						</div>
						@endif

						@if($rut_cancel)
						<p class="manage-form-tab-status text-danger">Bị từ chối</p>
						<div class="manage-history-box">
							@foreach($rut_cancel as $k=>$v)
								<div class="manage-history-item">
									<div class="manage-history-title"><p class="manage-history-title-name">Mã xử lý: {{$v['maxuly']}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
									<div class="manage-history-info">
										<div class="manage-history-coin-flex">
											<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
											<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
										</div>
										<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>
										@if($v['lydo']!='')<p class="manage-history-status manage-history-status-danger">Lý do: {{$v['lydo']}}</p>@endif
										{{-- <p class="manage-history-status manage-history-status-{{$v['tinhtrang']}}">{{$tinhtrang[$v['tinhtrang']]}}</p> --}}
									</div>
								</div>
							@endforeach
						</div>
						@endif
					</div>
				</div>

				{{-- <div class="manage-history-box">
				@foreach($history as $k=>$v)
					<div class="manage-history-item">
						<div class="manage-history-title"><p class="manage-history-title-name">{{($v['hinhthuc']==0) ? 'Nạp xu' : 'Rút xu'}}</p><p class="manage-history-title-date">{{date('H:i d/m/Y', $v['ngaytao'])}}</p></div>
						<div class="manage-history-info">
							<div class="manage-history-coin-flex">
								<p>Số xu: <strong>{{$v['giatrixunap']}}</strong></p>
								<p class="ml-2" style="color:#999;font-size: 12px;">(Giá quy đổi: {{Helper::Format_Money($v['giatrinap'], ' đ')}})</p>
							</div>
							<p>Thanh toán: {{($v['hinhthuc']==0) ? 'Qua momo' : 'Qua tài khoản ngân hàng'}}</p>
							<p class="manage-history-status manage-history-status-{{$v['tinhtrang']}}">{{$tinhtrang[$v['tinhtrang']]}}</p>
						</div>
					</div>
				@endforeach
				</div> --}}
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