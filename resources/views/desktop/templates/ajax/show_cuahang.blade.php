@if($cuahangs)
	<div class="product_cuahang_list">
		@foreach($cuahangs as $k=>$v)
			<div class="product_cuahang_item" data-id="{{$v['id']}}">
				{{$v['tenvi']}}
			</div>
		@endforeach
	</div>
@else
	<i class="fas fa-question-circle"></i> Không tìm thấy dữ liệu 
@endif