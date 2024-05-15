@extends('admin.master')

@section('content')
	@csrf
	<div class="card-footer sticky-top">
		<a class="text-white btn btn-sm bg-gradient-primary" href="{{ route('admin.places.edit',['list']) }}" title="Thêm mới"><i class="mr-2 fas fa-plus"></i>Thêm mới</a>
		<a class="text-white btn btn-sm bg-gradient-danger" id="delete-all" data-url="{{ route('admin.places.deleteAll', ['list']) }}" title="{{ __('Xóa tất cả') }}"><i class="mr-2 far fa-trash-alt"></i>{{ __('Xóa tất cả') }}</a>
		<div class="ml-3 align-middle form-inline form-search d-inline-block">
            <div class="input-group input-group-sm">
                <input class="text-sm form-control form-control-navbar" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.places.show',['list']) }}')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="text-white btn btn-navbar" type="button" onclick="onSearch('keyword','{{ route('admin.places.show',['list']) }}')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">Danh sách tỉnh thành</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
				<div class="row">
				   <div class="col-sm-12">
				      <table class="table table-hover text-nowrap">
				         <thead>
				            <tr>
								<th class="text-center align-middle">
									<div class="icheck-primary d-inline dev-check">
				                        <input type="checkbox" id="checkAll">
				                        <label for="checkAll"></label>
				                    </div>
								</th>
								<th class="text-center align-middle">STT</th>

								<th>Tiêu đề</th>

								<th class="text-center align-middle">Hiển thị</th>
								<th>Thao tác</th>
				            </tr>
				         </thead>
				         <tbody>
				         	@foreach($itemShow as $k=>$v)
				            <tr>
								<td class="text-center align-middle dev-item-checkbox">
									<div class="icheck-primary d-inline dev-check">
				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="{{$v['id']}}">
				                        <label for="checkItem-{{$v['id']}}"></label>
				                    </div>
								</td>
								<td class="dev-item-stt">
									<input type="number" class="m-auto form-control form-control-mini update-stt" min="0" value="{{$v['stt']}}" data-id="{{$v['id']}}" data-model="places" data-level="list">
								</td>

								<td class="dev-item-name"><a href="{{route('admin.places.edit',['list',$v['id']])}}">{{$v['ten']}}</a></td>

								<td class="text-center align-middle dev-item-display show-checkbox">
                                	<div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input" data-model="places" data-level="list" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                        <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                    </div>
                                </td>

								<td class="dev-item-option">
									<a class="btn btn-sm btn-light btn-edit-color" href="{{route('admin.places.edit',['list',$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>
									<a class="btn btn-sm btn-danger delete-item" data-url="{{route('admin.places.delete',['list',$v['id']])}}" title="Xóa"><i class="fas fa-trash-alt"></i></a>
								</td>
				            </tr>
				            @endforeach
				         </tbody>
				      </table>
				   </div>
				</div>
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
              	<div class="row">
				   <div class="col-sm-12 dev-center dev-paginator">{{ $itemShow->links() }}</div>
				</div>
				<a class="text-white btn btn-sm bg-gradient-primary" href="{{ route('admin.places.edit',['list']) }}" title="Thêm mới"><i class="mr-2 fas fa-plus"></i>Thêm mới</a>
				<a class="text-white btn btn-sm bg-gradient-danger" id="delete-all" data-url="{{ route('admin.places.deleteAll', ['list']) }}" title="{{ __('Xóa tất cả') }}"><i class="mr-2 far fa-trash-alt"></i>{{ __('Xóa tất cả') }}</a>
              </div>
            </div>
		</div>
	</div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
