@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{route('admin.question.save',['man'])}}" enctype="multipart/form-data">
	@csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
        <div class="btn dropdown pl-0 ml-1">
          <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Thao tác
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button type="reset" class="btn btn-sm bg-gradient-secondary btn-none-css"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger btn-none-css" href="{{route('admin.question.show',['man'])}}" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
          </div>
        </div>        
    </div>
    <div class="card card-primary card-outline text-sm">
		<div class="card-header">
            <h3 class="card-title">Chi tiết</h3>
        </div>
        <div class="card-body">           
            <div class="form-group-category row">                
                <div class="form-group col-md-4">
                    <label for="ten">Họ tên:</label>
                    <input type="text" class="form-control" name="data[hoten]" id="ten" placeholder="Họ tên" value="{{$rowItem['hoten']}}">
                </div>

                <div class="form-group col-md-4">
                    <label for="dienthoai">Điện thoại:</label>
                    <input type="text" class="form-control" name="data[dienthoai]" id="dienthoai" placeholder="Điện thoại" value="{{$rowItem['dienthoai']}}">
                </div>
                
                <div class="form-group col-md-4">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="data[email]" id="email" placeholder="Email" value="{{$rowItem['email']}}">
                </div>
            </div>

            <div class="form-group">
                <label for="noidung">Nội dung câu hỏi:</label>
                <textarea class="form-control" name="data[noidung]" id="noidung" rows="5" placeholder="Nội dung">{{$rowItem['noidung']}}</textarea>
            </div>

            <div class="form-group">
                <label for="ghichu"><i class="fas fa-comments"></i> Quản trị viên trả lời:</label>
                <textarea class="form-control" name="data[answer]" id="answer" rows="5" placeholder="">{{$rowItem['answer']}}</textarea>
            </div>

			<div class="form-group">
				<label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Đã duyệt:</label>
				<div class="custom-control custom-checkbox d-inline-block align-middle">
                    <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[duyettin]" id="hienthi-checkbox" {{(!isset($rowItem['duyettin']) || $rowItem['duyettin']==1)?'checked':''}}>
                    <label for="hienthi-checkbox" class="custom-control-label"></label>
                </div>
			</div>
        </div>
    </div>
    <div class="card-footer text-sm">
        <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
