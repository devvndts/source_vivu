@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{ route('admin.lazada.import',['man', $type]) }}" enctype="multipart/form-data">
	@csrf
	<div class="mt-2">
		<div class="lazada-input-excel">
			Thông báo: Đồng bồ sản phẩm website và lazada thông qua mã sản phẩm. Mã sản phẩm phải giống nhau giữa website và sàn lazada
		</div>		
		<button type="sbumit" class="btn btn-sm btn-info btn-export-excel mt-3 text-white" title="Đồng bộ bằng Excel"><i class="fal fa-file-excel mr-1"></i>Đồng bộ</button>
	</div>

	<input type="hidden" name="type" value="{{$type}}">
</form>
@endsection


<!--js thêm cho mỗi trang-->
@push('css')
	<link rel="stylesheet" href="{{asset('css/admin/lazada.css')}}" >
@endpush


<!--js thêm cho mỗi trang-->
@push('js')
	
@endpush
