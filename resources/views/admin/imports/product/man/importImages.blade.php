@extends('admin.master')

@section('content')
@csrf
<div class="card card-primary card-outline text-sm">
    <div class="card-header">
        <h3 class="card-title">Upload hình ảnh</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="filer-gallery" class="label-filer-gallery mb-3">Hình ảnh</label>
            <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
            <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
            <input type="hidden" class="act-filer" name="level" value="man">
            <input type="hidden" class="folder-filer" name="model" value="product">
            <input type="hidden" class="folder-filer" name="type" value="{{ $type }}">
            <input type="hidden" name="folder-time" value="0">
            <input type="hidden" name="hash" value="{{ Helper::generateHash() }}" />
        </div>
    </div>
</div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
