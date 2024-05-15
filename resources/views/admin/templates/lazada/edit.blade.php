@extends('admin.master')

@section('content')
<div class="row mt-3">
	<div class="col-12">
		<div class="card">
	        <div class="card-header">
	        	<div class="row">
		          <div class="form-inline col-sm-3 form-search d-inline-block align-middle mb-2">
			          <div class="input-group input-group-sm">
			              <h5>Chi tiết phiếu</h5>
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

								<th>Sản phẩm</th>
								<th>Ngày tạo</th>
								<th class="text-center">Tồn đầu</th>
								<th class="text-center">{{($type=='nhapkho') ? 'Nhập' : 'Xuất'}} kho</th>
								<th class="text-center">Tồn cuối</th>
				            </tr>
				         </thead>
				         <tbody>
				         	@foreach($items as $k=>$v)
				         	@php
				         		$infoPro = Helper::GetInfoProduct($v['id_product'], $v['table']);
				         	@endphp

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

								<td class="dev-item-name"><a>{{$infoPro['tenvi'] ?? ''}}</a></td>
								<td class="dev-item-name text-info">{{date('d-m-Y h:m:s',$v['ngaytao'])}}</td>		
								<td class="dev-item-name text-center"><a>{{$v['soluongton_website']}}</a></td>	
								<td class="dev-item-name text-center"><a>{{$v['soluongnhap_website']}}</a></td>	
								<td class="dev-item-name text-center"><a class="text-danger">{{$v['soluongtoncuoi_website']}}</a></td>						
				            </tr>
				            @endforeach
				         </tbody>
				      </table>
				   </div>
				</div>
          	</div>
        </div>
	</div>
</div>
@endsection


<!--js thêm cho mỗi trang-->
@section('js_page')
	
	
@endsection
