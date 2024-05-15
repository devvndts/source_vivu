@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{route('admin.places.save',['list'])}}" enctype="multipart/form-data">
	@csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
        <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="savehere"><i class="far fa-save mr-2"></i>Lưu tại trang</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{route('admin.places.show',['list'])}}" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">{{(isset($rowItem['id']))?"Cập nhật":"Thêm mới"}} Tỉnh thành</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ten">Tiêu đề:</label>
                        <input type="text" class="form-control for-seo" name="data[ten]" id="ten" placeholder="Tiêu đề" value="{{ (isset($rowItem['ten']))?$rowItem['ten']:'' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Hiển thị:</label>
                        <div class="custom-control custom-checkbox d-inline-block align-middle">
                            @if($rowItem['hienthi']==1 || !isset($rowItem))
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" checked>
                            @else
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox">
                            @endif
                            <label for="hienthi-checkbox" class="custom-control-label"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                        <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{ (isset($rowItem['stt']))?$rowItem['stt']:'1' }}">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-sm">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
        <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="savehere"><i class="far fa-save mr-2"></i>Lưu tại trang</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{route('admin.places.show',['list'])}}" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
