@extends('admin.master')

@section('content')
<form method="post" action="{{route('admin.lang.save')}}" enctype="multipart/form-data">
	@csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
    </div>
    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Ngôn ngữ</h3>
        </div>
        <div class="card-body">
			<div class="form-group">
				<label for="giatri">Từ khóa:</label>
                <input type="text" class="form-control" name="data[giatri]" id="giatri" placeholder="Từ khóa" value="{{(isset($rowItem))?$rowItem['giatri']:''}}" required {{(isset($rowItem))?'disabled':''}}>
			</div>
			<div class="row">
				@foreach(config('config_all.lang') as $key => $value)
				<div class="col-sm-6">
	              	<div class="form-group">
						<label for="lang{{$key}}">{{$value}}:</label>
						<input type="text" class="form-control" name="data[lang{{$key}}]" id="lang{{$key}}" placeholder="{{$value}} *" value="{{(isset($rowItem))?$rowItem['lang'.$key]:''}}" required>
					</div>
				</div>
	            @endforeach
			</div>
        </div>
    </div>
    <div class="card-footer text-sm">
        <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        <input type="hidden" name="id" value="{{(isset($rowItem))?$rowItem['id']:''}}">
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
	<script>
		$(document).ready(function(){
			$('#giatri').keyup(function(){
				var giatri = $(this).val();
				$(this).val(slugConvert(giatri));
			});
		});
	</script>
@endsection
