@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{ route('admin.member.save') }}" enctype="multipart/form-data">
    @csrf
    <div class="text-sm card-footer sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary" disabled><i class="mr-2 far fa-save"></i>{{ __('Lưu') }}</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="mr-2 fas fa-redo"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{ route('admin.member.show') }}" title="Thoát"><i class="mr-2 fas fa-sign-out-alt"></i>Thoát</a>
    </div>
    <div class="text-sm card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{(isset($request->id))?"Cập nhật":"Thêm mới"}} tài khoản</h3>
        </div>
        <div class="card-body">
        	<div class="row">
				<div class="form-group col-md-4">
					@if(isset($config['permission']) && $config['permission'] == true)
						<label for="permission">Danh sách nhóm quyền:</label>
						{!! Helper::get_permission(@$rowItem['id_nhomquyen']) !!}
					@endif
				</div>
				<div class="form-group col-md-4">
					<label for="username">Tài khoản: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="data[username]" id="username" placeholder="Tài khoản" value="{{@$rowItem['username']}}" {{(isset($request->id))?'readonly':''}} required>
				</div>
				<div class="form-group col-md-4">
					<label for="name">Họ tên: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="data[name]" id="name" placeholder="Họ tên" value="{{@$rowItem['name']}}" required>
				</div>
				<div class="form-group col-md-4">
					<label for="password">Mật khẩu:</label>
					<input type="password" class="form-control" name="data[password]" id="password" placeholder="Mật khẩu" {{(!isset($request->id))?'required':''}}>
				</div>
				<div class="form-group col-md-4">
					<label for="confirm_password">Nhập lại mật khẩu:</label>
					<input type="password" class="form-control" name="data[confirm_password]" id="confirm_password" placeholder="Nhập lại mật khẩu" {{(!isset($request->id))?'required':''}}>
				</div>
				<div class="form-group col-md-4">
					<label for="email">Email:</label>
					<input type="email" class="form-control" name="data[email]" id="email" placeholder="Email" value="{{@$rowItem['email']}}">
				</div>
				<div class="form-group col-md-4">
					<label for="dienthoai">Điện thoại:</label>
					<input type="text" class="form-control" name="data[dienthoai]" id="dienthoai" placeholder="Điện thoại" value="{{@$rowItem['dienthoai']}}">
				</div>
			</div>
			<div class="form-group">
				<label for="hienthi" class="mb-0 mr-2 align-middle d-inline-block">Kích hoạt:</label>
				<div class="align-middle custom-control custom-checkbox d-inline-block">
                    <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" {{(!isset($rowItem['hienthi']) || $rowItem['hienthi']==1)?'checked':''}}>
                    <label for="hienthi-checkbox" class="custom-control-label"></label>
                </div>
			</div>
        </div>
    </div>
    <div class="text-sm card-footer">
        <button type="submit" class="btn btn-sm bg-gradient-primary" disabled><i class="mr-2 far fa-save"></i>{{ __('Lưu') }}</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="mr-2 fas fa-redo"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{ route('admin.member.show') }}" title="Thoát"><i class="mr-2 fas fa-sign-out-alt"></i>Thoát</a>
        <input type="hidden" name="id" value="{{isset($rowItem['id'])?$rowItem['id']:''}}">
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
<script type="text/javascript">

</script>
@endsection
