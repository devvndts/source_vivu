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

				<div class="list-post-newlike">
					@foreach($posts as $k=>$v)
						@php
							$user = $v['belong_user'];
                        	$comments = ($v['has_comments']) ? count($v['has_comments']) : 0;
						@endphp
						<div class="sidebar-tab-item">
							<a href="{{$v['tenkhongdau'.$lang]}}-{{$v['id']}}" title="" class="sidebar-tab-img himg"><img src="{{Thumb::Crop(UPLOAD_POST,$v['photo'],150,100,1)}}" alt="" width="150" height="100"></a>
							<div class="sidebar-tab-info">
								<h2 class="sidebar-tab-name"><a href="{{$v['tenkhongdau'.$lang]}}-{{$v['id']}}">{{$v['ten'.$lang]}}</a></h2>
								<div class="sidebar-tab-detail">
									<span class="sidebar-tab-date">
										<svg class="mr-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M9 0.875C4.51172 0.875 0.875 4.51172 0.875 9C0.875 13.4883 4.51172 17.125 9 17.125C13.4883 17.125 17.125 13.4883 17.125 9C17.125 4.51172 13.4883 0.875 9 0.875ZM9.54688 9.70312C9.54688 10.0039 9.30078 10.25 9 10.25H5.25C4.94922 10.25 4.70312 10.0039 4.70312 9.70312C4.70312 9.40234 4.94922 9.15625 5.25 9.15625H8.45312V4C8.45312 3.69922 8.69922 3.45312 9 3.45312C9.30078 3.45312 9.54688 3.69922 9.54688 4V9.70312Z" fill="#F40000"/>
										</svg>
										{{date('d/m/Y',$v['ngaytao'])}}
									</span>
									<p class="sidebar-tab-comment-view">
										<span class="sidebar-tab-comment">
											<svg class="mr-1" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
												<g clip-path="url(#clip0_2_154)">
													<path d="M14.4444 7.77778V2.22222C14.4444 0.996528 13.4479 0 12.2222 0H2.22222C0.996528 0 0 0.996528 0 2.22222V7.77778C0 9.00347 0.996528 10 2.22222 10V11.8819C2.22222 12.1597 2.53819 12.3194 2.76042 12.1528L5.63542 9.99653H12.2222C13.4479 10 14.4444 9.00347 14.4444 7.77778V7.77778ZM17.7778 5.55556H15.5556V7.77778C15.5556 9.61458 14.059 11.1111 12.2222 11.1111H6.66667V13.3333C6.66667 14.559 7.66319 15.5556 8.88889 15.5556H13.2535L16.1285 17.7118C16.3507 17.8785 16.6667 17.7188 16.6667 17.441V15.5556H17.7778C19.0035 15.5556 20 14.559 20 13.3333V7.77778C20 6.55208 19.0035 5.55556 17.7778 5.55556Z" fill="#F40000"/>
												</g>
												<defs>
													<clipPath id="clip0_2_154">
														<rect width="20" height="17.7778" fill="white"/>
													</clipPath>
												</defs>
											</svg>
											{{$comments}}
										</span>
										<span class="sidebar-tab-view ml-2">
											<svg class="mr-1" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M19.8791 8.38189C17.9962 4.70793 14.2684 2.22217 9.99998 2.22217C5.73158 2.22217 2.00276 4.70967 0.120814 8.38224C0.0413844 8.53936 0 8.71295 0 8.88901C0 9.06507 0.0413844 9.23866 0.120814 9.39578C2.0038 13.0697 5.73158 15.5555 9.99998 15.5555C14.2684 15.5555 17.9972 13.068 19.8791 9.39543C19.9586 9.23831 20 9.06472 20 8.88866C20 8.7126 19.9586 8.53901 19.8791 8.38189V8.38189ZM9.99998 13.8888C9.01107 13.8888 8.04437 13.5956 7.22213 13.0462C6.39988 12.4968 5.75902 11.7159 5.38058 10.8023C5.00214 9.88862 4.90313 8.88329 5.09605 7.91338C5.28898 6.94348 5.76518 6.05256 6.46445 5.3533C7.16371 4.65404 8.05462 4.17783 9.02453 3.98491C9.99443 3.79198 10.9998 3.891 11.9134 4.26944C12.827 4.64788 13.6079 5.28874 14.1573 6.11098C14.7067 6.93323 15 7.89993 15 8.88883C15.0003 9.54553 14.8712 10.1959 14.62 10.8026C14.3689 11.4094 14.0006 11.9607 13.5362 12.4251C13.0719 12.8894 12.5205 13.2577 11.9138 13.5089C11.307 13.76 10.6567 13.8892 9.99998 13.8888V13.8888ZM9.99998 5.5555C9.70246 5.55966 9.40685 5.60392 9.12116 5.6871C9.35665 6.00712 9.46966 6.40095 9.43969 6.79715C9.40972 7.19335 9.23875 7.56569 8.95779 7.84665C8.67684 8.1276 8.3045 8.29857 7.90829 8.32854C7.51209 8.35852 7.11827 8.24551 6.79824 8.01002C6.61601 8.6814 6.64891 9.39303 6.8923 10.0447C7.1357 10.6964 7.57733 11.2554 8.15505 11.643C8.73277 12.0306 9.41749 12.2272 10.1128 12.2052C10.8081 12.1833 11.4791 11.9438 12.0312 11.5205C12.5833 11.0973 12.9888 10.5115 13.1905 9.84578C13.3923 9.18 13.3802 8.46772 13.156 7.80917C12.9317 7.15063 12.5066 6.57899 11.9405 6.17471C11.3743 5.77043 10.6957 5.55386 9.99998 5.5555V5.5555Z" fill="#F40000"/>
											</svg>
											{{$v['luotxem']}}
										</span>
									</p>
								</div>
								<a data-id="{{$v['id']}}" class="sidebar-tab-unsave"><i class="fal fa-trash-alt mr-1"></i>Xóa khỏi danh sách</a>
							</div>
						</div>
					@endforeach
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
	<!-- daterangepicker -->
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

	<script>
		$('#manage-form').submit(function(e){
			if(!$('#email-loading-gif').hasClass('email-loading-active')){
				e.preventDefault();
				$('#email-loading-gif').addClass('email-loading-active');
			}
			$('#manage-form')[0].submit();
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

	<script>
		$('.sidebar-tab-unsave').click(function(){
			var id = $(this).attr('data-id');
			var e = $(this);

			$.ajax({
				url: '{{route('ajax.unSavePost')}}',
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
				},
				complete: function(){
			        
			    }
			});
		});
	</script>
@endpush


@push('strucdata')


@endpush