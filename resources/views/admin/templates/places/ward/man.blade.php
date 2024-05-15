@extends('admin.master')

@section('content')
	@csrf
	<div class="card-footer sticky-top">
		<a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.places.edit',['item']) }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
		<a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.places.deleteAll', ['item']) }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
		<div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.places.show',['item']) }}')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.places.show',['item']) }}')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
	</div>

	<div class="card-footer text-sm bg-light row">
		<div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">{!! Helper::get_places_category('places','list',$request, 'Chọn tỉnh thành') !!}</div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">{!! Helper::get_places_category('places','cat',$request, 'Chọn quận huyện') !!}</div>
    </div>

	<div class="row">
		<div class="col-12">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">Danh sách Phường xã</h3>
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

								<th>Tiêu đề</th>

								<th class="align-middle text-center">Hiển thị</th>
								<th>Thao tác</th>
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
									<input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="{{$v['stt']}}" data-id="{{$v['id']}}" data-model="places" data-level="item">
								</td>

								<td class="dev-item-name"><a href="{{route('admin.places.edit',['item',$v['id']])}}">{{$v['ten']}}</a></td>

								<td class="align-middle text-center dev-item-display show-checkbox">
                                	<div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input" data-model="places" data-level="item" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                        <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                    </div>
                                </td>

								<td class="dev-item-option">
									<a class="btn btn-sm btn-light btn-edit-color" href="{{route('admin.places.edit',['item',$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>
									<a class="btn btn-sm btn-danger delete-item" data-url="{{route('admin.places.delete',['item',$v['id']])}}" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
				<a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.places.edit',['item']) }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
				<a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.places.deleteAll', ['item']) }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
              </div>
            </div>
		</div>
	</div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
