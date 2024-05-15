@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{route('admin.contact.save',['man',$type])}}" enctype="multipart/form-data">
	@csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{route('admin.contact.show',['man',$type])}}" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
    </div>
    <div class="card card-primary card-outline text-sm">
		<div class="card-header">
            <h3 class="card-title">Chi tiết {{$config[$type]['title_main']}}</h3>
        </div>
        <div class="card-body">
            <div class="form-group-category row">
                @if(isset($config[$type]['ten']) && $config[$type]['ten'] == true)
                    <div class="form-group col-md-4">
                        <label for="ten">Họ tên:</label>
                        <input type="text" class="form-control" name="data[tenvi]" id="ten" placeholder="Họ tên" value="{{$rowItem['tenvi']}}">
                    </div>
                @endif

                @if(isset($config[$type]['dienthoai']) && $config[$type]['dienthoai'] == true)
                    <div class="form-group col-md-4">
                        <label for="dienthoai">Điện thoại:</label>
                        <input type="text" class="form-control" name="data[dienthoai]" id="dienthoai" placeholder="Điện thoại" value="{{$rowItem['dienthoai']}}">
                    </div>
                @endif

                @if(isset($config[$type]['email']) && $config[$type]['email'] == true)
                    <div class="form-group col-md-4">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="data[email]" id="email" placeholder="Email" value="{{$rowItem['email']}}">
                    </div>
                @endif

                @if(isset($config[$type]['diachi']) && $config[$type]['diachi'] == true)
                    <div class="form-group col-md-4">
                        <label for="diachi">Địa chỉ:</label>
                        <input type="text" class="form-control" name="data[diachi]" id="diachi" placeholder="Địa chỉ" value="{{$rowItem['diachi']}}">
                    </div>
                @endif

                @if(isset($config[$type]['tieude']) && $config[$type]['tieude'] == true)
                    <div class="form-group col-md-4">
                        <label for="tieude">Chủ đề:</label>
                        <input type="text" class="form-control" name="data[tieude]" id="tieude" placeholder="Tiêu đề" value="{{$rowItem['tieude']}}">
                    </div>
                @endif
            </div>
            @if(isset($config[$type]['noidung']) && $config[$type]['noidung'] = true)
                <div class="form-group">
                    <label for="noidung">Nội dung:</label>
                    <textarea class="form-control" name="data[noidung]" id="noidung" rows="5" placeholder="Nội dung">{{$rowItem['noidung']}}</textarea>
                </div>
            @endif
            @if(isset($config[$type]['ghichu']) && $config[$type]['ghichu'] = true)
                <div class="form-group">
                    <label for="ghichu">Ghi chú:</label>
                    <textarea class="form-control" name="data[ghichu]" id="ghichu" rows="5" placeholder="Ghi chú">{{$rowItem['ghichu']}}</textarea>
                </div>
            @endif
			@if(isset($rowItem['taptin']) && ($rowItem['taptin'] != ''))
				<div class="form-group">
					<a class="btn btn-sm bg-gradient-primary text-white d-inline-block align-middle p-2 rounded mb-1" href="{{ Helper::GetFolder($folder_upload,true).$rowItem['taptin'] }}" title="Download tập tin hiện tại"><i class="fas fa-download mr-2"></i>Download tập tin hiện tại</a>
				</div>
			@endif
            <div class="form-group">
                <label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{(isset($rowItem['stt'])) ? $rowItem['stt'] : 1}}">
            </div>
			<div class="form-group">
				<label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Duyệt:</label>
				<div class="custom-control custom-checkbox d-inline-block align-middle">
                    <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" {{(!isset($rowItem['hienthi']) || $rowItem['hienthi']==1)?'checked':''}}>
                    <label for="hienthi-checkbox" class="custom-control-label"></label>
                </div>
			</div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
