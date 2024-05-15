@extends('desktop.master')

@section('element_detail','page-login')

@section('content')
	<div class="container my-6">
        @php
            $validates = ($errors->any()) ? $errors->toArray() : null;
        @endphp

        <div class="mb-5 login-layout">
            <form id="login-form" action="{{ route('account.login') }}" method="POST">
                @csrf
                <div class="login-form-title">Đăng nhập</div>
                @if(isset($validates['iskichhoat']))<span class="login-form-alert-lg"><i class="mr-2 fal fa-exclamation-circle"></i> {{ $validates['iskichhoat'][0] }}</span>@endif
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
                        <svg class="login-hidden-password opacity-password" width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12.01 20c-5.065 0-9.586-4.211-12.01-8.424 2.418-4.103 6.943-7.576 12.01-7.576 5.135 0 9.635 3.453 11.999 7.564-2.241 4.43-6.726 8.436-11.999 8.436zm-10.842-8.416c.843 1.331 5.018 7.416 10.842 7.416 6.305 0 10.112-6.103 10.851-7.405-.772-1.198-4.606-6.595-10.851-6.595-6.116 0-10.025 5.355-10.842 6.584zm10.832-4.584c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 1c2.208 0 4 1.792 4 4s-1.792 4-4 4-4-1.792-4-4 1.792-4 4-4z"/></svg>				
                        
                        <svg class="login-show-password" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M637 485.25L23 1.75A8 8 0 0 0 11.76 3l-10 12.51A8 8 0 0 0 3 26.75l614 483.5a8 8 0 0 0 11.25-1.25l10-12.51a8 8 0 0 0-1.25-11.24zM320 96a128.14 128.14 0 0 1 128 128c0 21.62-5.9 41.69-15.4 59.57l25.45 20C471.65 280.09 480 253.14 480 224c0-36.83-12.91-70.31-33.78-97.33A294.88 294.88 0 0 1 576.05 256a299.73 299.73 0 0 1-67.77 87.16l25.32 19.94c28.47-26.28 52.87-57.26 70.93-92.51a32.35 32.35 0 0 0 0-29.19C550.3 135.59 442.94 64 320 64a311.23 311.23 0 0 0-130.12 28.43l45.77 36C258.24 108.52 287.56 96 320 96zm60.86 146.83A63.15 63.15 0 0 0 320 160c-1 0-1.89.24-2.85.29a45.11 45.11 0 0 1-.24 32.19zm-217.62-49.16A154.29 154.29 0 0 0 160 224a159.39 159.39 0 0 0 226.27 145.29L356.69 346c-11.7 3.53-23.85 6-36.68 6A128.15 128.15 0 0 1 192 224c0-2.44.59-4.72.72-7.12zM320 416c-107.36 0-205.47-61.31-256-160 17.43-34 41.09-62.72 68.31-86.72l-25.86-20.37c-28.48 26.28-52.87 57.25-70.93 92.5a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448a311.25 311.25 0 0 0 130.12-28.43l-29.25-23C389.06 408.84 355.15 416 320 416z"></path>
                        </svg>
                    </p>
                    <span class="login-form-alert">{{(isset($validates['password'])) ? $validates['password'][0] : ''}}</span>
                </div>
                <div class="login-form-flex">
                    <div class="login-form-flexreset">					
                        <p class="login-form-signin-btn"><a href="{{route('account.signin')}}">Đăng ký</a> nếu chưa có tài khoản</p>
                        {{-- <a class="login-form-reset" href="{{route('account.resetAccount')}}"><span>Hoặc</span> Quên mật khẩu ?</a> --}}
                    </div>
                    <button type="submit" class="login-form-submit">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<!--js thêm cho mỗi trang-->

@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/login.css') }} ">
@endpush


@push('js_page')
	<script>
		$('.login-show-password').click(function(){
			var type = $('#password').attr('type');

			if(type=='password'){
				$('#password').attr('type','text');
				$('.login-show-password').addClass('opacity-password');		
				$('.login-hidden-password').removeClass('opacity-password');				
			}else{
				$('#password').attr('type','password');	
				$('.login-show-password').removeClass('opacity-password');		
				$('.login-hidden-password').addClass('opacity-password');			
			}
		});
	</script>
@endpush


@push('strucdata')


@endpush