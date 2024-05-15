@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{ route('admin.lazada.inventoryImport',['man', $type]) }}" enctype="multipart/form-data">
	@csrf
	<div class="mt-2" style="font-style: italic; color: #999;"><i class="fas fa-bell-on mr-1"></i> Cập nhật số lượng sản phẩm bằng cách tải file excel, thực hiện điều này sẽ làm thay đổi số lượng sản phẩm</div>
	<div class="mt-2">
		<div class="lazada-input-excel">
			<label for="file"><i class="fas fa-file-import mr-3"></i> Tải file Excel</label>
   			<input type="file" id="file" name="file">
		</div>

		<div class="lazada-format-excel">			
			<div class="lazada-format-excel-item">
			    <input type="radio" name="format" id="txt" value="add" checked>
			    <label for="txt">{{($type=='nhapkho') ? 'Thêm' : 'Giảm'}} số lượng</label>
			</div>
			@if($type=='nhapkho')
			<div class="lazada-format-excel-item">
			    <input type="radio" name="format" id="csv" value="change">
			    <label for="csv">Thay đổi số lượng</label>
			</div>
			@endif
		</div>

		<a class="btn btn-sm bg-gradient-primary text-white mt-3 mr-1" href="{{ route('admin.lazada.inventoryExport',['man', $type]) }}" title="File mẫu"><i class="far fa-file-excel mr-2"></i>File mẫu</a>
		<button type="sbumit" class="btn btn-sm btn-info btn-export-excel mt-3 text-white" title="Đồng bộ bằng Excel"><i class="fal fa-file-excel mr-1"></i>Xác nhận</button>
	</div>
	<input type="hidden" name="type" value="{{$type}}">
</form>

<div class="row mt-3">
	<div class="col-12">
		<div class="card">
	        <div class="card-header">
	        	<div class="row">
		          <div class="form-inline col-sm-3 form-search d-inline-block align-middle mb-2">
			          <div class="input-group input-group-sm">
			              <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.lazada.inventory',['man', $type]) }}')">
			              <div class="input-group-append bg-primary rounded-right">
			                  <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.lazada.inventory',['man', $type]) }}')">
			                      <i class="fas fa-search"></i>
			                  </button>
			              </div>
			          </div>
			      </div>			      
			    </div>
	        </div>
    		<!-- /.card-header -->

        	<div class="card-body table-responsive">
				<div class="row">
				   <div class="col-sm-12">
				      <table class="table table-hover text-nowrap">
				         <thead>
				            <tr>
								<th class="align-middle text-center">
									<div class="icheck-primary d-inline dev-check">
				                        <input type="checkbox" id="checkAll">
				                        <label for="checkAll"></label>
				                    </div>
								</th>
								<th class="align-middle text-center">STT</th>

								<th>Mã phiếu</th>
								<th>Loại phiếu</th>
								<th>Ngày tạo</th>
								<th>Người tạo</th>

								<th class="text-center">Thao tác</th>
				            </tr>
				         </thead>
				         <tbody>
				         	@foreach($items_inventory as $k=>$v)
				            <tr>
								<td class="dev-item-checkbox align-middle text-center">
									<div class="icheck-primary d-inline dev-check">
				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="{{ $v['id'] }}">
				                        <label for="checkItem-{{$v['id']}}"></label>
				                    </div>
								</td>
								<td class="dev-item-stt">
									<input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="{{$v['stt']}}" data-id="{{$v['id']}}" data-model="post" data-level="man">
								</td>																
								<td class="dev-item-name">
									<a href="{{route('admin.lazada.EditInventory',['man',$type,$v['id']])}}">{{$v['maphieu']}}</a>
								</td>
								<td class="dev-item-name">
									<a>{{($v['type_format']=='add') ? 'Thêm' : 'Thay đổi'}}</a>
								</td>
								<td class="dev-item-name text-info">{{date('d-m-Y h:m:s',$v['ngaytao'])}}</td>
								<td class="dev-item-name">
									@php
										$user_info = Auth::guard('admin')->user()->find($v['id_user']);
									@endphp
									<span class="text-danger"><strong>{{$user_info->name}}</strong></span>
								</td>

                                <td class="dev-item-option align-middle text-center">
									<div class="dropdown show">
									  <a class="btn-dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									    <i class="fas fa-ellipsis-v" ></i>
									  </a>

									  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									    <a class="btn btn-sm d-block btn-none-css" href="{{route('admin.lazada.EditInventory',['man',$type,$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i> Chỉnh sửa</a>
									  </div>
									</div>									
								</td>
				            </tr>
				            @endforeach
				         </tbody>
				      </table>
				   </div>
				</div>
          	</div>
          	
          	<!-- /.card-body -->
          	<div class="card-footer">
              	<div class="row">
				   <div class="col-sm-12 dev-center dev-paginator">{{ $items_inventory->links() }}</div>
				</div>
          	</div>
        </div>
	</div>
</div>
@endsection


<!--js thêm cho mỗi trang-->
@push('css')
	<link rel="stylesheet" href="{{asset('css/admin/lazada.css')}}" >
@endpush


<!--js thêm cho mỗi trang-->
@push('js')
	
@endpush
