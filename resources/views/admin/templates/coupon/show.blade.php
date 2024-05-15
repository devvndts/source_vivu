@extends('admin.master')

@section('content')
	@csrf
	<div class="card-footer text-sm sticky-top">
    	<a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.coupon.edit',['man',$type]) }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.coupon.deleteAll', ['man', $type]) }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card"> 
                <div class="card-header">
                    <div class="form-inline col-sm-3 form-search d-inline-block align-middle">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.coupon.show',['man', $type]) }}')">
                            <div class="input-group-append bg-primary rounded-right">
                                <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.coupon.show',['man', $type]) }}')">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
        						<th class="align-middle text-center">
        							<div class="icheck-primary d-inline dev-check">
        								<input type="checkbox" id="checkAll">
        								<label for="checkAll"></label>
        							</div>
        						</th>
                                <th class="align-middle text-center">Mã</th>
        						<th class="align-middle " >Tiêu đề</th>
		                        <th class="align-middle text-center">Thời gian áp dụng</th>
		                        {{--<th class="align-middle text-center">% khuyến mãi</th>
		                        <th class="align-middle text-center">Giảm tối đa</th>--}}
		                        <th class="align-middle text-center">Số lần còn lại</th>
		                        <th class="align-middle text-center">Đơn hàng tối thiểu</th>
		                        <th class="align-middle text-center">Được sử dụng</th>
		                        <th class="align-middle text-center">Hiển thị</th>
		                        <th class="align-middle text-center">Nổi bật</th>
		                        <th class="align-middle text-center">Thao tác</th>
                            </tr>
                        </thead>
                        @if(empty($itemShow))
                            <tbody><tr><td colspan="100" class="text-center">Không có dữ liệu</td></tr></tbody>
                        @else
                            <tbody>
                                @foreach($itemShow as $k=>$v)
                                    <tr>
        								<td class="dev-item-checkbox align-middle text-center">
        									<div class="icheck-primary d-inline dev-check">
        				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="{{$v['id']}}">
        				                        <label for="checkItem-{{$v['id']}}"></label>
        				                    </div>
        								</td>
        								<td class="align-middle text-center">
		                                    <strong>{{$v['ma']}}</strong>
		                                </td>

                                        <td class="align-middle">
                                            <a class="text-dark" href="{{route('admin.coupon.edit',['man',$type,$v['id']])}}" title="{{$v['tenvi']}}">{{$v['tenvi']}}</a>
                                        </td>                                        

		                                <td class="align-middle text-center">
		                                    <span style="font-size: 12px; color: #666;"><?=date('d/m/y',$v['ngaybatdau'])?> - <?=date('d/m/y',$v['ngayketthuc'])?></span>
		                                    <div>
		                                        @if(time()<$v['ngaybatdau'] && time()<$v['ngayketthuc'])
		                                            <span class="text-primary">Chưa áp dụng</span>
		                                        @elseif(time()>$v['ngaybatdau'] && time()<$v['ngayketthuc'])
		                                            <span class="text-success">Đang áp dụng</span>
		                                        @else
		                                            <span class="text-danger">Đã hết hạn</span>
		                                        @endif
		                                    </div>
		                                </td>

		                                {{--
		                                <td class="align-middle text-center">
		                                    @php
			                                    if($v['mucgiam']>=60){
			                                        $text_pc='text-success';
			                                    }else if($v['mucgiam']>=30){
			                                        $text_pc='text-warning';
			                                    }else if($v['mucgiam']>=10){
			                                        $text_pc='text-danger';
			                                    }else{
			                                        $text_pc='';
			                                    }
		                                    @endphp
		                                    <strong class="{{$text_pc}}">{{($v['max_discount']) ? $v['mucgiam'].'%':''}}</strong>
		                                </td>

		                                
		                                <td class="align-middle text-center">
		                                    <span class="text-danger">{{($v['max_discount']) ? Helper::Format_Money($v['max_discount']):''}}</span>
		                                </td>--}}

		                                <td class="align-middle text-center">
		                                	@php
			                                	$text_alert='';

			                                	if(($v['solan']-$v['solan_dadung'])>10){
			                                		$text_alert = 'text-success';
			                                	}else if(($v['solan']-$v['solan_dadung'])<0 && ($v['solan']-$v['solan_dadung'])<=10){
			                                		$text_alert = 'text-warning';
			                                	}else{
			                                		$text_alert = 'text-danger';
			                                	}
		                                	@endphp

		                                    <strong class="{{$text_alert}}">{{$v['solan']-$v['solan_dadung']}}</strong>
		                                </td>

		                                 <td class="align-middle text-center text-success">
		                                    <span class="">{{($v['min_price']>0) ? Helper::Format_Money($v['min_price']):'0đ'}}</span>
		                                </td>

		                                 <td class="align-middle text-center">
		                                 	@if($v['dung_nhieulan']==1)
		                                 		<strong class="text-success">Nhiều lần</strong>
		                                 	@else
		                                 		<strong class="text-danger">Một lần</strong>
		                                 	@endif
		                                </td>

        								<td class="align-middle text-center dev-item-display show-checkbox">
                                        	<div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-model="coupon" data-level="man" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                                <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center dev-item-display show-checkbox">
                                        	<div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-model="coupon" data-level="man" data-id="{{ $v['id'] }}" data-loai="noibat" {{($v['noibat'])?'checked':''}}>
                                                <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                            </div>
                                        </td>

                                        <td class="dev-item-option align-middle text-center">
                                            <div class="dropdown show">
                                              <a class="btn-dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="fas fa-ellipsis-v" ></i>
                                              </a>

                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="btn btn-sm d-block btn-none-css" href="{{route('admin.coupon.edit',['man',$type,$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i> Chỉnh sửa</a>
                                                    <a class="btn btn-sm d-block delete-item btn-none-css" data-url="{{route('admin.coupon.delete',['man',$type,$v['id']])}}" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa</a>
                                              </div>
                                            </div>                                  
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
                <div class="card-footer">
                  <div class="row">
                     <div class="col-sm-12 dev-center dev-paginator">{{ $itemShow->links() }}</div>
                  </div>      
                </div>
            </div>
        </div>
    </div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
