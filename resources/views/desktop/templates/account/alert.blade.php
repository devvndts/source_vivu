@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-form" class="manage-form-contain hidden-info-user">
			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">

				<div class="sidebar-tab-manage scroll-css">
					@php
						$thongbao = app('thongbao');
					@endphp

					@if($thongbao)
						@foreach($thongbao as $k=>$v)
							@php
								$info= json_decode($v['info'], true);
							@endphp
							<div class="sidebar-tab-inform-item sidebar-tab-inform-item-{{$v['id']}} {{($v['daxem']==1) ? 'sidebar-tab-inform-item-hasview': ''}}">
								<div class="sidebar-tab-inform-topitem">
									<p class="sidebar-tab-inform-toptitle"><span class="mr-2"></span>Thông báo</p>
									<p class="sidebar-tab-inform-topdate">{{Helper::GetCurrentWeekday($v['ngaytao'])}} <span class="sidebar-tab-tools" data-id="{{$v['id']}}" data-daxem="{{$v['daxem']}}" data-reserve="{{($v['daxem']!=1)? 'daxem' : 'chuaxem'}}"><i class="fas fa-ellipsis-h"></i></span></p>
								</div>
								<div class="sidebar-tab-inform-botitem">
									<p class="sidebar-tab-inform-bottitle">{{$v['tieude']}}</p>
									<div class="sidebar-tab-inform-botcontent">{{$v['noidung']}}</div>
									@if(isset($info['type']) && $info['type']=='comment')	
										@php
											$post = Helper::GetPostById($info['id_post']);
										@endphp							
										<a href="{{$post['tenkhongdau'.$lang]}}-{{$post['id']}}?comment={{$info['id_comment']}}" target="_blank" class="sidebar-tab-inform-view"><i class="fal fa-hand-point-right mr-1"></i>Xem chi tiết</a>
									@endif
									@if(isset($info['type']) && $info['type']=='vipham')<p class="sidebar-tab-inform-comment">Nội dung bình luận: '{{$info['comment_info']}}'</p>@endif
								</div>
							</div>
						@endforeach
					@endif
				</div>
				<div class="sidebar-tab-showtool">
					<span class="sidebar-tab-showtool-layout"></span>
					<div class="sidebar-tab-showtool-list">
						<p class="sidebar-btn-status sidebar-btn-status-isview" data-status="" data-id=""><i class="fas fa-check mr-2"></i> <span id="sidebar-tab-hasno"></span></p>
						<p class="sidebar-btn-status sidebar-btn-status-remove" data-status="xoa" data-id=""><i class="fas fa-trash mr-2"></i> Xóa thông báo</p>
						<p class="sidebar-btn-cancel"><i class="fas fa-times mr-2"></i> Hủy</p>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection

@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/manage.css') }} ">
@endpush

<!--js thêm cho mỗi trang-->

@push('js_page')	

@endpush


@push('strucdata')


@endpush