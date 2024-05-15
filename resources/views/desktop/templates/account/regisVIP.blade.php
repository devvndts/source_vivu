@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
	@endphp

	<div class="login-layout mb-5">
		<form id="manage-coin-form" action="{{ route('account.regisVIP') }}" method="POST" enctype="multipart/form-data" class="manage-form-contain hidden-info-user">
			@csrf

			<div class="manage-form-left">
				@include('desktop.templates.account.sidebarinfo')
			</div>
			<div class="manage-form-right">
				<div class="regisvip-slogan">
					@if(isset($has_dangky) && $has_dangky==0)
						<strong>Quyền lợi:</strong> Khi người dùng đăng ký gói tin tháng, <span style="color:red">{{$settingOption['phantramhoahongVIP']}}%</span> số xu của tổng người dùng đăng ký sẽ được chuyển cho cộng tác viên đăng bài, với điều kiện cộng tác viên hoàn thành số bài đăng tối thiểu <span style="color:red">{{$settingOption['sobaidangtoithieu']}}</span> bài/tháng
					@elseif($user['congtacvien']==1)
						<i class="fal fa-info-circle mr-1"></i> Hệ thống xác nhận bạn đã trở thành <strong>Cộng tác viên</strong>. Liên hệ admin qua zalo số {{$settingOption['zalo']}} để nhận link quản lý bài của Cộng tác viên</span>
					@else
						<strong>Thông báo:</strong> Hệ thống đã nhận được yêu cầu đăng ký cộng tác viên từ tài khoản của bạn, chờ quản trị viên xác nhận và sẽ liên hệ với bạn trong thời gian sớm nhất.</span>
					@endif
				</div>

				<p class="regisvip-choose"><i class="fal fa-hand-point-down mr-1"></i>
					@if(isset($has_dangky) && $has_dangky==0)
						Bạn vui lòng chọn khu vực tin dự kiến mình quản lý
					@else
						Thay đổi khu vực tin dự kiến quản lý bên dưới
					@endif
				</p>

				@if($max_category)
					<div class="regisvip-category">
					@for($i=0;$i<=$max_category;$i++)
						<div class="regisvip-category-item" data-level="{{$i}}">Khu vực tin cấp {{$i+1}} <i class="ml-2 fas fa-caret-down"></i></div>
						<input type="hidden" name="level_{{$i}}" value="{{($dk_newsletter) ? $dk_newsletter['ids_level_'.($i+1)] : ''}}">
					@endfor
					</div>
				@endif

				<button type="submit" class="manage-form-submit">Xác nhận nội dung và gửi admin</button>
				<input type="hidden" name="max_level" value="{{$max_category}}">
			</div>
		</form>
	</div>

	<div id="form-regisvip" class="form-regisvip-close">
		<div class="form-regisvip-main">
			<span class="form-regisvip-btn-close"><i class="fal fa-times"></i></span>
			<p class="form-regisvip-title">Có thể chọn 1 hoặc nhiều</p>
			<div id="form-regisvip-show-category" class="form-regisvip-show-category"></div>
		</div>
	</div>
@endsection

@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/manage.css') }} ">
	<link rel="stylesheet" href="{{ asset('css/regisvip.css') }} ">
@endpush

<!--js thêm cho mỗi trang-->

@push('js_page')	
	<script>
		$('.regisvip-category-item').click(function(){
			$('#form-regisvip').addClass('form-regisvip-open');
			$('#form-regisvip-show-category').empty();

			var level = $(this).attr('data-level');
			var ids_level = $('input[name="level_'+level+'"]').val();
			var ids_parent = '';
			if(level>0){
				ids_parent = $('input[name="level_'+(level-1)+'"]').val();
			}

			$.ajax({
                url: '{{route('ajax.getCategory')}}',
                type: "POST",
                dataType: 'html',
                async: true,
                data: {level:level, ids_level:ids_level, ids_parent:ids_parent, _token:$('meta[name="csrf-token"]').attr('content')},
                success: function(result){
                    $('#form-regisvip-show-category').html(result);
                }
            });
			
		});


		$('.form-regisvip-btn-close').click(function(){
			$('#form-regisvip').removeClass('form-regisvip-open');
		});


		$('body').on('click', '.account-category-submit', function() {
			var selected = [];
			var level = $('input[name="ajax_level"]').val();
			var ids_level = $('input[name="level_'+level+'"]').val();
			var max_level = $('input[name="max_level"]').val();
			//var ids_parent = '';

			$('.form-regisvip-show-category input:checked').each(function() {
			    selected.push($(this).val());
			});

			selected = selected.join(',');

			for(var i=(parseInt(level)+1);i<=max_level;i++){
				$('input[name="level_'+i+'"]').val('');
				console.log('level_'+i);
			}

			if(level<max_level){				
				$.ajax({
	                url: '{{route('ajax.getCategory')}}',
	                type: "POST",
	                dataType: 'html',
	                async: true,
	                data: {level:(parseInt(level)+1), ids_level:ids_level, ids_parent:selected, _token:$('meta[name="csrf-token"]').attr('content')},
	                success: function(result){
	                    $('#form-regisvip-show-category').html(result);
	                    //### response
						$('input[name="level_'+level+'"]').val(selected);
	                }
	            });
			}else{
				$('input[name="level_'+level+'"]').val(selected);
				$('.form-regisvip-btn-close').trigger('click');
			}

		});
	</script>
@endpush


@push('strucdata')

@endpush