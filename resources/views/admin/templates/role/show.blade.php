@extends('admin.master')

@section('content')
	@csrf
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.role.edit') }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
		<a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.role.deleteAll') }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
		<div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.role.show') }}')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.role.show') }}')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách quyền người dùng</h3>
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
                        <th class="align-middle text-center" width="10%">STT</th>
                        <th class="align-middle">Tiêu đề</th>
						<th class="align-middle text-center dev-item-display">Hiển thị</th>
                        <th class="align-middle text-center dev-item-display">Thao tác</th>
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
				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="{{ $v['id'] }}">
				                        <label for="checkItem-{{$v['id']}}"></label>
				                    </div>
								</td>
                                <td class="align-middle dev-item-stt">
									<input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="{{$v['stt']}}" data-id="{{$v['id']}}" data-model="roles" data-level="">
								</td>
                                <td class="align-middle">
                                    <a class="text-dark" href="{{route('admin.role.edit',[$v['id']])}}" title="{{$v['role_name']}}">{{$v['role_name']}}</a>
                                </td>
								<td class="align-middle text-center dev-item-display show-checkbox">
                                	<div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input" data-model="roles" data-level="man" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                        <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle text-center dev-item-display">
									<a class="btn btn-sm btn-light btn-edit-color" href="{{route('admin.role.edit',[$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>
									<a class="btn btn-sm btn-danger delete-item" data-url="{{route('admin.role.delete',[$v['id']])}}" title="Xóa"><i class="fas fa-trash-alt"></i></a>
								</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.role.edit') }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
      <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.role.deleteAll') }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
    </div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
