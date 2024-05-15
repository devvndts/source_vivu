@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{route('admin.coupon.save',['man',$type])}}" enctype="multipart/form-data">
	@csrf
    <div class="text-sm card-footer sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="mr-2 far fa-save"></i>{{ __('Lưu') }}</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="mr-2 fas fa-redo"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{route('admin.coupon.show',['man',$type])}}" title="Thoát"><i class="mr-2 fas fa-sign-out-alt"></i>Thoát</a>
    </div>
    <div class="text-sm card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Chi tiết voucher</h3>
        </div>
        <div class="card-body">
        	<div class="row">
                <div class="form-group col-md-12">
                    <label for="ma">Mã voucher</label>
                    <input type="text" class="form-control for-seo" name="data[ma]" id="ma" placeholder="Nhập mã voucher" value="{{@$rowItem['ma']=='' ? $ma : $rowItem['ma']}}" {{(@$rowItem) ? 'readonly="readonly"':''}} required style="text-transform: uppercase;">
                </div>
           
                <div class="form-group col-md-4">
                    <label for="phantram">Loại giảm giá | Mức giảm</label>
                    <div class="input-group">
                    	<select class="form-control loaigiam_select" name="data[loaigiam]">
                    		<option value="0" {{(@$rowItem['loaigiam']==0) ? 'selected' : ''}}>Theo số tiền</option>
                    		<option value="1" {{(@$rowItem['loaigiam']==1) ? 'selected' : ''}}>Theo phần trăm</option>
                    	</select>
                        <input type="text" class="form-control format-price" name="data[mucgiam]" id="phantram" placeholder="Nhập phần trăm giảm giá" value="{{@$rowItem['mucgiam']}}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><strong id="loaigiam_value">{{(@$rowItem['loaigiam']==0) ? 'VNĐ' : '%'}}</strong></div>
                        </div>
                    </div>
                </div> 

                <div class="form-group col-md-4 d-none">
                    <label for="max_discount">Giảm tối đa:</label>
                    <div class="input-group">
                        <input type="text" class="form-control format-price" name="data[max_discount]" id="max_discount" placeholder="Nhập số tiền giảm tối đa" value="{{$rowItem['max_discount'] ?? ''}}">
                        <div class="input-group-append">
                            <div class="input-group-text"><strong>VNĐ</strong></div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="solan">Số lần áp dụng:</label>
                    <div class="input-group">
                        <input type="text" class="form-control format-price" name="data[solan]" id="solan" placeholder="Nhập số lần sử dụng" value="{{@$rowItem['solan']}}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><strong>Lần</strong></div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="ngaybatdau">Thời gian áp dụng:</label>
                    <div class="input-group">
                        <input class="form-control" type="date" name="data[ngaybatdau]" id="ngaybatdau" placeholder="Nhập ngày đắt đầu" value="{{@$rowItem['ngaybatdau']>0 ? date('Y-m-d',$rowItem['ngaybatdau']):''}}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><strong>đến</strong></div>
                        </div>
                        <input class="form-control" type="date" name="data[ngayketthuc]" id="ngayketthuc" placeholder="Nhập ngày kết thúc" value="{{@$rowItem['ngayketthuc']>0 ? date('Y-m-d',$rowItem['ngayketthuc']):''}}" required>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="min_price">Giá trị đơn hàng tối thiểu:</label>
                    <div class="input-group">
                        <input type="text" class="form-control format-price" name="data[min_price]" id="min_price" placeholder="Nhập số tiền tối thiểu mà đơn hàng cần có" value="{{@$rowItem['min_price']}}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><strong>VNĐ</strong></div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="dung_nhieulan">Được phép sử dụng:</label>
                    <div class="input-group">                        
                        <select class="form-control" name="data[dung_nhieulan]" id="dung_nhieulan">
                            <option value="0">Một</option>
                            <option value="1">Nhiều</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text"><strong>Lần</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="hienthi" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
				<div class="align-middle custom-control custom-checkbox d-inline-block">
					@if(@$rowItem['hienthi']==1 || !isset($rowItem))
					<input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" checked>
					@else
					<input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox">
					@endif
					<label for="hienthi-checkbox" class="custom-control-label"></label>
				</div>
            </div>
            <div class="form-group">
                <label for="stt" class="mb-0 mr-2 align-middle d-inline-block">Số thứ tự:</label>
                <input type="number" class="align-middle form-control form-control-mini d-inline-block" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{ (isset($rowItem['stt'])) ? $rowItem['stt'] : 1 }}">
            </div>
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="p-0 card-header border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                        @foreach(config('config_all.lang') as $k => $v)
                            <li class="nav-item">
                                <a class="nav-link {{($k=='vi')?'active':''}}" id="tabs-lang" data-toggle="pill" href="#tabs-lang-{{$k}}" role="tab" aria-controls="tabs-lang-{{$k}}" aria-selected="true">{{$v}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body card-article">
                    <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                        @foreach(config('config_all.lang') as $k => $v)
                            <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-lang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                                <div class="form-group">
                                    <label for="ten{{$k}}" class="inp">
                                        <input type="text" class="form-control for-seo" name="data[ten{{$k}}]" id="ten{{$k}}" placeholder="&nbsp;" value="{{@$rowItem['ten'.$k]}}" {{($k=='vi')?'required':''}}>
                                        <span class="label">Tiêu đề ({{$k}}):</span>
                                        <span class="focus-bg"></span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="noidung{{$k}}" class="inp">
                                    	<textarea class="form-control for-seo" name="data[noidung{{$k}}]" id="noidung{{$k}}" rows="5" placeholder="&nbsp;">{{ (isset($rowItem['noidung'.$k]))?$rowItem['noidung'.$k]:'' }}</textarea>
                                    	<span class="label">Nội dung ({{$k}}):</span>
										<span class="focus-bg"></span>
                                    </label>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
</form>
@endsection


<!--js thêm cho mỗi trang-->
@section('js_page')
	<script>
		$('.loaigiam_select').change(function(){
			var value = $(this).val();

			if(value==0){
				$('#loaigiam_value').text('VNĐ');
				$('#phantram').attr("placeholder", "Nhập số tiền");
			}else{
				$('#loaigiam_value').text('%');
				$('#phantram').attr("placeholder", "Nhập giá trị lớn hơn 1 %");
			}
		});
	</script>
@endsection
