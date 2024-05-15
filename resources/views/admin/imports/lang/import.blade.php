@extends('admin.master')

@section('content')
    <form method="post" action="{{ route('admin.lang.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary card-outline text-sm mb-0">
            <div class="card-header">
                <h3 class="card-title">Import danh sách dữ liệu</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="d-inline-block align-middle mb-1 mr-2">Upload tập tin:</label>
                    <strong class="d-block mt-2 mb-2 text-sm">Loại : .xls|.xlsx</strong>
                    <div class="custom-file my-custom-file">
                        <input type="file" class="custom-file-input" name="import_file" id="import_file">
                        <label class="custom-file-label" for="file-excel">Chọn file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-success" name="import_orderExcel"><i class="fas fa-upload mr-2"></i>Import</button>
        </div>
    </form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
