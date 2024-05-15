<div class="manage-form-left-box">
	<p class="manage-form-img">
		<span id="photoUpload-preview" class="manage-form-img-preview">
			@if($user['photo'])
				<img src="{{Thumb::Crop(UPLOAD_USER,$user['photo'],200,200,1)}}" alt="camera">
				<span class="manage-form-img-edit">Chỉnh sửa</span>
			@else
				<img src="img/manage/icon_camera.png" alt="camera">
			@endif
		</span>
		<label class="module-upload-file css-upload-file" id="photo-zone" for="file-zone" data-preview="photoUpload-preview">
			<input type="file" name="file" id="file-zone">
		</label>
	</p>
	<p class="manage-form-name">{{$user['name']}}</p>
	<a class="manage-form-passnew" href="{{ route('account.editpass') }}">Tạo mật khẩu mới</a>

	<div class="login-account-list">
		<a class="login-account-info"><i class="fal fa-coins mr-2"></i>Số xu: {{$user['tongxu']}}</a>
		<a class="login-account-info" href="{{ route('account.manage') }}"><i class="far fa-edit mr-2"></i>Thông tin tài khoản</a>
		<a class="login-account-managecoin" href="{{ route('account.managecoin') }}"><i class="far fa-usd-circle mr-2"></i>Thực hiện nạp/rút xu</a>
		<a class="login-account-historycoin" href="{{ route('account.historycoin') }}"><i class="far fa-history mr-2"></i>Lịch sử vả xử lý nạp/rút xu</a>
		<a class="login-account-historycoin" href="{{ route('account.historypay') }}"><i class="fal fa-exchange mr-2"></i>Biến động xu</a>
		<a class="login-account-newlike" href="{{ route('account.newlike') }}"><i class="far fa-save mr-2"></i>Tin đã lưu</a>
		<a class="login-account-newlike" href="{{ route('account.buyPostMonth') }}"><i class="fal fa-money-bill-wave mr-2"></i>Mua gói tin theo tháng</a>
		<a class="login-account-newlike" href="{{ route('account.regisVIP') }}"><i class="fal fa-user-tie mr-2"></i>Đăng ký làm cộng tác viên</a>
	</div>
</div>