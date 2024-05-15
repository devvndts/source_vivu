@extends('desktop.master')

@section('element_detail','page-login')

@section('content')
	<div class="container my-6">
		<div class="mb-5 login-layout">
			<div class="login-inform-main {{($bg=='bgWarning') ? 'bgWarning' : ''}} {{($bg=='bgError') ? 'bgError' : ''}} {{($bg=='bgSuccess') ? 'bgSuccess' : ''}}">
				<div class="d-none login-icon-inform {{($icon=='successLogin' || $icon=='successEditpass') ? 'successLogin' : ''}}">
					<svg width="60" height="60" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zm0 1c6.071 0 11 4.929 11 11s-4.929 11-11 11-11-4.929-11-11 4.929-11 11-11zm7 7.457l-9.005 9.565-4.995-5.865.761-.649 4.271 5.016 8.24-8.752.728.685z"/></svg>
				</div>
				<div class="d-none login-icon-inform {{($icon=='errorLogin' || $icon=='errorReset') ? 'errorLogin' : ''}}">
					<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" width="60" height="60" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.002 21.534c5.518 0 9.998-4.48 9.998-9.998s-4.48-9.997-9.998-9.997c-5.517 0-9.997 4.479-9.997 9.997s4.48 9.998 9.997 9.998zm0-1.5c-4.69 0-8.497-3.808-8.497-8.498s3.807-8.497 8.497-8.497 8.498 3.807 8.498 8.497-3.808 8.498-8.498 8.498zm0-6.5c-.414 0-.75-.336-.75-.75v-5.5c0-.414.336-.75.75-.75s.75.336.75.75v5.5c0 .414-.336.75-.75.75zm-.002 3c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z" fill-rule="nonzero"/></svg>
				</div>
				<div class="d-none login-icon-inform {{($icon=='hasLogin') ? 'hasLogin' : ''}}">
					<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" width="60" height="60" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m2.095 19.886 9.248-16.5c.133-.237.384-.384.657-.384.272 0 .524.147.656.384l9.248 16.5c.064.115.096.241.096.367 0 .385-.309.749-.752.749h-18.496c-.44 0-.752-.36-.752-.749 0-.126.031-.252.095-.367zm1.935-.384h15.939l-7.97-14.219zm7.972-6.497c-.414 0-.75.336-.75.75v3.5c0 .414.336.75.75.75s.75-.336.75-.75v-3.5c0-.414-.336-.75-.75-.75zm-.002-3c.552 0 1 .448 1 1s-.448 1-1 1-1-.448-1-1 .448-1 1-1z" fill-rule="nonzero"/></svg>
				</div>
				<div class="login-cotent-inform {{$class}}">
					<p class="login-content-title">{{$text}}</p>
					<p class="login-content-des">{{$description}}</p>
					@if(isset($data['kieuxem']))
						<div class="login-content-info">
							<p>Thời gian gia hạn: <strong>24h</strong></p>
							<p>Số xu phải trả: <strong>{{$data['soxuphaitra']}} xu</strong></p>
						</div>
					@endif
					<div class="login-content-btns">
						<a class="login-content-back" href=""><svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z" fill-rule="nonzero"/></svg> Quay lại trang chủ</a>
						@if(isset($data['kieuxem']))
						<a class="btn-extendTime-post" data-id="{{$data['id']}}">Gia hạn</a>
						@endif
						@if(isset($isform) && $isform=='overVIP')
						<a href="{{ route('account.buyPostMonth') }}" class="btn-extendTime-post">Gia hạn</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

<!--js thêm cho mỗi trang-->

@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/login.css') }} ">
@endpush

@push('js_page')
	<script>
		$('.btn-extendTime-post').click(function(){
			var id = $(this).attr('data-id');			

			$.ajax({
				url: '{{ route('account.extendTime') }}',
				type: "POST",
				dataType: 'json',
				async: true,
				data: {id:id, _token:$('meta[name="csrf-token"]').attr('content')},
				success: function(result){	
					if(result) {
						Swal.fire({
						  position: 'top',
						  icon: result.icon,
						  title: '<p class="h6">'+result.text+'</p>',
						  showConfirmButton: false,
						  timer: 2000,
						  toast: true
					  	});
						location.reload();
					}
				}
			});
		});
	</script>
@endpush


@push('strucdata')


@endpush