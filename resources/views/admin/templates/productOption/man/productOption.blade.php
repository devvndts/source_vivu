@extends('admin.master')

@section('content')
	@csrf
	<div class="card-footer sticky-top">
		<a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.productOption.edit',['man',$type,'id_product'=>$idParent]) }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
		<a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.productOption.deleteAll', ['man', $type, 'id_product'=>$idParent]) }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
              <div class="card-header">
              	<div class="row">
	                <div class="form-inline col-sm-3 form-search d-inline-block align-middle mb-2">
			            <div class="input-group input-group-sm">
			                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.productOption.show',['man', $type]) }}')">
			                <div class="input-group-append bg-primary rounded-right">
			                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.productOption.show',['man', $type]) }}')">
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

								@if(isset($config[$type]['show_images_option']) && $config[$type]['show_images_option'] == true)
								<th>Hình</th>
								@endif

								<th>Tiêu đề</th>
								@if(config('config_all.order.soluong') || config('lazada.active'))
								<th class="align-middle text-center">Số lượng</th>
								@endif
								{{-- 
									<th class="align-middle text-center">Màu sắc</th>
									--}}
                        		<th class="align-middle text-center">Size</th>
								<th class="align-middle text-center">Hiển thị</th>
								<th class="text-center">Thao tác</th>
				            </tr>
				         </thead>
				         <tbody>
				         	@foreach($itemShow as $k=>$v)
				            <tr>
								<td class="dev-item-checkbox align-middle text-center">
									<div class="icheck-primary d-inline dev-check">
				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="{{$v['id']}}">
				                        <label for="checkItem-{{$v['id']}}"></label>
				                    </div>
								</td>
								<td class="dev-item-stt">
									<input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="{{$v['stt']}}" data-id="{{$v['id']}}" data-model="productOption" data-level="man">
								</td>

								@if(isset($config[$type]['show_images_option']) && $config[$type]['show_images_option'] == true)
									@php
			   							$path_upload = (config('config_all.fileupload')) ? config('config_upload.UPLOAD_GALLERY') : config('config_upload.UPLOAD_PRODUCT');
			   						@endphp
									<td class="dev-item-img"><a href="{{route('admin.productOption.edit',['man',$type,$v['id']])}}"><img src="{{ $path_upload.$v['photo'] }}" onerror=src="{{asset('img/noimage.png')}}" alt="image"></a></td>
								@endif

								<td class="dev-item-name">
									<a href="{{route('admin.productOption.edit',['man',$type,$v['id']])}}">
										{{$v['tenvi']}}
										<p style="margin:0">
											<span class="text-danger">Giá: {{($v['giamoi']>0) ? Helper::Format_Money($v['giamoi']) : (($v['gia']>0) ? Helper::Format_Money($v['gia']) : 'Liên hệ' )}}</span>
											@if($v['giamoi']>0)<span class="ml-2" style="color:#999;text-decoration: line-through;">{{Helper::Format_Money($v['gia'],0,',','.')}}đ</span>@endif
										</p>
									</a>
									<p style="font-size:13px;color:#999;">Mã SP: {{$v['masp']}}</p>
								</td>

								@if(config('config_all.order.soluong') || config('lazada.active'))
								<td class="align-middle text-center"><strong class="text-danger">
									{{-- 
										{{ $v->soluong_website + $v->soluong_lazada + $v->soluong_shopee }}
										--}}
									{{ $v->soluong }}
								</strong></td>
								@endif

								{{-- 
									<td class="align-middle text-center">{{ (isset($v->ColorOption->tenvi)) ? $v->ColorOption->tenvi : '' }}</td>
									--}}

								<td class="align-middle text-center">{{ (isset($v->SizeOption->tenvi)) ? $v->SizeOption->tenvi : '' }}</td>

								<td class="align-middle text-center dev-item-display show-checkbox">
                                	<div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input" data-model="productOption" data-level="man" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                        <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                    </div>
                                </td>

                                <td class="dev-item-option align-middle text-center">
									<div class="dropdown show">
									  <a class="btn-dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									    <i class="fas fa-ellipsis-v" ></i>
									  </a>

									  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">									  	
									    <a class="btn btn-sm d-block btn-none-css" href="{{route('admin.productOption.edit',['man',$type,$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i> Chỉnh sửa</a>
											<a class="btn btn-sm d-block delete-item btn-none-css" data-url="{{route('admin.productOption.delete',['man',$type,$v['id'],'id_product'=>$idParent])}}" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa</a>
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
